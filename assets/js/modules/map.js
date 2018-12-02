import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

export default class Map {

    static init() {
        let map = document.querySelector('#map');
        if (map === null) {
            return;
        }
        let icon = L.icon({
            iconUrl: '/images/marker-icon.png',
        });
        let center = [map.dataset.lat, map.dataset.lng];
        map = L.map('map').setView(center, 14);
        let token = 'pk.eyJ1Ijoic29ycm93ODEiLCJhIjoiY2pwNnVmNTk0MTVhbTNrcWYydzNiYXViYyJ9.iikA8tm-Pu4tT68onhhkrg';
        L.tileLayer(`https://api.mapbox.com/v4/mapbox.streets/{z}/{x}/{y}.png?access_token=${token}`, {
            maxZoom: 18,
            minZoom: 10,
            attribution: ' © <a href=\'https://www.mapbox.com/about/maps/\'>Mapbox</a> © <a href=\'http://www.openstreetmap.org/copyright\'>OpenStreetMap</a> <strong><a href=\'https://www.mapbox.com/map-feedback/\' target=\'_blank\'>Improve this map</a></strong>'
        }).addTo(map);
        L.marker(center,{icon: icon}).addTo(map);
    }
}