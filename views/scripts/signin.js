const msgOverlay = document.querySelector('.msgOverlay');
const msgBox = document.querySelector('.msg');

const form = document.querySelector('form');

form.addEventListener('submit', e => {
    console.log(`submitting!`);
    e.preventDefault()
    f();
});

function f() {
    fetch('../api/login.php', {
        method: 'post',
        body: new FormData(form)
    })
        .then(raw => raw.json())
        .then(json => {
            if (json.error) {
                msgOverlay.classList.remove('hidden');
                msgOverlay.classList.add('error');
                msgBox.innerText = json.msg;
            } else {
                // msgOverlay.classList.add('hidden');
                msgBox.innerText = 'Logged In Successfully!';
                msgOverlay.classList.remove('error');
            }
        })
        .catch(err => {
            console.log(err)
        })
}


