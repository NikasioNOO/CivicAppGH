@push('scripts')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>

{!! Html::script('assets/js/Custom/obras-presupuesto-grid.js') !!}
@endpush

<div class="panel panel-primary ">
    <div class="panel-heading">
        <h1 class="panel-title">Listado de Obras </h1>

    </div>
    <div class="panel-body custom-panel-primary-body" style="padding: 0px">
        <div id="tableWrapper" class="col-sm-12 table-responsive" style="padding: 10px">
            <table id="obrasGrid" class=" table smaller table-striped table-bordered table-hover ">
                <thead>
                    <tr>
                        <th>Año</th>
                        <th>CPC</th>
                        <th>Barrio</th>
                        <th>Categor&iacute;a</th>
                        <th>Obra</th>
                        <th>Presupuesto</th>
                        <th>Estado</th>
                        <th>Ubicaci&oacute;n</th>
                        <th>NroExp</th>
                        <th>Denuncias</th>
                        <th>Posts</th>
                        <th>Opcion</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
