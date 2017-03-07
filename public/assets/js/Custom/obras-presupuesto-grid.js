
(function(){
    this.CivicApp = this.CivicApp || {};
    this.CivicApp.ObrasGrid = this.CivicApp.ObrasGrid || new function(){
        var grid = null;
        var rowEdited= null;
        var InitGrid = function() {
            grid = $('#obrasGrid').DataTable({
               // serverSide:true,
                ajax: {
                    url:'/admin/GetAllObras',
                    type:'POST'
                },
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
                columns:[
                    {data:"year"},
                    {data:"cpc.name"},
                    {data:"barrio.name"},
                    {data:"category.category"},
                    {data:"description"},
                    {data:"budget",
                     render: $.fn.dataTable.render.number( '.', ',', 2, '$' )
                    },
                    {data:"status.status"},
                    {data:"address"},
                    {data:"nro_expediente"},
                    {data:"postComplaintsCount"},
                    {data:"posts_count"}
                ],
                columnDefs :[
                    {
                        render:function(data, type, row ){
                            return '<a class="linkAction" onclick="CivicApp.ObrasGrid.EditRow(this)">Editar</a>-<a class="linkAction" onclick="CivicApp.ObrasGrid.DelteRow(this)">Eliminar</a>';
                        },
                        targets:11
                    }

                ]
            });

           /* $('#obrasGrid tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );*/



        };



        var EditRow = function(cell)
        {
            rowEdited = cell.parentNode.parentNode;
            var obra = grid.row( rowEdited ).data();

            CivicApp.Obra.LoadObra(obra);

            CivicApp.Obra.FocusForm();


        };

        var CleanRowEdited = function()
        {
            rowEdited = null;
        };
        var UpdatePostComplaintsCountEdited = function(count)
        {
            if(rowEdited != null) {
                var obra = grid.row(rowEdited).data();
                obra.postComplaintsCount = parseInt(obra.postComplaintsCount) + count;
                grid.row(rowEdited).data(obra).draw();
            }
        };

        var DelteRow = function(cell)
        {

            var obra = grid.row( cell.parentNode.parentNode ).data();
            var html = '<div>  \
                   <p>Esta seguro que desea eliminar la Obra: </p> '+ obra.description + '\
                </div>';

            $(html).dialog(
                {
                    resizable:false,
                    modal: false,
                    title: 'Confirma',
                    width:500,
                    closeOnEscape:true,
                    show: { effect: "blind", duration: 200 },
                    hide: { effect: "blind", duration: 200 },
                    dialogClass: 'dialog-style no-close',
                    /*close: { function()
                     {
                     $(this).dialog('destroy');
                     $(this).remove();
                     return;
                     },*/
                    buttons:[
                        { text:'Aceptar',
                            click : function()
                            {
                                CivicApp.Obra.DeleteObra(obra.id);
                                $(this).dialog('destroy');
                                $(this).remove();
                                return;
                            }, class :'btn btn-sm btn-primary'},
                        { text:'Cancelar',
                            click : function()
                            {
                                $(this).dialog('destroy');
                                $(this).remove();
                                return;
                            }, class :'btn btn-sm btn-primary'}
                    ]

                }
            )
        };

        var ReloadGrid = function()
        {
            grid.ajax.reload();
        };

        return {

            InitGrid : InitGrid,
            ReloadGrid: ReloadGrid,
            EditRow : EditRow,
            DelteRow: DelteRow,
            UpdatePostComplaintsCountEdited:UpdatePostComplaintsCountEdited,
            CleanRowEdited:CleanRowEdited


        };

    };


})();


$(document).ready(function(){

    CivicApp.ObrasGrid.InitGrid();
});