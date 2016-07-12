/**
 * Created by Nico on 28/03/2016.
 */

(function(){
    this.CivicApp = this.CivicApp || {};
    this.CivicApp.GmapHelper = this.CivicApp.GmapHelper || new function(){
        var map = null ;
        var geocoder = null;
        var centerMap = null;
        var markers = [];
        var iconsCategory = [];
            iconsCategory["espaciosVerdes"] = "../assets/images/mapicons/tree.png";
            iconsCategory["transito"] = "../assets/images/mapicons/trafficlight.png";

        var autoComplete = null;
        var infowindowMarker = null;
        var individualMarker =null;
        var inputAutocomplete = null;

        var southWest = '-31.471168, -64.278946';
        var northEast = '-31.361003, -64.090805';



        var initializeMap = function(mapCanvas)
        {

           // var deferredInit = $.Deferred();
            if(!mapCanvas)
                mapCanvas = 'map';
            var centerLocation = codeAdress("Córdoba, Córdoba, Argentina");


            centerLocation.then(
                function(center){
                    centerMap = center;
                    map  = new google.maps.Map(document.getElementById(mapCanvas), {
                        zoom: 12,
                        center: center
                    });
                    AddUserLocationInfoWindows();
                    //addDummyMarkers();

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

                });

            //keep a reference to the original setPosition-function
            var fx = google.maps.InfoWindow.prototype.setPosition;

            //override the built-in setPosition-method
            google.maps.InfoWindow.prototype.setPosition = function () {

                //logAsInternal isn't documented, but as it seems
                //it's only defined for InfoWindows opened on POI's
                if (this.logAsInternal) {
                    google.maps.event.addListenerOnce(this, 'map_changed',function () {
                        var map = this.getMap();
                        //the infoWindow will be opened, usually after a click on a POI
                        if (map) {
                            //trigger the click
                            google.maps.event.trigger(map, 'click', {latLng: this.getPosition()});
                        }
                    });
                }
                //call the original setPosition-method
                fx.apply(this, arguments);
            };

            return centerLocation;
        };



        var addEventClickAddMarker = function()
        {
            map.addListener('click', function(event) {

                if(!infowindowMarker)
                    infowindowMarker = new google.maps.InfoWindow();

                if(!individualMarker)
                    individualMarker = new google.maps.Marker({
                        map: map,
                        draggable: true,
                        animation: google.maps.Animation.DROP,
                        anchorPoint: new google.maps.Point(0, -29)
                    });

                infowindowMarker.close();

                individualMarker.setPosition(event.latLng);
                geocodeInverse(event.latLng.lat(), event.latLng.lng()).then(function(address){
                        inputAutocomplete.value = address;
                        $('#'+inputAutocomplete.id).data('latLng', event.latLng.lat()+','+event.latLng.lng())
                        infowindowMarker.setContent(address);
                        infowindowMarker.open(map, individualMarker);
                    },
                    function(msg)
                    {
                        alert(msg);
                    }
                );

            });
        };

        var geocodeInverse = function(lat, lng){
            var deferred = $.Deferred();
            var latLng = {
                lat:parseFloat(lat),
                lng:parseFloat(lng)
            };
            var geocoder = new google.maps.Geocoder;

            geocoder.geocode({'location': latLng }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[1]) {

                        deferred.resolve(results[0].formatted_address);

                    } else {
                        deferred.reject('No results found');
                    }
                } else {
                    deferred.reject("Geocoder failed due to:" + status);
                }
            });
            return deferred.promise();
        };

        var createAutocomplete = function(input)
        {
            var sWest =  southWest.split(',');
            var nEast =  northEast.split(',');

            var defaultBounds = new google.maps.LatLngBounds(
                new google.maps.LatLng( parseFloat(sWest[0]), parseFloat(sWest[1])),
                new google.maps.LatLng( parseFloat(nEast[0]), parseFloat(nEast[1])));

            inputAutocomplete = /** @type {!HTMLInputElement} */(
                document.getElementById(input));

            autoComplete = new google.maps.places.Autocomplete(inputAutocomplete, { bounds : defaultBounds });
            autoComplete.setComponentRestrictions({'country': 'ar'});
           // autoComplete.bindTo('bounds', map);

            if(!infowindowMarker)
                infowindowMarker = new google.maps.InfoWindow();


            if(!individualMarker)
                individualMarker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    anchorPoint: new google.maps.Point(0, -29)
                });

            individualMarker.addListener('dragend',function(event) {
                infowindowMarker.close()
             //   alert(event.latLng.lat()+','+event.latLng.lng());
                individualMarker.setPosition(event.latLng);


                geocodeInverse(event.latLng.lat(), event.latLng.lng()).then(function(address){
                        inputAutocomplete.value = address;
                        $('#'+inputAutocomplete.id).data('latLng', event.latLng.lat()+','+event.latLng.lng())
                        infowindowMarker.setContent(address);
                        infowindowMarker.open(map, individualMarker);
                    },
                    function(msg)
                    {
                        alert(msg);
                    }
                );


            });


            autoComplete.addListener('place_changed',function(){
                infowindowMarker.close()
                individualMarker.setVisible(false);

                var place = autoComplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(16);  // Why 17? Because it looks good.
                }

                /*individualMarker.setIcon(/** @type {google.maps.Icon} /({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));*/
                individualMarker.setPosition(place.geometry.location);
                individualMarker.setVisible(true)

                $('#'+inputAutocomplete.id).data('latLng', place.geometry.location.lat()+','+place.geometry.location.lng())

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindowMarker.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                infowindowMarker.open(map, individualMarker);

            })



        }



        var addDummyMarkers = function()
        {
            addMarker({lat: -31.42161608, lng: -64.15921783},"espaciosVerdes","<div style='max-width: 200px'>Equipamiento de Bancos de H°A° y Cestos Papeleros para las plazas .Equipamiento Global</div>" )
            addMarker({lat: -31.39105049, lng: -64.19076446},"espaciosVerdes","<div style='max-width: 200px'>Equipamiento de Bancos de H°A° y Cestos Papeleros para las plazas .Equipamiento Global</div>" )
            addMarker({lat: -31.39782931, lng: -64.17567226},"espaciosVerdes","<div style='max-width: 200px'>Equipamiento de Bancos de H°A° y Cestos Papeleros para las plazas .Equipamiento Global</div>" )
            addMarker({lat: -31.44850747, lng: -64.16407324},"transito","<div style='max-width: 200px'>Equipamiento de Bancos de H°A° y Cestos Papeleros para las plazas .Equipamiento Global</div>" )
            addMarker({lat: -31.40415877, lng: -64.19074358},"transito","<div style='max-width: 200px'>Equipamiento de Bancos de H°A° y Cestos Papeleros para las plazas .Equipamiento Global</div>" )

        }

        var addMarker = function(location, category, info){
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                animation: google.maps.Animation.DROP,
                icon: iconsCategory[category]
            });
            var infowindow = new google.maps.InfoWindow({
                content: info
            });
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
            if(!markers[category])
                markers[category] = [];
            markers[category].push(marker);
        }

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
                  //  handleLocationError(true, infoWindow, map.getCenter());
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

        var hideIndividualMarker = function()
        {
            if(infowindowMarker)
                infowindowMarker.close()
            if(individualMarker)
                individualMarker.setVisible(false);
        }

        var SetIndividualMarker = function(location, address)
        {
            if(location) {
                var loc = location.split(',');

                var latLng = new google.maps.LatLng(parseFloat(loc[0]), parseFloat(loc[1]))

                if (!infowindowMarker)
                    infowindowMarker = new google.maps.InfoWindow();


                if (!individualMarker)
                    individualMarker = new google.maps.Marker({
                        map: map,
                        draggable: true,
                        animation: google.maps.Animation.DROP,
                        anchorPoint: new google.maps.Point(0, -29)
                    });

                individualMarker.setVisible(true);
                individualMarker.setPosition(latLng);
                infowindowMarker.setContent(address);
                infowindowMarker.open(map, individualMarker);
                map.setCenter(latLng);
                map.setZoom(16);  
            }
            else
            {
                individualMarker.setVisible(false);
                infowindowMarker.close();
                map.setCenter(centerMap);
                map.setZoom(12);
            }

        }

        return {
                SouthWest: southWest,
                NorthEast: northEast,
                InitMap: initializeMap,
                CreateAutocomplete :createAutocomplete,
                AddEventClickAddMarker: addEventClickAddMarker,
                HideIndividualMarker: hideIndividualMarker,
                SetIndividualMarker: SetIndividualMarker

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

