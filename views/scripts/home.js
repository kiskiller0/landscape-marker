let x = document.querySelector(".blog .controls .clickable");
let addBlog = document.querySelector(".page #footer .clickable");
let blogPopup = document.querySelector(".blog.popup");
let globalBlur = document.querySelector(".popup_background");

x.addEventListener("click", (e) => {
	blogPopup.classList.add("hidden");
	globalBlur.classList.add("hidden");
});

addBlog.addEventListener("click", (e) => {
	blogPopup.classList.remove("hidden");
	globalBlur.classList.remove("hidden");
});
