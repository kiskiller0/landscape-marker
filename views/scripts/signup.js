const btn = document.querySelector('input[type="submit"]');
const finput = document.querySelector('input[type="file"]');
// const img = document.querySelector("form img");

btn.addEventListener("click", (e) => {
	e.preventDefault();
	console.log("form submitted!");
	// img.src = finput.value;
	console.log(finput.files[0]);

	let img = finput.files[0];
	let form = new FormData();
	form.append("picture", img, img["name"]);

	fetch("../api/tmpimage.php", {
		method: "POST",
		body: form,
	});
});

// add finput.onchange(fetch => send current image to /tmpimage.php)
