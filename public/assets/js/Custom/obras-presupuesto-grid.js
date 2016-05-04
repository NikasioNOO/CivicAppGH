/**
 * Created by Nico on 23/04/2016.
 */
(function(){
    this.CivicApp = this.CivicApp || {};
    this.CivicApp.ObrasPres = this.CivicApp.ObrasPres || new function(){
        var grid = null
        var InitGrid = function() {
            grid = $('#obrasGrid').DataTable({
                language: {
                    search: "Buscar:",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    infoFiltered: "(filtrado del total _MAX_ registros)",
                    "lengthMenu": "Cantidad de registros por página _MENU_ ",
                    paginate: {
                        first: "Primera página",
                        last:"Última página",
                        next:"Próxima página",
                        previous:"Página previa"
                    },
                    emptyTable:"No hay Obras cargadas",
                    processing: "Procesando",
                    loadingRecords: "Por favor espere - cargando..."


                },
                columnDefs :[
                    {
                        render:function(data, type, row ){
                            return '<input type="checkbox" class="form-control">';
                        },
                        targets:0
                    },
                    {
                        render:function(data, type, row ){
                            return '<a>Editar | Eliminar</a>';
                        },
                        targets:9
                    },

                ]
            });

            $('#obrasGrid tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );

        };

        return {

            InitGrid : InitGrid

        };

    };


})();


$(document).ready(function(){

    CivicApp.ObrasPres.InitGrid();
});