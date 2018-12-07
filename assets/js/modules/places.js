import P from 'places.js';

export default class Places {

    static init(prefix, field) {
        let inputAddress = document.querySelector(`#${prefix}_${field}`);
        if (inputAddress !== null) {
            let place = P({
                container: inputAddress
            });
            place.on('change', e => {
                document.querySelector(`#${prefix}_city`).value = e.suggestion.city;
                document.querySelector(`#${prefix}_postal_code`).value = e.suggestion.postcode;
                document.querySelector(`#${prefix}_lat`).value = e.suggestion.latlng.lat;
                document.querySelector(`#${prefix}_lng`).value = e.suggestion.latlng.lng
            })
        }
    }
}