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

// pagination and shit:

const container = document.querySelector("#content");
const content = document.querySelector(".realContent");

let posts = [];

let pageLength = 10;
let currentPage = 1;

for (let i = 0; i < 25; i++) {
	posts.push(`post: ${i}`);
}

function getRenderer(batchSize) {
	// this function generates a renderer function with batchSize as pageSize(how many posts to render maximum, at each time)
	// it has closure on a variable: currentBatch that keeps track of how many posts have rendered up untill now.
	let lastIndex = 0; // index of last element rendered!

	function render(posts) {
		let remaining = posts.slice(lastIndex, posts.length).length;
		let toRender = remaining > batchSize ? batchSize : batchSize - remaining;

		if (toRender < 1) {
			return;
		}

		console.log(
			`rendering ${toRender} posts\nremaining: ${remaining} posts\nPosts:`
		);
		console.log(posts.slice(lastIndex, lastIndex + toRender));

		lastIndex += toRender;
	}
	return render;
}

async function fetchPosts(posts) {
	let form = new FormData();
	form.append("lastPost", posts.slice(-1));
	fetch("api/get_posts.php", {
		method: "post",
		body: form,
	})
		.then((raw) => raw.json())
		.then((jsoned) => {
			console.log(jsoned);
		})
		.catch((err) => {
			console.log(`err: ${err}`);
		});
}

const getNewPosts = getRenderer(6);

// first render if posts is not empty:
getNewPosts(posts);

// TODO:
// make the render function renders all posts form current index to tha last item
// no need to make the user wait for locally available data! - redundancy!
container.addEventListener("scroll", (e) => {
	// TODO:
	// []- when the event is triggered, stop listening for 3s, and then re-attach the event
	// to stop requesting more than one page's worth of posts if you happen to hit the bottom
	// twice or more before new posts render

	// first, fetch another n posts to add them to posts:
	fetchPosts(posts);

	if (
		// scrollTop = scrollHeight - offsetHeight
		container.scrollTop + container.offsetHeight >
		container.scrollHeight - 20
	) {
		console.log(`end`);
		// render next n posts from posts, if not, fetch new n posts:
		getNewPosts(posts);
	}
});

container.addEventListener("click", (e) => {
	console.log(`click!`);
});
console.log(`offset height: ${container.offsetHeight}`);
