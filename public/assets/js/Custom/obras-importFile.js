
(function(){

    this.CivicApp = this.CivicApp || {};
    this.CivicApp.Obra = this.CivicApp.Obra ||{};
    this.CivicApp.Obra.ImportFile = this.CivicApp.Obra.ImportFile || new function() {

        var isLoadedFlag = false;
        var btnSaveObras = $('#saveObrasFile');
        var btnFileImport = $('#LoadFileObras');
        var inputFile = $('#importFileCSV');
        var InitEvents = function()
        {
            debugger;
            btnFileImport.on('click',function()
            {
                LoadFile();
            });

            btnSaveObras.on('click',function()
            {
                SaveObras();
            });


            inputFile.on('change',function(){
                var file = this.files[0];
                var imageFile = file.type;
                var match= "application/vnd.ms-excel";
                if(!(imageFile==match))
                {
                    Utilities.ShowMessage('Debe elegir archivos de tipo csv, separados por ";", gracias');
                    this.value = "";
                    return false;
                }
            });



            CivicApp.PopUpLocation.AddCallBackShownModal(function(e)
            {

                if(e.relatedTarget.id.startsWith('editAddress')) {
                    CivicApp.PopUpLocation.source = e.relatedTarget.id;
                    var index = e.relatedTarget.id.split('_')[1];
                    var inputAddress = $('#beAddress_'+index);
                    var inputLocation = $('#beLocation_'+index);

                    var location = inputLocation.val();
                    if (location) {
                        var latlng = location.split(',');
                        CivicApp.PopUpLocation.mapPopUp().SetAutocompleteAddressAndMarker(latlng[0], latlng[1]);

                    }
                    else {
                        CivicApp.PopUpLocation.mapPopUp().MapCenter();
                        CivicApp.PopUpLocation.mapPopUp().CleanAutocomplete();

                    }

                    if(inputLocation.val())
                    {
                        CivicApp.PopUpLocation.mapPopUp().SetAutoCompleteAddress(inputLocation.val());
                    }
                    CivicApp.PopUpLocation.ResizeMap();
                }

            });

            CivicApp.PopUpLocation.AddCallBackSave(function()
            {
                if(CivicApp.PopUpLocation.source)
                {
                    var index = CivicApp.PopUpLocation.source.split('_')[1];
                    var inputAddress = $('#beAddress_'+index);
                    var inputLocation = $('#beLocation_'+index);

                    inputAddress.val(CivicApp.PopUpLocation.mapPopUp().GetAutoCompleteAddress());
                    inputLocation.val(CivicApp.PopUpLocation.mapPopUp().GetLatLng());
                    CivicApp.PopUpLocation.HidePopUpLocation();
                    inputAddress.removeClass('invalid');
                    delete CivicApp.PopUpLocation.source;


                }

            });

            CivicApp.PopUpLocation.AddCallBackHideModal(function(){
                if(CivicApp.PopUpLocation.isLocationBarrio)
                {
                    delete  CivicApp.PopUpLocation.source;
                    CivicApp.PopUpLocation.mapPopUp().CleanAutocomplete();
                    isLoadedFlag = false;
                    $('#bulkLoadObras').html('');
                }
            });


        };

        var SaveObras = function()
        {

            if(!isLoadedFlag) {
                Utilities.ShowMessage('Debe cargar correctamente un archivos con obras para importar');
                return;
            }

            var formData = new FormData($('#formObrasImport')[0]);

            if($('#chkUpdateEntities:checked').length>0) {

                var newcpcs = [];
                $('[name^="beCpc"][data-validfield="0"]').each(function (index, control) {
                    if($(control).parent().parent().parent().find('[name^="addObraChk"]').prop('checked'))
                        newcpcs.push(control.value);
                });

                var newbarrios = [];
                $('[name^="beBarrio"][data-validfield="0"]').each(function (index, control) {
                    if($(control).parent().parent().parent().find('[name^="addObraChk"]').prop('checked'))
                        newbarrios.push(control.value);
                });

                var newcategories = [];
                $('[name^="beCategory"][data-validfield="0"]').each(function (index, control) {
                    if($(control).parent().parent().parent().find('[name^="addObraChk"]').prop('checked'))
                        newcategories.push(control.value);
                });

                if(newcpcs.length >0)
                    formData.append('newcpcs', newcpcs);
                if(newbarrios.length > 0)
                    formData.append('newbarrios', newbarrios);
                if(newcategories.length>0)
                    formData.append('newcategories', newcategories);

                formData.append('chkUpdateEntities', 1);
            }

            Utilities.block();
            $.ajax({
                url: "/admin/SaveObrasFromFile", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                timeout: 240000,
                success: function(data)   // A function to be called if request succeeds
                {

                    if(data.status == 'Ok' )
                    {
                        $('#bulkLoadObras').html(data.data)
                            .css('max-height',$( window ).height()*0.6);
                        if(data.widthErrors)
                        {
                            Utilities.ShowMessage('Algunas obras no se han podido grabar , revise por favor.', 'Validar Obras');
                        }
                        else
                        {
                            CivicApp.ObrasGrid.ReloadGrid();
                        }
                        BindBulkInputs();


                    }
                    else
                    {
                        Utilities.ShowError(data.message);
                    }

                    $.unblockUI();


                },
                error:function( jqXHR, textStatus,  errorThrown )
                {
                    $.unblockUI();
                    Utilities.ShowError('Se ha producido un error al grabar las obras.'+errorThrown);
                }
            });
        };

        var BindBulkInputs = function()
        {
            $('[name^="beCpc"]').each(function(index,control){
                Utilities.AutocompleteSimple(control.id);

            });

            $('[name^="beBarrio"]').each(function(index,control){
                Utilities.AutocompleteSimple(control.id);

            });

            $('[name^="beCategory"]').each(function(index,control){
                Utilities.AutocompleteSimple(control.id);

            });

            $('[name^="beCpc"].invalid, [name^="beBarrio"].invalid, [name^="beCategory"].invalid ')
                .on('change', function()
                {
                    var field = $(this);
                    if(field.data('idSelected')) {
                        field.removeClass('invalid');
                        field.data('validfield',1);
                    }
                });

            $('[name^="beCpc"].invalid, [name^="beBarrio"].invalid, [name^="beCategory"].invalid ')
                .blur(function(){
                    $(this).trigger('change');
                });

            $('#bulkLoadObras .invalid ').not('[name^="beCpc"].invalid, [name^="beBarrio"].invalid, [name^="beCategory"]')
                .on('change', function()
                {
                    $(this).removeClass('invalid');
                });
        };


        var LoadFile = function()
        {


            if(!inputFile.val()) {
                Utilities.ShowMessage('Debe seleccionar un archivo csv para cargar', 'Seleccione Archivo');
                return;
            }


            var formData = new FormData($('#importFileForm')[0]);
            Utilities.block();
            $.ajax({
                url: "/admin/ImportFromFile", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                timeout: 2*60*60*1000,
                success: function(data)   // A function to be called if request succeeds
                {

                    if(data.status == 'Ok' ) {

                        $('#bulkLoadObras').html(data.data)
                            .css('max-height',$( window ).height()*0.6);

                        BindBulkInputs();

                        isLoadedFlag=true;

                    }
                    else
                    {
                        Utilities.ShowError(data.message);
                        isLoadedFlag=false;
                    }

                    $.unblockUI();

                },
                error:function( jqXHR, textStatus,  errorThrown )
                {
                    Utilities.ShowError('Se ha producido un error al subir los iconos.'+errorThrown);
                    $.unblockUI();
                }
            });
        };

        return {
            InitEvents : InitEvents
        }


    };
})();


$(document).ready(function(){

    debugger;
    CivicApp.Obra.ImportFile.InitEvents();
});
