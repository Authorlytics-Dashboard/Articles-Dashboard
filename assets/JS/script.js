let darkModeBtn = document.querySelector("#check-5");
let section = document.querySelector("section");
let nav = document.querySelector("nav");
let body = document.querySelector("body");
let navUl = document.querySelector("nav ul");
let navLinks = document.querySelectorAll("nav li a");
let mennueBtn = document.querySelector(".menu-btn");
let backBtn = document.querySelector(".back-btn");

const savedMode = localStorage.getItem("Mode");
if (savedMode !== undefined || savedMode !== null) {
  darkModeBtn.checked = savedMode === "light";
  if (darkModeBtn.checked) {
    body.classList.add("light-mode");
  } else {
    body.classList.add("dark-mode");
  }
}

const clickedLink = window.location.href.split("/")[3];
navLinks.forEach((link) => {
  if (link.classList.contains(clickedLink)) {
    link.classList.add("active");
  }
});

darkModeBtn.addEventListener("change", function () {
  let value = darkModeBtn.checked ? "light" : "dark";

  if (darkModeBtn.checked) {
    body.classList.add("light-mode");
    body.classList.remove("dark-mode");
  } else {
    body.classList.remove("light-mode");
    body.classList.add("dark-mode");
  }

  localStorage.setItem("Mode", value);
});

mennueBtn.addEventListener("click", () => {
    nav.style.transform = "translateX(0) ";
});

backBtn.addEventListener("click", () => {
    nav.style.transform = "translateX(-100%) ";
});
