const commentForm = document.querySelector('form')


commentForm.addEventListener('submit', e => {
    e.preventDefault();

    const formData = new FormData(commentForm);
    formData.append('postid', new URLSearchParams(window.location.search).get('id'));

    fetch('../../api/add_comment.php', {
        method: "post",
        body: formData
    })
        .then(raw => raw.json())
        .then(jsoned => {
            console.log(jsoned)
        });
})