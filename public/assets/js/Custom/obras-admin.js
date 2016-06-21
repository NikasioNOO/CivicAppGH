(function(){



    this.CivicApp = this.CivicApp || {};
    this.CivicApp.Obra = this.CivicApp.Obra || new function(){
        var categories = [];
        var barrios = [];
        var statuses = [];
        var cpcs = [];
        var categoryAcutocomplete;

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
                        CivicApp.GmapHelper.SetIndividualMarker(value.location, this.address);
                    }
                    else
                    {
                        locationInput.data('idgeopoint', 0);
                        locationInput.data('latLng', '');
                        CivicApp.GmapHelper.HideIndividualMarker();
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
                        barrioInput.val(newValue.value);
                    }
                    else
                    {
                        barrioInput.data('idSelected',0);
                        barrioInput.val('');
                    }

                },
                enumerable:true
            });

            Object.defineProperty(this, 'category', {
                get: function() {
                    var id = categoryInput.data('idSelected');
                    return id ? { id:id }: {id:0} ;
                },
                set: function(value) {
                    var listvalues = categoryInput.data('listvalues');
                    var newValue = Utilities.findandGetInList(listvalues,'id',value.id);
                    if(newValue) {
                        categoryInput.data('idSelected',newValue.id);
                        categoryInput.val(newValue.value);
                    }
                    else
                    {
                        categoryInput.data('idSelected',0);
                        categoryInput.val('');
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

            CivicApp.GmapHelper.HideIndividualMarker();

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

        };

        var FocusForm= function()
        {
            $(window).scrollTop($('#FormObra').position().top);
        }

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




        var InitilizeMap = function()
        {
            var init = CivicApp.GmapHelper.InitMap();
            init.then(function() {

                CivicApp.GmapHelper.SouthWest = '-31.471168, -64.278946';
                CivicApp.GmapHelper.NorthEast = '-31.361003, -64.090805';
                CivicApp.GmapHelper.CreateAutocomplete('autocompleteMap');
                CivicApp.GmapHelper.AddEventClickAddMarker();
            });

        };

        var LoadCatalogs = function() {
            debugger;


            Utilities.Autocomplete('category','/admin/AddCategory');
            Utilities.Autocomplete('barrio','/admin/AddBarrio');
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
