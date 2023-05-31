let globalBlur = document.querySelector(".popup_background");

function makePopup(activateButton, popupWindow, closeButton) {
    if (activateButton == null || popupWindow == null || closeButton == null) {
        return
    }
    closeButton.addEventListener("click", (e) => {
        popupWindow.classList.add("hidden");
        globalBlur.classList.add("hidden");
    });

    activateButton.addEventListener("click", (e) => {
        popupWindow.classList.remove("hidden");
        globalBlur.classList.remove("hidden");
    });
}

makePopup(document.querySelectorAll("#footer .clickable")[0], document.querySelector("#add_post"), document.querySelector("#add_post .controls .clickable"))
makePopup(document.querySelectorAll("#footer .clickable")[1], document.querySelector("#add_place"), document.querySelector("#add_place .controls .clickable"))
makePopup(document.querySelectorAll("#footer .clickable")[2], document.querySelector("#add_event"), document.querySelector("#add_event .controls .clickable"))
makePopup(document.querySelector("#functions .parameters"), document.querySelector("#parameters.popup"), document.querySelector("#parameters .controls .clickable"))

const container = document.querySelector("#content");
// const content = document.querySelector(".realContent");
// refactoring the post fetching logic into one class:

class PostSet {
    content = [];
    api = "api/get_posts.php";
    div = null; // where posts are gonna be injected/rendered as html elements
    lastPostIndex = 0; // no need for a function closure now!
    fetchPending = false; // this is to avoid race condition (calling multiple fetchs=> fetch same posts again!
    constructor(div) {
        if (div == null) {
            return;
        }
        this.div = div;
        // if no local posts, fetch!
        // this.getLocalPosts() || this.fetchNext();
        // this.getLocalPosts(); this.fetchNext();
        // first, get last n posts to begin with:
        this.fetchNext();
        // extract previously saved posts from local storage:
    }

    getLocalPosts() {
        // window.localStorage.get('posts'); // stringify / un-stringify logic!
        return false;
    }

    fetchNext(url = this.api) {
        if (this.fetchPending) {
            return;
        }

        this.fetchPending = true;
        // this fetches n posts at maximum, n is defined server-side
        let form = new FormData();
        if (this.content.length > 0) {
            form.append("id", this.content.slice(-1)[0].id);
            console.log(`last element:`);
            console.log(this.content.slice(-1)[0].id || "no id!");
        }
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
                this.fetchPending = false;
                this.render();
            })
            .catch((err) => {
                console.log(`unhandled error in the fetchPosts api!`);
                console.log(err);
                this.fetchPending = false;
            });
    }

    render() {
        // this is supposed to render this.posts to this.div
        // for testing reasons, it is just going to print from last post!
        console.log("rendering ...");
        if (this.content.length === this.lastPostIndex) {
            return;
        }

        console.log(this.content.slice(this.lastPostIndex, this.content.length));

        // actual rendering to page:
        console.log("rendering ...");

        // TODO: replace this outdated way of rendering with a newer, template-based method
        for (let post of this.content.slice(
            this.lastPostIndex,
            this.content.length
        )) {

            let userDiv = document.createElement('div')
            userDiv.classList.add('userDiv')

            let username = document.createElement('p')
            username.classList.add('username')

            let userImg = document.createElement('img')
            userImg.classList.add('userImg')

            username.innerHTML = post.user.username
            // userImg.src = `/public/profiles/` + (post.user.picture ? post.user.username : 'user.png')
            userImg.src = `/public/profiles/` + (post.user.picture ? post.user.username : 'default/user.png')

            userDiv.appendChild(userImg)
            userDiv.appendChild(username)

            let postContent = document.createElement('p')
            postContent.innerHTML = post.content || "content undefined!";
            postContent.classList.add('postContent')

            let postDate = document.createElement('p')
            postDate.innerHTML = post.date || "date undefined!";
            postDate.classList.add('postDate')

            let img = document.createElement('img')
            img.src = `public/posts/${post.id}`

            let postContainer = document.createElement('div');
            postContainer.classList.add('post')


            postContainer.appendChild(userDiv)
            postContainer.appendChild(postContent)
            postContainer.appendChild(img)
            postContainer.appendChild(postDate)
            postContainer.appendChild(document.createElement('hr'))

            this.div.appendChild(postContainer)
            // TODO: I'm going to alter this rendering method
        }

        this.lastPostIndex = this.content.length;
    }
}

const myPosts = new PostSet(document.getElementsByClassName("realContent")[0]);

// TODO:
// []- make the render function renders all posts form current index to tha last item
// no need to make the user wait for locally available data! - useless bottleneck!
if (container != null) {
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
}

// adding the user img:

fetch('api/whoami.php', {
    method: 'post'
})
    .then(raw => raw.json())
    .then(jsoned => {
        document.querySelector('.userImg').src = jsoned.user.picture ? `public/profiles/${jsoned.user.username}` : `public/profiles/default/user.png`;
    })
    .catch(err => {
        console.log(`error fetching profile picture: ${err}`)
    })


// add the serch functionality:

function addSearchFunctionality(textField, searchButton) {
    searchButton.addEventListener('click', (e) => {
        let input = textField.value;
        window.open(window.location.origin + `/api/search.php/?search=${input}`);
    })

    textField.addEventListener('keydown', e => {
        if (e.code != 'Enter') {
            return
        }
        let input = textField.value;
        window.open(window.location.origin + `/api/search.php/?search=${input}`);
    });
}

// adding it to the search bar
let searchField = document.querySelector('.search>input');
let searchIcon = document.querySelector('.bar>i');

if (searchIcon != null && searchField != null) {
    console.log('added search functionality 1')
    addSearchFunctionality(searchField, searchIcon)
} else {
    console.log(`baka1`)
}


//TODO:
// []- search.php: (make them ordered by id)

// add_place
const addPlaceForm = document.querySelector('#add_place form');

addPlaceForm.addEventListener('submit', e => {
    e.preventDefault();
    fetch('./api/add_place.php', {
        method: 'post',
        body: new FormData(addPlaceForm)
    })
        .then(raw => raw.json())
        .then(jsoned => {
            console.log(jsoned)
        })
        .catch(err => {
            console.log(err);
        })
});

// dark mode:


const toggle = document.querySelector('.darkmode i');
let nightMode = "fa-solid fa-moon";
let dayMode = "fa-solid fa-lightbulb";
toggle.classList.add(...dayMode.split(' '));
let state = false;

toggle.addEventListener('click', e => {
    if (state) {
        // assume day mode as default?
        toggle.classList.remove(...nightMode.split(' '));
        toggle.classList.add(...dayMode.split(' '));
    } else {
        toggle.classList.remove(...dayMode.split(' '));
        toggle.classList.add(...nightMode.split(' '));
    }

    state = !state;

    document.querySelector('.page').classList.toggle('darkmode');
})