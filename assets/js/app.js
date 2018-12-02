import Places from 'places.js';
import Map from './modules/map';
import 'slick-carousel';
import 'selectize.js';
import '../css/app.css';
import 'slick-carousel/slick/slick.css'
import 'slick-carousel/slick/slick-theme.css'
import '../css/selectize.bootstrap4.css';

Map.init();

let inputAddress = document.querySelector('#property_address');
if (inputAddress !== null) {
    let place = Places({
        container: inputAddress
    });
    place.on('change', e => {
        document.querySelector('#property_city').value = e.suggestion.city;
        document.querySelector('#property_postal_code').value = e.suggestion.postcode;
        document.querySelector('#property_lat').value = e.suggestion.latlng.lat;
        document.querySelector('#property_lng').value = e.suggestion.latlng.lng
    })
}

let searchLocation = document.querySelector('#search_location');
if (searchLocation !== null) {
    let place = Places({
        container: searchLocation
    });
    place.on('change', e => {
        document.querySelector('#lat').value = e.suggestion.latlng.lat;
        document.querySelector('#lng').value = e.suggestion.latlng.lng
    })
}

let $ = require('jquery');

$('[data-slider]').slick({
    dots: true,
    arrows: true
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
