const btn = document.querySelector('input[type="submit"]');
const finput = document.querySelector('input[type="file"]');
const profileImg = document.querySelector("form img");

btn.addEventListener("click", (e) => {
	// e.preventDefault();
	// console.log("form submitted!");
	// console.log(finput.files[0]);
});

finput.addEventListener("change", (e) => {
	let imgFile = finput.files[0];
	let form = new FormData();
	form.append("picture", imgFile, imgFile["name"]);

	fetch("../api/tmpimage.php", {
		method: "POST",
		body: form,
	})
		.then((data) => {
			return data.json();
		})
		.then((jsoned) => {
			console.log(jsoned);
			profileImg.src = jsoned["tmpImg"];
		})
		.catch((err) => {
			console.log(err);
		});
	console.log(`changed!`);
});

/* #TODO
[*]-add finput.onchange(fetch => send current image to /tmpimage.php)
*/
