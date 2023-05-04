// popup window logic:

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

const container = document.querySelector("#content");
const content = document.querySelector(".realContent");

// refactoring the post fetching logic into one class:

class PostSet {
	content = [];
	api = "api/get_posts.php";
	div = null; // where posts are gonna be injected/rendered as html elements
	lastPostIndex = 0; // no need for a function closure now!

	constructor(div) {
		this.div = div;
		this.fetchNext("api/get_last_posts.php");
		// if no local posts, fetch!
		this.getLocalPosts() || this.fetchNext();
		// this.getLocalPosts(); this.fetchNext();
		// extract previously saved posts from local storage:
	}

	getLocalPosts() {
		// window.localStorage.get('posts'); // stringify / unstringify logic!
		return false;
	}

	fetchNext(url = this.api) {
		// this fetches n posts at maximum, n is defined server-side
		let form = new FormData();
		form.append("id", this.content.slice(-1)["id"]);
		fetch(url, {
			method: "post",
			body: form,
			header: {},
		})
			.then((posts) => posts.json())
			.then((decoded) => {
				console.log(url);
				console.log(decoded);
				this.content = [...this.content, ...decoded.posts];
			})
			.catch((err) => {
				console.log(`unhandled error in the fetchPosts api!`);
				console.log(err);
			});
	}

	render() {
		// this is supposed to render this.posts to this.div
		// for testing reasons, it is just gonna print from last post!
		if (this.content.length == this.lastPostIndex) {
			return;
		}

		console.log(this.content.slice(this.lastPostIndex, this.content.length));
		this.lastPostIndex = this.content.length;
	}
}

const myPosts = new PostSet(document.getElementsByClassName("realContent")[0]);

myPosts.render();
myPosts.fetchNext();

// TODO:
// []- make the render function renders all posts form current index to tha last item
// no need to make the user wait for locally available data! - useless bottlenck!
container.addEventListener("scroll", (e) => {
	// TODO:
	// []- when the event is triggered, stop listening for 3s, and then re-attach the event
	// to stop requesting more than one page's worth of posts if you happen to hit the bottom
	// twice or more before new posts render

	if (
		// scrollTop = scrollHeight - offsetHeight
		container.scrollTop + container.offsetHeight >
		container.scrollHeight - 20
	) {
		myPosts.fetchNext();
		myPosts.render();
	}
});
