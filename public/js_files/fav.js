const button = document.querySelector(".fav");
const parag = document.querySelector(".text");

button.addEventListener("click", () => {
  if (button.classList.contains("selected")) {
    button.classList.remove("selected");
    parag.innerHTML = "Save";
  } else {
    button.classList.add("selected");
    parag.innerHTML = "Remove";
  }
});