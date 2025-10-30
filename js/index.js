const slider = document.querySelector(".slider");
const slides = document.querySelectorAll(".slide");
const prevBtn = document.querySelector(".prev");
const nextBtn = document.querySelector(".next");
let index = 0;

function showSlide(i) {
  if (!slides.length) return;
  index = (i + slides.length) % slides.length;
  slider.style.transform = `translateX(${-index * 100}%)`;
}

// Nút chuyển thủ công
nextBtn.addEventListener("click", () => showSlide(index + 1));
prevBtn.addEventListener("click", () => showSlide(index - 1));
