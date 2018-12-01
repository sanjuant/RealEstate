/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
let $ = require('jquery');
require('../css/app.css');
require('select2');

$('select').select2();

let $contactButton = $('#contact-button');
$contactButton.click(e => {
    e.preventDefault();
    $('#contact-form').slideDown();
    $contactButton.slideUp();
});

// Delete elements picture
document.querySelectorAll('[data-delete]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault();
        fetch(a.getAttribute('href'), {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({'_token': a.dataset.token})
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    a.parentNode.parentNode.removeChild(a.parentNode)
                } else {
                    alert(data.error);
                }
            })
            .catch(e => alert(e));
    });
});

console.log('https://sanjuant.fr');
