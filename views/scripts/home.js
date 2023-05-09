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
		// this.fetchNext("api/get_last_posts.php");
		// if no local posts, fetch!
		// this.getLocalPosts() || this.fetchNext();
		// this.getLocalPosts(); this.fetchNext();
		// first, get last n posts to begin with:
		this.fetchNext("api/get_last_posts.php");
		// extract previously saved posts from local storage:
	}

	getLocalPosts() {
		// window.localStorage.get('posts'); // stringify / unstringify logic!
		return false;
	}

	fetchNext(url = this.api) {
		// this fetches n posts at maximum, n is defined server-side
		let form = new FormData();
		if (this.content.length > 0) {
			form.append("id", this.content.slice(-1)[0].id);
			console.log(this.content.slice(-1)[0].id || "no id!");
		}
		console.log(`last element:`);
		fetch(url, {
			method: "post",
			body: form,
			header: {},
		})
			// .then((raw) => raw.text())
			.then((posts) => {
				// console.log(posts);
				return posts.json();
			})
			.then((decoded) => {
				if (decoded.error) {
					console.log(`error! ${decoded.msg}`);
					return;
				}
				console.log(url);
				console.log(decoded);
				this.content = [
					...this.content,
					// ...decoded.posts.filter((serialized) => JSON.parse(serialized[0])),
					...decoded.posts,
				];
				// calling render:

				this.render();
			})
			.catch((err) => {
				console.log(`unhandled error in the fetchPosts api!`);
				console.log(err);
			});
	}

	render() {
		// this is supposed to render this.posts to this.div
		// for testing reasons, it is just gonna print from last post!
		console.log("rendering ...");
		if (this.content.length == this.lastPostIndex) {
			return;
		}

		console.log(this.content.slice(this.lastPostIndex, this.content.length));

		// actual rendering to page:
		console.log("rendering ...");
		for (let post of this.content.slice(
			this.lastPostIndex,
			this.content.length
		)) {
			let p = document.createElement("p");
			p.innerHTML = post.id + " " + post.content + " " + post.date;
			let postDiv = document.createElement("div");
			postDiv.classList.add("post");
			let img = document.createElement("img");
			img.src = `/public/posts/${post.id}`;
			img.classList.add("postImage");
			postDiv.appendChild(p);
			postDiv.appendChild(img);
			postDiv.appendChild(document.createElement("hr"));
			this.div.appendChild(postDiv);
		}

		this.lastPostIndex = this.content.length;
	}
}

const myPosts = new PostSet(document.getElementsByClassName("realContent")[0]);

// myPosts.render();
myPosts.fetchNext();

// TODO:
// []- make the render function renders all posts form current index to tha last item
// no need to make the user wait for locally available data! - useless bottlenck!
container.addEventListener("scroll", (e) => {
	// TODO:
	// []- when the event is triggered, stop listening for 3s, and then re-attach the event
	// to stop requesting more than one page's worth of posts if you happen to hit the bottom
	// twice or more before new posts render
	// []- (maybe) turn the trigger to: hovering over the last element, rather than scrolling down to the last element!
	if (
		// scrollTop = scrollHeight - offsetHeight
		container.scrollTop + container.offsetHeight >
		container.scrollHeight - 20
	) {
		myPosts.fetchNext();
		myPosts.render();
	}
});
