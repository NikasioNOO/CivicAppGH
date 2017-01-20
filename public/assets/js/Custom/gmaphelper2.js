/**
 * Created by Nico on 28/03/2016.
 */

(function(){
    this.CivicApp = this.CivicApp || {};
    this.CivicApp.GmapHelper2 = this.CivicApp.GmapHelper2 || new function(){

        var Map = function(mapCanvas)
        {
            var selfi = this;
            this.map = null ;
            this.geocoder = null;
            this.centerMap = null;
            this.markers = [];
            this.clusterMarkers = null;

            this.autoComplete = null;
            this.infowindowMarker = null;
            this.individualMarker =null;
            this.inputAutocomplete = null;

            this.southWest = '-31.471168, -64.278946';
            this.northEast = '-31.361003, -64.090805';

            this.InitMap = function(mapCanvas)
            {

                // var deferredInit = $.Deferred();
                if(!mapCanvas)
                    mapCanvas = 'map';
                var centerLocation = selfi.codeAdress("Córdoba, Córdoba, Argentina");


                centerLocation.then(
                    function(center){
                        selfi.centerMap = center;
                        selfi.map  = new google.maps.Map(document.getElementById(mapCanvas), {
                            zoom: 14,
                            center: center
                        });

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
                        selfi.map  = new google.maps.Map(document.getElementById(mapCanvas), {
                            zoom: 12
                        });

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

            this.AddEventClickAddMarker = function()
            {
                selfi.map.addListener('click', function(event) {

                    if(!selfi.infowindowMarker)
                        selfi.infowindowMarker = new google.maps.InfoWindow();

                    if(!selfi.individualMarker)
                        selfi.individualMarker = new google.maps.Marker({
                            map: selfi.map,
                            draggable: true,
                            animation: google.maps.Animation.DROP,
                            anchorPoint: new google.maps.Point(0, -29)
                        });

                    selfi.infowindowMarker.close();

                    selfi.individualMarker.setPosition(event.latLng);
                    selfi.SetAutocompleteAddressAndMarker(event.latLng.lat(), event.latLng.lng());
                    /*selfi.GeocodeInverse(event.latLng.lat(), event.latLng.lng()).then(function(address){
                            selfi.inputAutocomplete.value = address;
                            $('#'+ selfi.inputAutocomplete.id).data('latLng', event.latLng.lat()+','+event.latLng.lng())
                            selfi.infowindowMarker.setContent(address);
                            selfi.infowindowMarker.open(selfi.map, selfi.individualMarker);
                        },
                        function(msg)
                        {
                            alert(msg);
                        }
                    );*/

                });
            };

            this.SetAutocompleteAddressAndMarker = function(lat, lng)
            {
                selfi.GeocodeInverse(lat,lng).then(function(address){
                        selfi.inputAutocomplete.value = address;


                        $('#'+ selfi.inputAutocomplete.id).data('latLng', lat+','+lng);
                        var location = new google.maps.LatLng( lat, lng);
                        selfi.individualMarker.setPosition(location);
                        selfi.individualMarker.setVisible(true);
                        selfi.infowindowMarker.setContent(address);

                        selfi.infowindowMarker.open(selfi.map, selfi.individualMarker);


                        selfi.map.setCenter( location);
                        selfi.map.setZoom(15);
                    },
                    function(msg)
                    {
                        alert(msg);
                    }
                );
            };

            this.GeocodeInverse = function(lat, lng){
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

            this.CreateAutocomplete = function(input)
            {
                var sWest =  this.southWest.split(',');
                var nEast =  this.northEast.split(',');

                var defaultBounds = new google.maps.LatLngBounds(
                    new google.maps.LatLng( parseFloat(sWest[0]), parseFloat(sWest[1])),
                    new google.maps.LatLng( parseFloat(nEast[0]), parseFloat(nEast[1])));

                selfi.inputAutocomplete = /** @type {!HTMLInputElement} */(
                    document.getElementById(input));

                selfi.autoComplete = new google.maps.places.Autocomplete( selfi.inputAutocomplete, { bounds : defaultBounds });
                selfi.autoComplete.setComponentRestrictions({'country': 'ar'});
                // autoComplete.bindTo('bounds', map);

                if(! selfi.infowindowMarker)
                    selfi.infowindowMarker = new google.maps.InfoWindow();


                if(! selfi.individualMarker)
                    selfi.individualMarker = new google.maps.Marker({
                        map: selfi.map,
                        draggable: true,
                        animation: google.maps.Animation.DROP,
                        anchorPoint: new google.maps.Point(0, -29)
                    });

                selfi.individualMarker.addListener('dragend',function(event) {
                    selfi.infowindowMarker.close()
                    //   alert(event.latLng.lat()+','+event.latLng.lng());
                    selfi.individualMarker.setPosition(event.latLng);

                    selfi.SetAutocompleteAddressAndMarker(event.latLng.lat(), event.latLng.lng());
                    /*selfi.GeocodeInverse(event.latLng.lat(), event.latLng.lng()).then(function(address){
                            selfi.inputAutocomplete.value = address;
                            $('#'+ selfi.inputAutocomplete.id).data('latLng', event.latLng.lat()+','+event.latLng.lng())
                            selfi.infowindowMarker.setContent(address);
                            selfi.infowindowMarker.open(selfi.map,  selfi.individualMarker);
                        },
                        function(msg)
                        {
                            alert(msg);
                        }
                    );*/


                });


                selfi.autoComplete.addListener('place_changed',function(){
                    selfi.infowindowMarker.close()
                    selfi.individualMarker.setVisible(false);

                    var place =  selfi.autoComplete.getPlace();
                    if (!place.geometry) {
                        window.alert("Autocomplete's returned place contains no geometry");
                        return;
                    }

                    // If the place has a geometry, then present it on a map.
                    if (place.geometry.viewport) {
                        selfi.map.fitBounds(place.geometry.viewport);
                        selfi.map.setZoom(17);
                    } else {
                        selfi.map.setCenter(place.geometry.location);
                        selfi.map.setZoom(17);  // Why 17? Because it looks good.
                    }

                    /*individualMarker.setIcon(/** @type {google.maps.Icon} /({
                     url: place.icon,
                     size: new google.maps.Size(71, 71),
                     origin: new google.maps.Point(0, 0),
                     anchor: new google.maps.Point(17, 34),
                     scaledSize: new google.maps.Size(35, 35)
                     }));*/
                    selfi.individualMarker.setPosition(place.geometry.location);
                    selfi.individualMarker.setVisible(true);

                    $('#'+ selfi.inputAutocomplete.id).data('latLng', place.geometry.location.lat()+','+place.geometry.location.lng())

                    var address = '';
                    if (place.address_components) {
                        address = [
                            (place.address_components[0] && place.address_components[0].short_name || ''),
                            (place.address_components[1] && place.address_components[1].short_name || ''),
                            (place.address_components[2] && place.address_components[2].short_name || '')
                        ].join(' ');
                    }

                    selfi.infowindowMarker.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                    selfi.infowindowMarker.open(selfi.map,  selfi.individualMarker);

                })



            };
            /***
             * Para Crear un search box sobre un input y con marcador
             * @param input
             * @constructor
             */
            this.CreateSearchBox = function(input)
            {
                var sWest =  this.southWest.split(',');
                var nEast =  this.northEast.split(',');

                var defaultBounds = new google.maps.LatLngBounds(
                    new google.maps.LatLng( parseFloat(sWest[0]), parseFloat(sWest[1])),
                    new google.maps.LatLng( parseFloat(nEast[0]), parseFloat(nEast[1])));

                selfi.inputAutocomplete = /** @type {!HTMLInputElement} */(
                    document.getElementById(input));

                selfi.autoComplete = new google.maps.places.SearchBox( selfi.inputAutocomplete, { bounds : defaultBounds });
              //  selfi.autoComplete.setComponentRestrictions({'country': 'ar'});
                // autoComplete.bindTo('bounds', map);

                if(! selfi.infowindowMarker)
                    selfi.infowindowMarker = new google.maps.InfoWindow();


                if(! selfi.individualMarker)
                    selfi.individualMarker = new google.maps.Marker({
                        map: selfi.map,
                        draggable: true,
                        animation: google.maps.Animation.DROP,
                        anchorPoint: new google.maps.Point(0, -29)
                    });

                selfi.individualMarker.addListener('dragend',function(event) {
                    selfi.infowindowMarker.close()
                    //   alert(event.latLng.lat()+','+event.latLng.lng());
                    selfi.individualMarker.setPosition(event.latLng);

                    selfi.SetAutocompleteAddressAndMarker(event.latLng.lat(), event.latLng.lng());
                    /*selfi.GeocodeInverse(event.latLng.lat(), event.latLng.lng()).then(function(address){
                     selfi.inputAutocomplete.value = address;
                     $('#'+ selfi.inputAutocomplete.id).data('latLng', event.latLng.lat()+','+event.latLng.lng())
                     selfi.infowindowMarker.setContent(address);
                     selfi.infowindowMarker.open(selfi.map,  selfi.individualMarker);
                     },
                     function(msg)
                     {
                     alert(msg);
                     }
                     );*/


                });


                selfi.autoComplete.addListener('places_changed',function(){
                    selfi.infowindowMarker.close()
                    selfi.individualMarker.setVisible(false);

                    var places =  selfi.autoComplete.getPlaces();
                    if (places.length == 0) {
                        Utilities.ShowMessage('Ninguna ubicación fue encontrada','Ubicación incorrecta');
                        return;
                    }

                    var place = places[0];
                    // If the place has a geometry, then present it on a map.
                    if (place.geometry.viewport) {
                        selfi.map.fitBounds(place.geometry.viewport);
                        selfi.map.setZoom(17);
                    } else {
                        selfi.map.setCenter(place.geometry.location);
                        selfi.map.setZoom(17);  // Why 17? Because it looks good.
                    }

                    /*individualMarker.setIcon(/** @type {google.maps.Icon} /({
                     url: place.icon,
                     size: new google.maps.Size(71, 71),
                     origin: new google.maps.Point(0, 0),
                     anchor: new google.maps.Point(17, 34),
                     scaledSize: new google.maps.Size(35, 35)
                     }));*/
                    selfi.individualMarker.setPosition(place.geometry.location);
                    selfi.individualMarker.setVisible(true);

                    $('#'+ selfi.inputAutocomplete.id).data('latLng', place.geometry.location.lat()+','+place.geometry.location.lng())

                    var address = '';
                    if (place.formatted_address) {
                        address = place.formatted_address;
                    }

                    selfi.infowindowMarker.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                    selfi.infowindowMarker.open(selfi.map,  selfi.individualMarker);

                })



            };

            this.CreateSearchBoxAutocomplete = function(input) {
                var sWest = this.southWest.split(',');
                var nEast = this.northEast.split(',');

                var defaultBounds = new google.maps.LatLngBounds(
                    new google.maps.LatLng(parseFloat(sWest[0]), parseFloat(sWest[1])),
                    new google.maps.LatLng(parseFloat(nEast[0]), parseFloat(nEast[1])));

                selfi.inputAutocomplete = /** @type {!HTMLInputElement} */(
                    document.getElementById(input));

                selfi.map.setOptions({
                    mapTypeControlOptions: {
                        position: google.maps.ControlPosition.LEFT_BOTTOM
                    }
                });


                selfi.autoComplete = new google.maps.places.SearchBox(selfi.inputAutocomplete);
              //  selfi.autoComplete.setComponentRestrictions({'country': 'ar'});

                selfi.map.controls[google.maps.ControlPosition.TOP_LEFT].push(selfi.inputAutocomplete);


                selfi.map.addListener('bounds_changed', function() {
                    selfi.autoComplete.setBounds(selfi.map.getBounds());
                });

                selfi.autoComplete.addListener('places_changed', function () {
                    debugger;
                    var places = selfi.autoComplete.getPlaces();
                    if (places.length == 0) {
                        Utilities.ShowMessage('Ninguna ubicación fue encontrada','Ubicación incorrecta');
                        return;
                    }

                    var place = places[0];

                    // If the place has a geometry, then present it on a map.
                    if (place.geometry.viewport) {
                        selfi.map.fitBounds(place.geometry.viewport);
                        selfi.map.setZoom(16);
                    } else {
                        selfi.map.setCenter(place.geometry.location);
                        selfi.map.setZoom(16);  // Why 17? Because it looks good.
                    }

                    $('#' + selfi.inputAutocomplete.id).data('latLng', place.geometry.location.lat() + ',' + place.geometry.location.lng())


                });

            }

            this.CreateAutocompleteSearch = function(input)
            {
                var sWest =  this.southWest.split(',');
                var nEast =  this.northEast.split(',');

                var defaultBounds = new google.maps.LatLngBounds(
                    new google.maps.LatLng( parseFloat(sWest[0]), parseFloat(sWest[1])),
                    new google.maps.LatLng( parseFloat(nEast[0]), parseFloat(nEast[1])));

                selfi.inputAutocomplete = /** @type {!HTMLInputElement} */(
                    document.getElementById(input));

                selfi.map.setOptions({mapTypeControlOptions:{
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                }});
                selfi.map.controls[google.maps.ControlPosition.TOP_LEFT].push(selfi.inputAutocomplete);

                selfi.autoComplete = new google.maps.places.Autocomplete( selfi.inputAutocomplete, { bounds : defaultBounds });
                selfi.autoComplete.setComponentRestrictions({'country': 'ar'});


                selfi.autoComplete.addListener('place_changed',function(){

                    var place =  selfi.autoComplete.getPlace();
                    if (!place.geometry) {
                        window.alert("Autocomplete's returned place contains no geometry");
                        return;
                    }

                    // If the place has a geometry, then present it on a map.
                    if (place.geometry.viewport) {
                        selfi.map.fitBounds(place.geometry.viewport);
                        selfi.map.setZoom(16);
                    } else {
                        selfi.map.setCenter(place.geometry.location);
                        selfi.map.setZoom(16);  // Why 17? Because it looks good.
                    }

                    $('#'+ selfi.inputAutocomplete.id).data('latLng', place.geometry.location.lat()+','+place.geometry.location.lng())


                })



            };

            this.AddMarker = function(location, icon, info){
                var marker = new google.maps.Marker({
                    position: location,
                    map: selfi.map,
                    animation: google.maps.Animation.DROP,
                    icon: icon
                });
                var infowindow = new google.maps.InfoWindow({
                    content: info,
                    maxWidth: 350
                });
                marker.addListener('click', function() {
                    infowindow.open(Map.map, marker);
                });

                selfi.markers.push(marker);



                return marker;
            };

            this.SetMapOnAll = function(map) {
                for (var i = 0; i < selfi.markers.length; i++) {
                    selfi.markers[i].setMap(map);
                }
            };

            this.ShowMarkers =function() {
                selfi.SetMapOnAll(selfi.map);
            };

            this.ClearMarkers = function() {
                selfi.SetMapOnAll(null);
            };

            this.DeleteMarkers = function() {
                selfi.ClearMarkers();
                selfi.markers = [];
            };

            this.CreateCluster = function()
            {
                selfi.clusterMarkers = new MarkerClusterer(selfi.map, selfi.markers, {maxZoom:17 });
            };

            this.ClearCluster = function()
            {
                selfi.clusterMarkers.clearMarkers();
            };

            this.AddMarkerToCluster = function()
            {
                selfi.clusterMarkers.addMarkers(selfi.markers);
            };


            this.CleanMarkersMap = function(clusterflag)
            {
                if(!clusterflag)
                    clusterflag = false;

                selfi.DeleteMarkers();
                if(clusterflag)
                    selfi.ClearCluster();

            };

           /* this.addDummyMarkers = function()
            {
                selfi.addMarker({lat: -31.42161608, lng: -64.15921783},"espaciosVerdes","<div style='max-width: 200px'>Equipamiento de Bancos de H°A° y Cestos Papeleros para las plazas .Equipamiento Global</div>" )
                selfi.addMarker({lat: -31.39105049, lng: -64.19076446},"espaciosVerdes","<div style='max-width: 200px'>Equipamiento de Bancos de H°A° y Cestos Papeleros para las plazas .Equipamiento Global</div>" )
                selfi.addMarker({lat: -31.39782931, lng: -64.17567226},"espaciosVerdes","<div style='max-width: 200px'>Equipamiento de Bancos de H°A° y Cestos Papeleros para las plazas .Equipamiento Global</div>" )
                selfi.addMarker({lat: -31.44850747, lng: -64.16407324},"transito","<div style='max-width: 200px'>Equipamiento de Bancos de H°A° y Cestos Papeleros para las plazas .Equipamiento Global</div>" )
                selfi.addMarker({lat: -31.40415877, lng: -64.19074358},"transito","<div style='max-width: 200px'>Equipamiento de Bancos de H°A° y Cestos Papeleros para las plazas .Equipamiento Global</div>" )

            };*/

            this.AddUserLocationInfoWindows = function()
            {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        debugger;
                        var location = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        var infoWindow = new google.maps.InfoWindow({map: selfi.map});
                        infoWindow.setPosition(location);
                        infoWindow.setContent('Usted está aquí');

                    }, function() {
                        //  handleLocationError(true, infoWindow, map.getCenter());
                    });
                }
            };

            this.handleLocationError = function (browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.');
            }

            this.codeAdress = function(address)
            {
                var deferred = $.Deferred();

                if(! selfi.geocoder)
                    selfi.geocoder = new google.maps.Geocoder();

                selfi.geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var location = results[0].geometry.location;
                        deferred.resolve(location);

                    } else {
                        deferred.reject("Geocode was not successful for the following reason: " + status);

                    }
                });


                return deferred.promise();

            };

            this.HideIndividualMarker = function()
            {
                if( selfi.infowindowMarker)
                    selfi.infowindowMarker.close()
                if( selfi.individualMarker)
                    selfi.individualMarker.setVisible(false);
            };

            this.SetIndividualMarker = function(location, address)
            {
                if(location) {
                    var loc = location.split(',');

                    var latLng = new google.maps.LatLng(parseFloat(loc[0]), parseFloat(loc[1]))

                    if (! selfi.infowindowMarker)
                        selfi.infowindowMarker = new google.maps.InfoWindow();


                    if (! selfi.individualMarker)
                        selfi.individualMarker = new google.maps.Marker({
                            map: selfi.map,
                            draggable: true,
                            animation: google.maps.Animation.DROP,
                            anchorPoint: new google.maps.Point(0, -29)
                        });

                    selfi.individualMarker.setVisible(true);
                    selfi.individualMarker.setPosition(latLng);
                    selfi.infowindowMarker.setContent(address);
                    selfi.infowindowMarker.open(selfi.map,  selfi.individualMarker);
                    selfi.map.setCenter(latLng);
                    selfi.map.setZoom(17);
                }
                else
                {
                    selfi.individualMarker.setVisible(false);
                    selfi.infowindowMarker.close();
                    selfi.map.setCenter( selfi.centerMap);
                    selfi.map.setZoom(12);
                }

            };

            this.CleanAutocomplete = function()
            {
                selfi.inputAutocomplete.value = '';
                $('#'+ selfi.inputAutocomplete.id).data('latLng', '');
                selfi.HideIndividualMarker();
                selfi.map.setCenter( selfi.centerMap);
                selfi.map.setZoom(12);

            };

            this.GetLatLng = function()
            {
               return  $('#'+ selfi.inputAutocomplete.id).data('latLng');
            };

            this.GetAutoCompleteAddress = function()
            {
                return  $('#'+ selfi.inputAutocomplete.id).val();
            };

            this.SetAutoCompleteAddress = function(address)
            {
                return  $('#'+ selfi.inputAutocomplete.id).val(address);
            };

            this.MapCenter = function ()
            {
                selfi.map.setCenter(selfi.centerMap);
            }


            this.AutocompleteChange = function()
            {

                var place = placesAutocomplete.getPlace();

                if (place.geometry) {
                    selfi.map.panTo(place.geometry.location);
                    selfi.map.setZoom(18);
                } else {
                    selfi.inputAutocomplete.placeholder = 'Ingrese Ubicación';
                }

            }




        };


        return {
                Map: Map
        };


    };

}());






