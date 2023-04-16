const btn = document.querySelector('input[type="submit"]');
const finput = document.querySelector('input[type="file"]');
const img = document.querySelector("form img");

btn.addEventListener("click", (e) => {
	e.preventDefault();
	console.log("form submitted!");
	img.src = finput.value;
});
