let darkModeBtn = document.querySelector("#check-5");
let section = document.querySelector("section");
let nav = document.querySelector("nav");
let body = document.querySelector("body");

const savedMode = localStorage.getItem("Mode");
if(savedMode !== undefined || savedMode !== null){
  darkModeBtn.checked = savedMode === 'light';
  if(darkModeBtn.checked){
    body.classList.add('light-mode');
  }else{
    body.classList.add('dark-mode');
  }
}


addEventListener('change', function(){
  let value = darkModeBtn.checked ? 'light' : 'dark';

  if (darkModeBtn.checked){
    console.log("light");
    body.classList.add('light-mode');
    body.classList.remove('dark-mode');
  }
  else {
    console.log("dark");
    body.classList.remove("light-mode");
    body.classList.add("dark-mode");
  }

  localStorage.setItem("Mode", value)
})