(function(){



    this.CivicApp = this.CivicApp || {};
    this.CivicApp.Obra = this.CivicApp.Obra || new function(){

        var map = null;



        var yearSelect = $('#year');
        var locationInput = $('#autocompleteMap');
        var cpcInput = $('#CPC');
        var barrioInput = $('#barrio');
        var categoryInput = $('#category');
        var titleInput = $('#title');
        var badgetInput = $('#badget');
        var statusSelect = $('#status');
        var idObra = $('#idObra');


        function Obra()
        {
            Object.defineProperty(this, 'id', {
                get: function() {
                    var id = idObra.val();
                    return id ? id : 0;
                },
                set: function(value) {

                    idObra.val(value ? value : 0);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'year', {
                get: function() {

                    return yearSelect.val();
                },
                set: function(value) {
                    yearSelect.val(value);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'address', {
                get: function() {

                    return  locationInput.val();
                },
                set: function(value) {
                    locationInput.val(value);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'location', {
                get: function() {

                    return {
                            id: locationInput.data('idgeopoint'),
                            location: locationInput.data('latLng')};
                },
                set: function(value) {
                    if(value) {
                        locationInput.data('idgeopoint', value.id);
                        locationInput.data('latLng', value.location);
                        map.SetIndividualMarker(value.location, this.address);
                        //CivicApp.GmapHelper.SetIndividualMarker(value.location, this.address);
                    }
                    else
                    {
                        locationInput.data('idgeopoint', 0);
                        locationInput.data('latLng', '');
                        map.HideIndividualMarker();
                    }
                },
                enumerable:true
            });

            Object.defineProperty(this, 'cpc', {
                get: function() {
                    var id = cpcInput.data('idSelected');
                    return id ? { id:id }: {id:0} ;
                },
                set: function(value) {
                    var listvalues = cpcInput.data('listvalues');
                    var newValue = Utilities.findandGetInList(listvalues,'id',value.id);
                    if(newValue) {
                        cpcInput.data('idSelected',newValue.id);
                        cpcInput.val(newValue.value);
                    }
                    else
                    {
                        cpcInput.data('idSelected',0);
                        cpcInput.val('');
                    }
                },
                enumerable:true
            });

            Object.defineProperty(this, 'barrio', {
                get: function() {
                    var id = barrioInput.data('idSelected');
                    return id ? { id:id }: {id:0} ;
                },
                set: function(value) {
                    var listvalues = barrioInput.data('listvalues');
                    var newValue = Utilities.findandGetInList(listvalues,'id',value.id);
                    if(newValue) {
                        barrioInput.data('idSelected',newValue.id);
                        barrioInput.data('location', newValue.location);
                        barrioInput.val(newValue.value);
                        $('#editBarrio').toggle(true);
                    }
                    else
                    {
                        barrioInput.data('idSelected',0);
                        barrioInput.data('location', '');
                        barrioInput.val('');
                        $('#editBarrio').toggle(false);
                    }




                },
                enumerable:true
            });

            Object.defineProperty(this, 'category', {
                get: function() {
                    var id = categoryInput.data('idSelected');
                    return id ? { id:id , category:categoryInput.val()}: {id:0, category:''} ;
                },
                set: function(value) {
                    var listvalues = categoryInput.data('listvalues');
                    var newValue = Utilities.findandGetInList(listvalues,'id',value.id);
                    if(newValue) {
                        categoryInput.data('idSelected',newValue.id);
                        categoryInput.val(newValue.value);
                        $('#editIcons').toggle(true);
                    }
                    else
                    {
                        categoryInput.data('idSelected',0);
                        categoryInput.val('');
                        $('#editIcons').toggle(false);
                    }

                },
                enumerable:true
            });

            Object.defineProperty(this, 'description', {
                get: function() {

                    return titleInput.val();
                },
                set: function(value) {
                    titleInput.val(value);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'budget', {
                get: function() {

                    return badgetInput.val();
                },
                set: function(value) {
                    badgetInput.val(value);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'status', {
                get: function() {

                    var id= statusSelect.val();
                    return id ? { id:id }: {id:0} ;
                },
                set: function(value) {
                    statusSelect.val(value.id);
                },
                enumerable:true
            });

        }


        var obra = new Obra();

        var CleanObra = function()
        {
            obra.id = 0;
            obra.budget = '';
            obra.barrio = '';
            obra.category = '';
            obra.cpc = '';
            obra.address='';
            obra.location = {id:0,location:''};
            obra.status = '';
            obra.description = '';
            obra.year = '';

            map.HideIndividualMarker();

        };

        var InitEvents = function()
        {
            $('#autocompleteMap').on('change',function()
            {
         //       alert( obra.Location.address +','+ obra.Location.geoPoint);
            });

            $('#save').on('click',function()
            {
                SaveObra();
            });

            $('#cancel').on('click',function()
            {
              CleanObra();
            });

            $('.imageUploader').on('change',function(){
                var file = this.files[0];
                var id = this.id ;
                var imageFile = file.type;
               // var match= ["image/jpeg","image/png","image/jpg"];
                var match= "image/png";
                var img = $('#img'+id);
                if(!(imageFile==match))
                {
                    $('#previewing').attr('src','noimage.png');
                    Utilities.ShowMessage('Debe elegir archivos de imagen png, gracias');
                    if(!img.hasClass('hidden'))
                        img.addClass('hidden');
                    return false;
                }
                else
                {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        img.attr('src', e.target.result).removeClass('hidden');
                    };

                    reader.readAsDataURL(this.files[0]);
                }
            });

            $('#saveIcons').on('click',function()
            {
                var inputFiles = $('.imageUploader');
                var inputFileNames = [];
                for(var i=0; i< inputFiles.length ; i++)
                {
                    inputFileNames.push(inputFiles[i].name);
                }

                var formData = new FormData($('#imgUploadForm')[0]);
                formData.append('filesNames',inputFileNames);
                formData.append('categoryId', obra.category.id);
                formData.append('category',obra.category.category);

                $.ajax({
                    url: "/admin/UploadIcons", // Url to which the request is send
                    type: "POST",             // Type of request to be send, called as method
                    data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,             // To unable request pages to be cached
                    processData:false,        // To send DOMDocument or non processed data file it is set to false
                    success: function(data)   // A function to be called if request succeeds
                    {
                        $('#imagesUpload').modal('hide');
                        if(data.status == 'Ok' ) {
                            Utilities.ShowSuccesMessage('Se ha subido correctamente los iconos');

                        }
                        else
                        {
                            Utilities.ShowError(data.message);
                        }

                        ;

                    },
                    error:function( jqXHR, textStatus,  errorThrown )
                    {
                        Utilities.ShowError('Se ha producido un error al subir los iconos.'+errorThrown);
                    }
                });

            });

            $('#imagesUpload').on('show.bs.modal',function(e)
            {
                LoadCategoryIcons();
            });

            CivicApp.PopUpLocation.AddCallBackShownModal(function(e)
            {


                if(e.relatedTarget.id=='editBarrio') {
                    CivicApp.PopUpLocation.isLocationBarrio= true;
                    var location = barrioInput.data('location');
                    if (location) {
                        var latlng = location.split(',');
                        CivicApp.PopUpLocation.mapPopUp().SetAutocompleteAddressAndMarker(latlng[0], latlng[1]);

                    }
                    else {
                        CivicApp.PopUpLocation.mapPopUp().MapCenter();
                        CivicApp.PopUpLocation.mapPopUp().CleanAutocomplete();

                    }
                    google.maps.event.trigger(CivicApp.PopUpLocation.mapPopUp().map, 'resize');
                }




            });



            CivicApp.PopUpLocation.AddCallBackSave(function(){
                if(CivicApp.PopUpLocation.isLocationBarrio)
                {
                    SaveBarrioLocation();
                    CivicApp.PopUpLocation.HidePopUpLocation();
                }

            });

            CivicApp.PopUpLocation.AddCallBackHideModal(function(){
               if(CivicApp.PopUpLocation.isLocationBarrio)
               {
                    delete  CivicApp.PopUpLocation.isLocationBarrio;
                   CivicApp.PopUpLocation.mapPopUp().CleanAutocomplete();
               }
            });




        };




        var LoadCategoryIcons =  function()
        {
            $("#status option").each(function(status)
            {
                // Add $(this).val() to your list
                if(this.value) {
                    var id = this.value;
                    var name = this.text.replace(' ', '');

                    var inputName = 'imgico_' + id + '_' + name;
                    var img = 'ico_' + id + '_' + name+'.png';
                    var host = window.location.protocol+'//'+window.location.host+'//';
                    var src = host+ ENV_MAPICONS_PATH + 'cat' + obra.category.id + '_' + img;

                    if (Utilities.ImageExists(src))
                        $('#' + inputName).attr('src', src);
                    else {
                        src = host + ENV_MAPICONS_PATH + '_' + img;
                        if (Utilities.ImageExists(src))
                            $('#' + inputName).attr('src', src);
                        else
                            $('#' + inputName).attr('src', host + ENV_MAPICONS_PATH + ENV_DEFAULT_ICON);
                    }
                }

            });

        };

        var FocusForm= function()
        {
            $(window).scrollTop($('#FormObra').position().top);
        };

        var SaveObra = function()
        {
            $.post('/admin/SaveObra',{"obra":obra},
                function(data)
                {
                    if(data.status == 'Ok')
                    {
                         Utilities.ShowSuccesMessage('Se ha guardado correctamente la Obra del Presupuesto Participativo');
                        CleanObra();
                        CivicApp.ObrasGrid.ReloadGrid();
                    }
                    else
                    {
                        Utilities.ShowError(data.message);
                    }

                }).fail(function()
                {
                    Utilities.ShowError('Ocurrió un error al intentar guardar la Obra del presupuesto participativo');
                })

        };

        var DeleteObra = function(id)
        {
            $.post('/admin/DeleteObra',{"obraId":id},
                function(data)
                {
                    if(data.status == 'Ok')
                    {
                        Utilities.ShowSuccesMessage('Se ha eliminado correctamente la Obra del Presupuesto Participativo');
                        CivicApp.ObrasGrid.ReloadGrid();
                    }
                    else
                    {
                        Utilities.ShowError(data.message);
                    }

                }).fail(function()
                {
                    Utilities.ShowError('Ocurrió un error al intentar eliminar la Obra del presupuesto participativo');
                })

        };

        var LoadObra = function(editObra)
        {
            obra.id = editObra.id;
            obra.budget = editObra.budget;
            obra.barrio = editObra.barrio;
            obra.category = editObra.category;
            obra.cpc = editObra.cpc;
            obra.address=editObra.address;
            obra.location = editObra.location;
            obra.status = editObra.status;
            obra.description = editObra.description;
            obra.year = editObra.year;

        };

        var SaveBarrioLocation = function()
        {

            var location = CivicApp.PopUpLocation.mapPopUp().GetLatLng();
            if(!location) {
                Utilities.ShowError('No hay ningúna ubicación seleccionada para guardar');
                return;
            }

            $.post('/admin/SaveBarrioLocation',{"barrioId":obra.barrio.id, "location": location},
                function(data)
                {
                    if(data.status == 'Ok')
                    {
                        var listvalues = barrioInput.data('listvalues');
                        var barrioSelectedId = barrioInput.data('idSelected');

                        var barrio = Utilities.findandGetInList(listvalues,'id',barrioSelectedId);
                        barrio.location = location;
                        Utilities.findAndReplaceList(listvalues,'id',barrioSelectedId,barrio);

                        barrioInput.data('location', location);
                    }
                    else
                    {
                        Utilities.ShowError(data.message);
                    }

                }).fail(function()
                {
                    Utilities.ShowError('Ocurrió un error al intentar guardar la ubicación del barrio');
                });



        };


        var InitilizeMap = function()
        {
           /* var init = CivicApp.GmapHelper.InitMap();
            init.then(function() {

                CivicApp.GmapHelper.SouthWest = '-31.471168, -64.278946';
                CivicApp.GmapHelper.NorthEast = '-31.361003, -64.090805';
                CivicApp.GmapHelper.CreateAutocomplete('autocompleteMap');
                CivicApp.GmapHelper.AddEventClickAddMarker();
            });*/

            map = new CivicApp.GmapHelper2.Map();
            var init = map.InitMap('map');
            init.then(function() {
                map.southWest = '-31.471168, -64.278946';
                map.northEast = '-31.361003, -64.090805';
                map.CreateAutocomplete('autocompleteMap');
                map.AddEventClickAddMarker();
            });


            CivicApp.PopUpLocation.InitializeMap();
/*
            mapPopUp = new CivicApp.GmapHelper2.Map();
            var initmapPopUp = mapPopUp.InitMap('popUpMap');
            initmapPopUp.then(function() {
                mapPopUp.southWest = '-31.471168, -64.278946';
                mapPopUp.northEast = '-31.361003, -64.090805';
                mapPopUp.CreateAutocomplete('autocompletepopUpMap');
                mapPopUp.AddEventClickAddMarker();

            });
*/
        };

        var LoadCatalogs = function() {
            debugger;


            Utilities.Autocomplete('category','/admin/AddCategory',
                function(value, ui, event, control){
                    var flag =  value.trim() != "" && !ui.item;
                    $('#editIcons').toggle(!flag);
                },
                function(){
                    $('#imagesUpload').modal('show');
                    $('#editIcons').toggle(true);
                });
            Utilities.Autocomplete('barrio','/admin/AddBarrio',
                function(value, ui, event, control){
                    var flag =  value.trim() != "" && !ui.item;

                    if(!flag)
                        $(control).data('location', ui.item.location)

                    $('#editBarrio').toggle(!flag);
                },
                function(){
                    CivicApp.PopUpLocation.DisplayPopUpLocation();
                    //$('#popUpLocation').modal('show');
                    $('#editBarrio').toggle(true);
                });
            Utilities.Autocomplete('CPC','/admin/AddCpc');

        };

        return {

            LoadCatalogs : LoadCatalogs,
            InitMap : InitilizeMap,
            InitEvents: InitEvents,
            Obra : obra,
            LoadObra : LoadObra,
            FocusForm: FocusForm,
            DeleteObra: DeleteObra


        };

    };

})();


$(document).ready(function(){
    debugger;
    CivicApp.Obra.LoadCatalogs();
    CivicApp.Obra.InitEvents();
});
