(function () {
  const canvas = document.querySelector(".fireworks");
  if (!canvas) return;
  const ctx = canvas.getContext("2d");

  function resize() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    canvas.style.width = window.innerWidth + "px";
    canvas.style.height = window.innerHeight + "px";
  }
  window.addEventListener("resize", resize);
  resize();

  const config = {
    colorsLight: ["252, 146, 174", "202, 180, 190", "207, 198, 255"],
    colorsDark: ["252, 146, 174", "202, 180, 190", "207, 198, 255"],
    darkMode: false,
    numberOfParticles: 20,
    orbitRadius: {
      min: 50,
      max: 100,
    },
    circleRadius: {
      min: 10,
      max: 20,
    },
    diffuseRadius: {
      min: 50,
      max: 100,
    },
    animeDuration: {
      min: 900,
      max: 1500,
    },
  };

  function getColors() {
    return config.darkMode ? config.colorsDark : config.colorsLight;
  }

  function createParticle(x, y, colors) {
    const angle = (anime.random(0, 360) * Math.PI) / 180;
    const radius = anime.random(
      config.diffuseRadius.min,
      config.diffuseRadius.max
    );
    const sign = anime.random(0, 1) === 0 ? -1 : 1;

    return {
      x: x,
      y: y,
      color: `rgba(${colors[anime.random(0, colors.length - 1)]},${anime
        .random(0.2, 0.8)
        .toFixed(2)})`,
      radius: anime.random(config.circleRadius.min, config.circleRadius.max),
      angle: anime.random(0, 360),
      endPos: {
        x: x + sign * radius * Math.cos(angle),
        y: y + sign * radius * Math.sin(angle),
      },
      draw(ctx) {
        ctx.save();
        ctx.translate(this.x, this.y);
        ctx.rotate((this.angle * Math.PI) / 180);
        ctx.beginPath();
        ctx.moveTo(0, -this.radius);
        ctx.lineTo(
          this.radius * Math.sin(Math.PI / 3),
          this.radius * Math.cos(Math.PI / 3)
        );
        ctx.lineTo(
          -this.radius * Math.sin(Math.PI / 3),
          this.radius * Math.cos(Math.PI / 3)
        );
        ctx.closePath();
        ctx.fillStyle = this.color;
        ctx.fill();
        ctx.restore();
      },
    };
  }

  function createCircle(x, y, darkMode) {
    return {
      x: x,
      y: y,
      color: darkMode ? "rgb(233, 179, 237)" : "rgb(106, 159, 255)",
      radius: 0.1,
      alpha: 0.5,
      lineWidth: 6,
      draw(ctx) {
        ctx.globalAlpha = this.alpha;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, 2 * Math.PI, true);
        ctx.lineWidth = this.lineWidth;
        ctx.strokeStyle = this.color;
        ctx.stroke();
        ctx.globalAlpha = 1;
      },
    };
  }

  function renderParticle(anim) {
    anim.animatables.forEach((animatable) => {
      const target = animatable.target;
      if (typeof target.draw === "function") {
        target.draw(ctx);
      }
    });
  }

  function animateParticles(x, y) {
    const colors = getColors();
    const circle = createCircle(x, y, config.darkMode);
    const particles = Array.from(
      {
        length: config.numberOfParticles,
      },
      () => createParticle(x, y, colors)
    );

    anime
      .timeline()
      .add({
        targets: particles,
        x(p) {
          return p.endPos.x;
        },
        y(p) {
          return p.endPos.y;
        },
        radius: 0,
        duration: anime.random(
          config.animeDuration.min,
          config.animeDuration.max
        ),
        easing: "easeOutExpo",
        update: renderParticle,
      })
      .add(
        {
          targets: circle,
          radius: anime.random(config.orbitRadius.min, config.orbitRadius.max),
          lineWidth: 0,
          alpha: {
            value: 0,
            easing: "linear",
            duration: anime.random(600, 800),
          },
          duration: anime.random(1200, 1800),
          easing: "easeOutExpo",
          update: renderParticle,
        },
        0
      );
  }

  anime({
    duration: Infinity,
    update: function () {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    },
  });

  window.addEventListener("mousedown", (e) => {
    animateParticles(e.clientX, e.clientY);
  });
})();
