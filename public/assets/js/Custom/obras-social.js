/**
 * Created by Nico on 31/07/2016.
 */
(function(){



    this.CivicApp = this.CivicApp || { Inicialized:null };

    this.CivicApp.ObrasSocial = this.CivicApp.ObrasSocial || new function() {

        var selfi = this;
        var timeVerIcon = "?ver="+  Date.now().toString();
        var map = null;
        var markers = [];
        var markerCluster = null;
        var selectYear = $('#yearSearch');
        var selectCategory = $('#categorySearch');
        var selectBarrio = $('#barrioSearch');
        var obrasLoaded =null;

        var InitilizeMap = function()
        {

            map = new CivicApp.GmapHelper2.Map();
            var init = map.InitMap('map');

            $.when()

            init.then(function() {
                var deferred = $.Deferred();
                map.southWest = '-31.471168, -64.278946';
                map.northEast = '-31.361003, -64.090805';
                //map.CreateAutocompleteSearch('autocompleteMap');
                map.CreateSearchBoxAutocomplete('autocompleteMap');
                //map.AddEventClickAddMarker();
                debugger;
                LoadAllObras().done(
                    function(){
                        deferred.resolve();
                    });

               return deferred.promise();

            }).done(function()
            {
                if(CivicApp && CivicApp.ModalIni && CivicApp.ModalIni.LoadModal  )
                    CivicApp.ModalIni.LoadModal();
            });

            //CivicApp.Inicialized = init;

        };

        var LoadObrasMarkers = function(obrasparam)
        {

            obrasLoaded = obrasparam;
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
                            '<br/><a data-toggle="modal" data-target="#ObraDetail" data-obraindex="'+i+'" onclick="CivicApp.ObrasSocial.LoadObraSelected(this)" >'+ '('+ obras[i].year +') '+ obras[i].description+'- B° '+obras[i].barrio.name+'</a>';
                        }
                        else
                        {
                            geoobras[locationKey][categoryStatusKey] = {info : '<a data-toggle="modal" data-obraindex="'+i+'" data-target="#ObraDetail" onclick="CivicApp.ObrasSocial.LoadObraSelected(this)" >'+ '('+ obras[i].year +') '+obras[i].description+'- B° '+obras[i].barrio.name+'</a>',
                                icon :icon,
                                location :location,
                                category: obras[i].category.category,
                                status:obras[i].status.status};
                        }
                    }
                    else
                    {
                        geoobras[locationKey] = {};
                        geoobras[locationKey][categoryStatusKey] = {info : '<a data-toggle="modal" data-obraindex="'+i+'" onclick="CivicApp.ObrasSocial.LoadObraSelected(this)" data-target="#ObraDetail">'+ '('+ obras[i].year +') '+ obras[i].description+'- B° '+obras[i].barrio.name+'</a>',
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
                        "<div class='iw-title'>Categr&iacute;a:"+ geoobras[locKey][catKey].category+"</div>" +
                        "<div class='iw-content'>"+
                        "<div class='iw-subTitle'>Estado:"+ geoobras[locKey][catKey].status+"</div>" +
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


            $('#ObraDetail').on('show.bs.modal',function(e)
            {
                var winHeight = $( window ).height();
                var height = winHeight*0.4;
                $('#ObraDetail .modal-dialog').height(winHeight*0.8);
                $('#ObraDetail .carousel-inner img').height(height);
                $('.gridthumbnail').height(height);

            });
        };

        var LoadAllObras = function()
        {
            var deferred = $.Deferred();
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
                deferred.resolve();
            }).fail(function(){
                Utilities.ShowError('Se ha producido un error al Obtener las obras del presupuesto participativo.');
                deferred.reject();
            });
            return deferred.promise();
        };

        var LoadObraSelected = function(obraSel)
        {
            debugger;
            var index = $(obraSel).data('obraindex');
            var obra = obrasLoaded[index];

            CivicApp.ObrasSocial.ObraDetail.SetObra(obra.id, obra.description, obra.year, obra.cpc.name, obra.barrio.name,
                obra.category.category, obra.budget, obra.status.status, obra.nro_expediente ?obra.nro_expediente:''  );

        };

        var LoadModalDetail = function(obraId)
        {
            var obra = Utilities.findandGetInList(obrasLoaded,"id",obraId)

            if(obra) {
                $('#ObraDetail').modal('show');
                CivicApp.ObrasSocial.ObraDetail.SetObra(obra.id, obra.description, obra.year, obra.cpc.name, obra.barrio.name,
                    obra.category.category, obra.budget, obra.status.status, obra.nro_expediente ? obra.nro_expediente : '');
            }
            else
            {
                Utilities.ShowMessage('La Obra con Id '+obraId+' que se hace referencia no se encuentra.','Obra no encontrada');
            }


        };

        var correctLocList = function (loclist) {
            var lng_radius = 0.00008,         // degrees of longitude separation
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
            InitEvents : InitializeEvents,
            ObrasLoaded: obrasLoaded,
            LoadObraSelected: LoadObraSelected,
            LoadModalDetail:LoadModalDetail


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

