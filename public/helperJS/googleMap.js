/**
 * Google maps configure
 */
var marker;



function initialize() {
    initAutocomplete();
    initMap();

}
//Init map, event click map, event change lat, long
function initMap() {
    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        zoom: 16,
        center: {lat: 21.0031177, lng: 105.82014},
        // disableDoubleClickZoom: true,
    });

    var geocoder = new google.maps.Geocoder;
    var infowindow = new google.maps.InfoWindow;



    //Change Lat, long
    document.getElementById('longitude').addEventListener('change', function(){
        geocodeLatLng(geocoder, map, infowindow);
    });

    document.getElementById('latitude').addEventListener('change', function(){
        geocodeLatLng(geocoder, map, infowindow);
    });

    //Event click on map
    map.addListener('click', function(e) {
        placeMarkerAndPanTo(e.latLng, map, geocoder, infowindow);
    });

}

//Init input autocompte
function initAutocomplete() {
    autocomplete = new
    google.maps.places.Autocomplete((document.getElementById('autocomplete')),
        {
            types: ['geocode'],
            // componentRestrictions: {
            //     country: 'vn'
            // }
        });
    autocomplete.addListener('place_changed', fillInAddress);
}


//Event handle Click
function placeMarkerAndPanTo(latLng, map, geocoder, infowindow) {

    if(typeof marker!= 'undefined')
        marker.setMap(null);

    marker = new google.maps.Marker({
        position: latLng,
        map: map
    });

    geocoder.geocode({'location': latLng}, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                //Fill Text address input
                $('#autocomplete').val(results[0].formatted_address);
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
    $('#longitude').val(latLng.lng);
    $('#latitude').val(latLng.lat);

    map.panTo(latLng);
}

//Event handle change lat, log
function geocodeLatLng(geocoder, map, infowindow) {
    var lat = parseFloat(document.getElementById('latitude').value);
    var lng = parseFloat(document.getElementById('longitude').value);
    var latlng = {lat: lat, lng: lng};

    geocoder.geocode({'location': latlng}, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                var map = new google.maps.Map(document.getElementById('map-canvas'), {
                    zoom: 16,
                    center: {lat: lat, lng: lng}
                });

                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
                map.addListener('click', function(e) {
                    placeMarkerAndPanTo(e.latLng, map, geocoder);
                });
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);

                //Fill Text address input
                $('#autocomplete').val(results[0].formatted_address);
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
}

function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}

function fillInAddress() {
    var place = autocomplete.getPlace();
    var lng, lat;

    lat = document.getElementById('latitude').value = place.geometry.location.lat();
    lng = document.getElementById('longitude').value = place.geometry.location.lng();


    var uluru = {lat: lat, lng: lng};

    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        zoom: 16,
        center: uluru
    });

    var geocoder = new google.maps.Geocoder;
    map.addListener('click', function(e) {
        placeMarkerAndPanTo(e.latLng, map, geocoder);
    });


    var marker = new google.maps.Marker({
        position: uluru,
        map: map,
        title: ''
    });

}




