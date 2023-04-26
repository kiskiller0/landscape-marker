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

// getting posts:

// fetch("api/get_all_posts.php", {
// 	method: "POST",
// })
// 	.then((data) => data.json())
// 	.then((jsoned) => {
// 		console.log(jsoned);
// 	})
// 	.catch((err) => {
// 		console.error(err);
// 	});

// pagination:

localStorage.setItem("page", 1);

fetch("api/test.php", {
	method: "POST",
	body: {
		page: localStorage.getItem("page"),
	},
})
	.then((data) => {
		// console.log(data);
		return data.json();
	})
	.then((j) => console.log(j))
	.catch((err) => {
		console.log(err);
	});
