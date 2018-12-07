import Map from './modules/map';
import Places from './modules/places';
import 'slick-carousel';
import 'selectize.js';
import '../css/app.css';
import 'slick-carousel/slick/slick.css'
import 'slick-carousel/slick/slick-theme.css'
import '../css/selectize.bootstrap4.css';

Map.init();
Places.init('search', 'location');
Places.init('property', 'address');

let $ = require('jquery');

$('[data-slider]').slick({
    dots: true,
    arrows: true,
    fade: true,
    autoplay: true,
    autoplaySpeed: 7000
});
$('select').selectize();

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
