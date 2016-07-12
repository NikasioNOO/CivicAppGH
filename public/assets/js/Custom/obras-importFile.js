
(function(){

    this.CivicApp = this.CivicApp || {};
    this.CivicApp.Obra = this.CivicApp.Obra ||{};
    this.CivicApp.Obra.ImportFile = this.CivicApp.Obra.ImportFile || new function() {

        var inputFileImport = $('#LoadFileObras');
        var InitEvents = function()
        {
            debugger;
            inputFileImport.on('click',function()
            {
                LoadFile();
            });

            inputFileImport.on('change',function(){
                var file = this.files[0];
                var imageFile = file.type;
                var match= "file/csv";
                if(!(imageFile==match))
                {
                    Utilities.ShowMessage('Debe elegir archivos de imagen csv, gracias');

                    return false;
                }
            });
        };

        var LoadFile = function()
        {
            var inputFile = $('#importFileCSV');

            if(!inputFile.val())
                Utilities.ShowMessage('Debe seleccionar un archivo csv para cargar','Seleccione Archivo');


            var formData = new FormData($('#importFileForm')[0]);

            $.ajax({
                url: "/admin/ImportFromFile", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success: function(data)   // A function to be called if request succeeds
                {
                    if(data.status == 'Ok' ) {
                        Utilities.ShowSuccesMessage('Se ha subido correctamente el archivo');

                    }
                    else
                    {
                        Utilities.ShowError(data.message);
                    }



                },
                error:function( jqXHR, textStatus,  errorThrown )
                {
                    Utilities.ShowError('Se ha producido un error al subir el archivo.'+errorThrown);
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
