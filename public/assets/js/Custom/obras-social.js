/**
 * Created by Nico on 31/07/2016.
 */
(function(){



    this.CivicApp = this.CivicApp || {};
    this.CivicApp.ObrasSocial = this.CivicApp.ObrasSocial || new function() {

        var timeVerIcon = "?ver="+  Date.now().toString();
        var map = null;
        var markers = [];
        var markerCluster = null;
        var selectYear = $('#yearSearch');
        var selectCategory = $('#categorySearch');
        var selectBarrio = $('#barrioSearch');

        var InitilizeMap = function()
        {

            map = new CivicApp.GmapHelper2.Map();
            var init = map.InitMap('map');
            init.then(function() {
                map.southWest = '-31.471168, -64.278946';
                map.northEast = '-31.361003, -64.090805';
                map.CreateAutocompleteSearch('autocompleteMap');
                //map.AddEventClickAddMarker();
                debugger;
                LoadAllObras();

            });

        };

        var LoadObrasMarkers = function(obrasparam)
        {
            var obras = obrasparam;
            var pathIcon = window.location.protocol+'//'+window.location.host+'//' + ENV_MAPICONS_PATH;

            var geoobras = {};

            for(var i=0; i< obras.length; i++)
            {
                var location = '';
                var locationKey = '';
                var icon='';
                if(obras[i].location && obras[i].location.location ) {
                    location = Utilities.CreateLocationObj(obras[i].location.location);
                    locationKey = obras[i].location.location;
                }
                else if( obras[i].barrio && obras[i].barrio.location && obras[i].barrio.location.location ) {
                    location = Utilities.CreateLocationObj(obras[i].barrio.location.location);
                    locationKey = obras[i].barrio.location.location;
                }
                if(location)
                {
                    var categoryStatusKey = 'cat'+obras[i].category.id+'_stat_'+obras[i].status.id;
                    var icoName = 'cat'+obras[i].category.id+'_ico_'+obras[i].status.id+'_'
                        +obras[i].status.status.replace(' ', '').trim()+'.png';
                    if (obras[i].category && obras[i].category.images &&
                        (obras[i].category.images).indexOf(icoName)>=0)
                        icon = pathIcon + icoName + timeVerIcon;
                    else
                        icon = pathIcon + ENV_DEFAULT_ICON;

                    if(geoobras[locationKey])
                    {
                        if(geoobras[locationKey][categoryStatusKey])
                        {
                            geoobras[locationKey][categoryStatusKey].info = geoobras[locationKey][categoryStatusKey].info +
                            '<br/><a>'+obras[i].description+'</a>';
                        }
                        else
                        {
                            geoobras[locationKey][categoryStatusKey] = {info : '<a>'+obras[i].description+'</a>',
                                icon :icon,
                                location :location,
                                category: obras[i].category.category,
                                status:obras[i].status.status};
                        }
                    }
                    else
                    {
                        geoobras[locationKey] = {};
                        geoobras[locationKey][categoryStatusKey] = {info : '<a>'+obras[i].description+'</a>',
                            icon :icon,
                            location :location,
                            category: obras[i].category.category,
                            status:obras[i].status.status};
                        // geoobras[locationKey][categoryStatusKey].icon  = icon;
                    }

                    // markers.push(map.AddMarker(location,icon,obras[i].description));


                    //    map.AddMarker(location,icon,obras[i].description);
                }
            }

            for(var locKey in geoobras)
            {
                correctLocList(geoobras[locKey]);
                for(var catKey in geoobras[locKey])
                {
                    var divInfo = "<div id='iw-container'>" +
                        "<div class='iw-title'>"+ geoobras[locKey][catKey].category+"</div>" +
                        "<div class='iw-content'>"+
                        "<div class='iw-subTitle'>Estado "+ geoobras[locKey][catKey].status+"</div>" +
                        "<div>"    + geoobras[locKey][catKey].info + "</div>" +
                        "</div>" +
                        '<div class="iw-bottom-gradient"></div>' +
                        "</div>";

                    markers.push(map.AddMarker(geoobras[locKey][catKey].location,
                        geoobras[locKey][catKey].icon, divInfo));

                }

            }
        };

        var InitializeEvents = function()
        {
            $('#searchObrasBtn').on('click',function(){
                debugger;
                var year = selectYear.val();
                var category = selectCategory.val();
                var barrio = selectBarrio.val();

                map.CleanMarkersMap(true);

                $.get('/ObraPP/Año/'+year+'/Categoria/'+category+'/Barrio/'+barrio,function(result){

                    if(result.status='OK')
                    {
                        if(result.data)
                        {

                            LoadObrasMarkers(result.data);
                            map.AddMarkerToCluster();
                            //new MarkerClusterer(map.map, markers, {maxZoom:17 });
                        }
                    }
                    else
                    {
                        Utilities.ShowError('Se ha producido un error al Obtener las obras del presupuesto participativo.');
                    }
                }).fail(function(){
                    Utilities.ShowError('Se ha producido un error al Obtener las obras del presupuesto participativo.');
                });

            });

        };

        var LoadAllObras = function()
        {
            $.get('/ObraPP',function(result){

                if(result.status='OK')
                {
                    debugger;
                    if(result.data)
                    {

                        LoadObrasMarkers(result.data);
                        map.CreateCluster();

                     /*   var markers = [];
                        var obras = result.data;
                        var pathIcon = window.location.protocol+'//'+window.location.host+'//' + ENV_MAPICONS_PATH;

                        var geoobras = {};

                        for(var i=0; i< obras.length; i++)
                        {
                            var location = '';
                            var locationKey = '';
                            var icon='';
                            if(obras[i].location && obras[i].location.location ) {
                                location = Utilities.CreateLocationObj(obras[i].location.location);
                                locationKey = obras[i].location.location;
                            }
                            else if( obras[i].barrio && obras[i].barrio.location && obras[i].barrio.location.location ) {
                                location = Utilities.CreateLocationObj(obras[i].barrio.location.location);
                                locationKey = obras[i].barrio.location.location;
                            }
                            if(location)
                            {
                                var categoryStatusKey = 'cat'+obras[i].category.id+'_stat_'+obras[i].status.id;
                                var icoName = 'cat'+obras[i].category.id+'_ico_'+obras[i].status.id+'_'
                                        +obras[i].status.status.replace(' ', '').trim()+'.png';
                                if (obras[i].category && obras[i].category.images &&
                                    (obras[i].category.images).indexOf(icoName)>=0)
                                    icon = pathIcon + icoName + timeVerIcon;
                                else
                                    icon = pathIcon + ENV_DEFAULT_ICON;

                                if(geoobras[locationKey])
                                {
                                    if(geoobras[locationKey][categoryStatusKey])
                                    {
                                        geoobras[locationKey][categoryStatusKey].info = geoobras[locationKey][categoryStatusKey].info +
                                            '<br/><a>'+obras[i].description+'</a>';
                                    }
                                    else
                                    {
                                        geoobras[locationKey][categoryStatusKey] = {info : '<a>'+obras[i].description+'</a>',
                                                                                    icon :icon,
                                                                                    location :location,
                                                                                    category: obras[i].category.category,
                                                                                    status:obras[i].status.status};
                                    }
                                }
                                else
                                {
                                    geoobras[locationKey] = {};
                                    geoobras[locationKey][categoryStatusKey] = {info : '<a>'+obras[i].description+'</a>',
                                                                                icon :icon,
                                                                                location :location,
                                                                                category: obras[i].category.category,
                                                                                status:obras[i].status.status};
                                   // geoobras[locationKey][categoryStatusKey].icon  = icon;
                                }

                               // markers.push(map.AddMarker(location,icon,obras[i].description));


                            //    map.AddMarker(location,icon,obras[i].description);
                            }
                        }

                        for(var locKey in geoobras)
                        {
                            correctLocList(geoobras[locKey]);
                            for(var catKey in geoobras[locKey])
                            {
                                    var divInfo = "<div id='iw-container'>" +
                                                        "<div class='iw-title'>"+ geoobras[locKey][catKey].category+"</div>" +
                                                        "<div class='iw-content'>"+
                                                            "<div class='iw-subTitle'>Estado "+ geoobras[locKey][catKey].status+"</div>" +
                                                         "<div>"    + geoobras[locKey][catKey].info + "</div>" +
                                                        "</div>" +
                                                        '<div class="iw-bottom-gradient"></div>' +
                                                  "</div>";

                                markers.push(map.AddMarker(geoobras[locKey][catKey].location,
                                        geoobras[locKey][catKey].icon, divInfo));

                            }

                        }

                        var markerCluster = new MarkerClusterer(map.map, markers, {maxZoom:17 }); */
                    }
                }
                else
                {
                    Utilities.ShowError('Se ha producido un error al Obtener las obras del presupuesto participativo.');
                }
            }).fail(function(){
                Utilities.ShowError('Se ha producido un error al Obtener las obras del presupuesto participativo.');
            });

        };

        var correctLocList = function (loclist) {
            var lng_radius = 0.00003,         // degrees of longitude separation
                lat_to_lng = 111.23 / 71.7,  // lat to long proportion in Warsaw
                angle = 0.5,                 // starting angle, in radians
                loclen = Object.keys(loclist).length,
                step = 2 * Math.PI / loclen,
                loc,
                lat_radius = lng_radius / lat_to_lng;
            if(loclen>1)
                for (var catkey in loclist) {
                    loc = loclist[catkey].location;
                    loc.lng = loc.lng + (Math.cos(angle) * lng_radius);
                    loc.lat = loc.lat + (Math.sin(angle) * lat_radius);
                    angle += step;
                }
        };

        return {

            InitMap : InitilizeMap,
            InitEvents : InitializeEvents


        };
    };
})();
$(document).ready(function(){
    debugger;
    $('#map').css('height',$( window ).height()*0.6);

    $(window).resize(function(){
        debugger;
        $('#map').css('height',$( window ).height()*0.6);
    });
    CivicApp.ObrasSocial.InitEvents();
});

