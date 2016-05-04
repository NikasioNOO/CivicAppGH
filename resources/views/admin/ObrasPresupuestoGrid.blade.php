@push('scripts')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>

{!! Html::script('assets/js/Custom/obras-presupuesto-grid.js') !!}
@endpush

<div class="panel panel-primary ">
    <div class="panel-heading">
        <h1 class="panel-title">Listado de Obras </h1>

    </div>
    <div class="panel-body custom-panel-primary-body" style="padding: 0px">
        <div id="tableWrapper" class="col-sm-12 table-responsive" style="padding: 10px">
            <table id="obrasGrid" class=" table table-striped table-bordered table-hover ">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Año</th>
                        <th>CPC</th>
                        <th>Barrio</th>
                        <th>Categor&iacute;a</th>
                        <th>Obra</th>
                        <th>Presupuesto</th>
                        <th>Estado</th>
                        <th>Ubicaci&oacute;n</th>
                        <th>Opcion</th>
                    </tr>
                </thead>
              <!--  <tfoot>
                    <tr>
                        <th>Año</th>
                        <th>CPC</th>
                        <th>Barrio</th>
                        <th>Categor&iacute;a</th>
                        <th>Obra</th>
                        <th>Presupuesto</th>
                        <th>Estado</th>
                        <th>Ubicaci&oacute;n</th>
                    </tr>
                </tfoot> -->
                <tbody>
                    <tr>
                        <td></td>
                        <td>2013</td>
                        <td>CPC Villa Libertador</td>
                        <td>Barrio Jardín</td>
                        <td>Tr&aacute;ncito</td>
                        <td>Intalaci&oacute;n de un sem&aacute;foro</td>
                        <td>300000</td>
                        <td>Comprometido</td>
                        <td>Nores Martinez 565</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>2013</td>
                        <td>CPC Villa Libertador</td>
                        <td>Barrio Jardín</td>
                        <td>Tr&aacute;ncito</td>
                        <td>Intalaci&oacute;n de un sem&aacute;foro</td>
                        <td>300000</td>
                        <td>Comprometido</td>
                        <td>Nores Martinez 565</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>2013</td>
                        <td>CPC Villa Libertador</td>
                        <td>Barrio Jardín</td>
                        <td>Tr&aacute;ncito</td>
                        <td>Intalaci&oacute;n de un sem&aacute;foro</td>
                        <td>300000</td>
                        <td>Comprometido</td>
                        <td>Nores Martinez 567</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
