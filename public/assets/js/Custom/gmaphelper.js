/**
 * Created by Nico on 28/03/2016.
 */

(function(){
    this.CivicApp = this.CivicApp || {};
    this.CivicApp.GmapHelper = this.CivicApp.GmapHelper || new function(){
        var map = null ;
        var geocoder = null;

        var InitializeMap = function()
        {
            var centerLocation = codeAdress("Córdoba, Córdoba, Argentina");



            centerLocation.then(
                function(center){
                    map  = new google.maps.Map(document.getElementById('map'), {
                        zoom: 12,
                        center: center
                    });
                    AddUserLocationInfoWindows();

                   /* var mapStyle = [
                        {
                            "stylers": [
                                { "visibility": "on" },
                                { "saturation": 1 },
                                { "weight": 1.5 },
                                { "lightness": -11 },
                                { "gamma": 0.68 },
                                { "hue": "#08ff00" }
                            ]
                        }
                    ];
                    map.setOptions({styles:mapStyle});*/

                },
                function() {
                    map  = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12
                    });
                    AddUserLocationInfoWindows();

                    map.setOptions(mapStyle);

                });
        };


        var AddUserLocationInfoWindows = function()
        {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    debugger;
                    var location = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var infoWindow = new google.maps.InfoWindow({map: map});
                    infoWindow.setPosition(location);
                    infoWindow.setContent('Usted está aquí');

                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            }
        };

        var  handleLocationError = function (browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
        }

        var codeAdress = function(address)
        {
            var deferred = $.Deferred();

            if(!geocoder)
                geocoder = new google.maps.Geocoder();

            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                   var location = results[0].geometry.location;
                    deferred.resolve(location);

                } else {
                    deferred.reject("Geocode was not successful for the following reason: " + status);

                }
            });


            return deferred.promise();

        };

        return {
                InitMap: InitializeMap

        };


    };

}());





CivicApp.GmapHelper.AutocompleteChange = function()
{

        var place = placesAutocomplete.getPlace();
        if (place.geometry) {
            map.panTo(place.geometry.location);
            map.setZoom(18);
        } else {
            document.getElementById('autocompleteMap').placeholder = 'Ingrese Ubicación';
        }

}

