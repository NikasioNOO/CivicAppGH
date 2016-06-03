(function(){



    this.CivicApp = this.CivicApp || {};
    this.CivicApp.Obra = this.CivicApp.Obra || new function(){
        var categories = [];
        var barrios = [];
        var statuses = [];
        var cpcs = [];
        var categoryAcutocomplete;
        var LoadCatalogs = function() {
            debugger;
            categories = JSON.parse($('#categoriesJson').val());
            barrios = JSON.parse($('#barriosJson').val());
            cpcs = JSON.parse($('#cpcsJson').val());
            statuses = JSON.parse($('#statusesJson').val());

            Utilities.Autocomplete('category','/admin/AddCategory');



            /*$("#category").autocomplete({
                //source:categories,
                source: function (request, response)
                {
                    var cat = $.map(categories, function (cat) {
                        return {
                            label: cat.category,
                            value: cat.category,
                            id: cat.id
                        };
                    })


                    response(cat.filter(function(entry){
                        return entry.value.toUpperCase().indexOf(request.term.toUpperCase()) >=0;
                    }));
                   // response($.ui.autocomplete.filter(categories, request.term));
                },
               /* focus:function(event, ui)
                {
                    $( "#category" ).val( ui.item.category );
                    return false;
                },
                change: function (event, ui) {

                    var flag =  $("#category").val().trim() != "" && !ui.item;
                    if(!flag)
                        $("#category").data('id',ui.item.id);
                    $("#addCategory").toggle(flag);
                }
            });

            $("#addCategory").on("click", function () {
                var control = this;
                $.post('/admin/AddCategory',{"category":$("#category").val().trim()},
                function(data){
                    if(data.status =='Ok')
                    {
                        var item ={
                            id :data.data.id,
                            category : data.data.category

                        };

                        categories.push(item);
                        $(control).hide();
                    }
                    else
                    {
                        alert(data.message);
                    }
                }).fail(function(data){
                        alert('No se pudo gurarda la nueva categoría');
                    });

            });*/
        };

        return {

            LoadCatalogs : LoadCatalogs

        };

    };

})();


$(document).ready(function(){
    debugger;
    CivicApp.Obra.LoadCatalogs();
});
