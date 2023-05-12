// const btn = document.querySelector('input[type="submit"]');
// const finput = document.querySelector('input[type="file"]');
// const img = document.querySelector("form img");

// btn.addEventListener("click", (e) => {
// 	e.preventDefault();
// 	console.log("form submitted!");
// 	img.src = finput.value;
// });

const form = document.querySelector('form')
fetch('../api/login.php', {
    method: 'post',
    body: form
})
    .then(raw => raw.json())
    .then(json => console.log(json))
    .catch(err => {
        console.log(err)
    })