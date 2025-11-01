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

document.querySelectorAll(".toggle-password").forEach((toggle) => {
  toggle.addEventListener("click", function () {
    const targetId = this.getAttribute("data-target");
    const input = document.getElementById(targetId);
    if (input.type === "password") {
      input.type = "text";
      this.innerHTML = '<i class="fa fa-eye-slash"></i>';
    } else {
      input.type = "password";
      this.innerHTML = '<i class="fa fa-eye"></i>';
    }
  });
});
document.addEventListener("DOMContentLoaded", () => {
  const userToggle = document.getElementById("userToggle");
  const dropdown = document.getElementById("dropdownMenu");

  if (userToggle && dropdown) {
    userToggle.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("show");
      userToggle.setAttribute(
        "aria-expanded",
        dropdown.classList.contains("show")
      );
      dropdown.setAttribute("aria-hidden", !dropdown.classList.contains("show"));
    });

    document.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target) && !userToggle.contains(e.target)) {
        dropdown.classList.remove("show");
        userToggle.setAttribute("aria-expanded", "false");
        dropdown.setAttribute("aria-hidden", "true");
      }
    });
  }
});
// ==================== SEARCH BAR ====================
const openSearch = document.getElementById("openSearch");
const searchBar = document.getElementById("searchBar");

if (openSearch && searchBar) {
  openSearch.addEventListener("click", (e) => {
    e.stopPropagation();
    searchBar.classList.toggle("show");
    const input = document.getElementById("searchInput");
    if (input && searchBar.classList.contains("show")) {
      input.focus();
    }
  });

  document.addEventListener("click", (e) => {
    if (!searchBar.contains(e.target) && e.target !== openSearch) {
      searchBar.classList.remove("show");
    }
  });
}
