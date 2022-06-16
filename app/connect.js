document.addEventListener('DOMContentLoaded', function() {


const form = document.querySelector(('#sign-in-form'));
form.addEventListener('submit', function(event) {

    event.preventDefault();

    const data = new URLSearchParams();

    for(let p of new FormData(form)) {
        data.append(p[0], p[1]);
    }


    const headers = {
        method: 'POST',
        body: data
    };
    fetch('../include/server.php', headers)
    .then(response => response.text())
    .then(data => {
        document.querySelector('.msg').innerHTML = data;
    })
    .catch(error => console.error(error));
});


});