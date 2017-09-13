<div class="panel panel-primary " id="FormObra">
    <div class="panel-heading">
        <h1 class="panel-title">Agregar / Editar Obra </h1>
    </div>
    <div class="panel-body custom-panel-primary-body">

        <div id="divMessages">

        </div>

        <div>

        </div>
        <div class="form-horizontal col-sm-12">
            <div class="form-inline col-sm-offset-10 col-sm-2 custom-form-inline" >

                                <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#LoadFromExcel">Cargar desde archivo
                                    <span class="glyphicon glyphicon-folder-open"></span>
                                </button>

            </div>
        </div>
        <hr>
        <input type="hidden" id="idObra" value=0" />
        <div class="form-horizontal col-sm-12">
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                    <label for="year" class="col-sm-4 control-label">Año</label>
                    <div class="col-sm-8">
                        <select id="year" name="year" class="form-control input-sm">
                            <option value=""></option>
                            @foreach($years as $year)
                                <option value="{{$year}}">{{ $year}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group" >
                    <label for="CPC" class="col-sm-4 control-label">CPC</label>
                    <div class="input-group col-sm-8 autocomplete" >
                            <input name="CPC" id="CPC" class="form-control input-sm fullWidth" required="required" type="text" data-methodadd="" data-listvalues="{{ $cpcs }}"/>
                            <span class="input-group-btn" >
                                <button id="addCPC" class="btn btn-primary input-sm fullWidth display-none"  type="button">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-horizontal col-sm-12">
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                    <label for="barrio" class="col-sm-4 control-label">Barrio</label>
                    <div class="input-group col-sm-8 autocomplete" >
                            <input name="barrio" id="barrio" class="form-control input-sm fullWidth" type="text" data-methodadd="" data-listvalues="{{ $barrios }}"/>
                            <span class="input-group-btn" >
                                <button id="addbarrio" class="btn btn-primary input-sm fullWidth display-none"  type="button">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                                <button id="editBarrio" class="btn btn-primary input-sm btn-sm fullWidth display-none" data-toggle="modal" data-target="#popUpLocation">
                                    <span class="fa fa-map-marker"></span>
                                </button>
                            </span>
                    </div>
                </div>

            </div>
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                    <label for="category" class="col-sm-4 control-label">Categor&iacute;a</label>
                    <div class="input-group col-sm-8 autocomplete" >
                        <input name="category" id="category" class="form-control input-sm fullWidth " data-methodadd="" data-listvalues="{{ $categories }}" type="text"/>
                        <span class="input-group-btn" >
                                <button id="addcategory" class="btn btn-primary input-sm btn-sm fullWidth display-none" data-toggle="modal"   type="button">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                                <button id="editIcons" class="btn btn-primary input-sm btn-sm fullWidth display-none" data-toggle="modal" data-target="#imagesUpload">
                                    <span class="fa fa-map-marker"></span>
                                </button>
                         </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="form-horizontal col-sm-12">
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                    <label for="title" class="col-sm-4 control-label">T&iacute;tulo</label>
                    <div class="col-sm-8">
                        <input name="title" id="title" class="form-control input-sm fullWidth" type="text"/>
                    </div>
                </div>
            </div>
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                    <label for="badget" class="col-sm-4 control-label">Presupuesto</label>
                    <div class="input-group col-sm-8 autocomplete">
                        <span class="input-group-addon">$</span>
                        <input name="badget" id="badget" aria-label="Monto en Pesos Argentinos" class="form-control input-sm input-number" type="number"/>

                    </div>
                </div>
            </div>
        </div>
        <div class="form-horizontal col-sm-12">
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                    <label for="nro_expediente" class="col-sm-4 control-label">Nro Expediente</label>
                    <div class="col-sm-8">
                        <input name="nro_expediente" id="nro_expediente" class="form-control input-sm fullWidth" maxlength="50" type="text"/>
                    </div>
                </div>
            </div>
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                    <label for="status" class="col-sm-4 control-label">Estado</label>
                    <div class="col-sm-8">
                        <select id="status" name="status" class="form-control input-sm fullWidth">
                            <option value=""></option>
                        @foreach( $statuses as $status )
                            <option value="{{$status->id}}">{{ $status->status }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

            </div>


        </div>
        <div class="form-horizontal col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: rgb(87, 140, 167);">
                    Ubicaci&oacute;n
                </div>
                <div class="panel-body" style="background-color: #B0CFDE;">
                    <div class="form-horizontal col-sm-12">
                        <div class="form-inline col-sm-6 custom-form-inline" >
                            <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                                <label for="autocompleteMap" class="col-sm-3 control-label">Ubicar</label>
                                <div class="col-sm-9">
                                    <input type="text" name="autocompleteMap" id="autocompleteMap" data-idGeoPoint="0" class="form-control input-sm fullWidth" placeholder="Buscar"  autofocus>
                                </div>

                            </div>
                        </div>
                        <div class="form-inline col-sm-6 custom-form-inline" >

                            <div id="map" style="width: 100%;height: 250px; border: 2px solid; border-color:#3B6999 ">

                            </div>

                        </div>

                    </div>


                </div>
            </div>

        </div>
        <div class="row" style="margin: 10px">
            <div class="col-sm-2 col-sm-offset-8">
                <div class="btn btn-sm  btn-primary btn-block" id="cancel">Cancelar</div>
            </div>
            <div class="col-sm-2">
                <div class="btn btn-sm btn-primary btn-block fullWidth"  id="save">Guardar</div>
            </div>
        </div>


    </div>
</div>

<!-- Modal -->
<div class="modal fade custom-modal modal-images rightLabel " id="imagesUpload" tabindex="-1" role="dialog" aria-labelledby="imagesUpload">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content cus-modal-images">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Definir Iconos</h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="imgUploadForm" role="form" method="POST" action="" >
                @foreach( $statuses as $status )
                    <div class="row">
                        <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                            <label for="icoComprometido" class="col-sm-4 control-label">Icono {{$status->status}}</label>
                            <div class="col-sm-6">
                                <input name="ico_{{$status->id.'_'.str_replace(' ','', $status->status)}}"  placeholder="Subir Icono" id="ico_{{$status->id.'_'.str_replace(' ','', $status->status)}}" class="form-control input-sm fullWidth imageUploader" type="file"/>
                            </div>
                            <div class="col-sm-1">
                                <img id="imgico_{{$status->id.'_'.str_replace(' ','', $status->status)}}" src="" alt="default"  >
                            </div>
                        </div>
                    </div>
                @endforeach
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveIcons">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div id="obraCommentsPanel" class="panel panel-primary panel-obraComments " style="display: none">
    <div class="panel-heading">
        <h1 class="panel-title">Comentarios de la Obra</h1>
        <div class="pull-right"><span id="commentsCount">0</span> Comentarios </div>
    </div>
    <div class="panel-body"  >
        <div id="noCommentsMsg" class="no-comments">No hay comentarios</div>
        <div id="obraComments">

        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade custom-modal " id="popUpLocation" tabindex="-1" role="dialog" aria-labelledby="popUpLocation">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content cus-modal-images">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Ubicar </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-horizontal col-sm-offset-1 col-sm-10">
                        <label for="autocompletepopUpMap" class="col-sm-2 control-label">Dirección</label>
                        <div class="col-sm-10">
                            <input type="text" name="autocompletepopUpMap" id="autocompletepopUpMap" data-idGeoPoint="0" class="form-control input-sm fullWidth" placeholder="Buscar"  autofocus>
                        </div>

                    </div>
                    <div class="form-horizontal col-sm-offset-1 col-sm-10 ">
                        <div id="popUpMap" style="width:100%;height:250px; border: 2px solid; border-color:#3B6999; margin: 0 auto; margin-top: 5px">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="savepopUpLocation">Guardar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade custom-modal " data-backdrop="static" id="LoadFromExcel" tabindex="-1" role="dialog" aria-labelledby="LoadFromExcel">
    <div class="modal-dialog modal-lg" style="width: 98%" role="document">
        <div class="modal-content cus-modal-images">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cargar desde Archivo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form enctype="multipart/form-data" id="importFileForm" role="form" method="POST" action="" >
                    <div class="form-horizontal  col-sm-12">
                        <label for="importFileCSV" class="col-sm-3 control-label">Seleccione archivo CSV</label>
                        <div class="col-sm-8">
                            <input type="file" name="importFileCSV" id="importFileCSV" data-idGeoPoint="0" class="form-control input-sm fullWidth"  autofocus>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary" id="LoadFileObras" >Cargar</button>

                    </div>
                    </form>
                </div>
                <form enctype="multipart/form-data" name="formObrasImport" id="formObrasImport" role="form" method="POST" action="">
                    <div class="row" id="bulkLoadObras">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="checkbox" name="chkUpdateEntities" style="float: left" id="chkUpdateEntities">
                <label for="chkUpdateEntities" style="float: left" class="">Dar de alta los Barrio, CPC y Categorías que no existan</label>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveObrasFile">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ComplaintsModal" tabindex="-1" role="dialog" aria-labelledby="ComplaintsModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Denuncias del Post</h4>
            </div>
            <div class="modal-body">
                <div id="complaintsList">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn custom-bottom btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@push('cssCustom')

{!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.min.css') !!}

@endpush

@push('scripts')

<script type="text/javascript">

    var ENV_MAPICONS_PATH = "{{ env('MAPICONS_PATH')  }}";
    var ENV_DEFAULT_ICON = "{{ env('ICON_DEFAULT')  }}";

    //src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKekXfhDy5EcVFpKfifb4eKgc3wRy3GgE&libraries=places&callback=CivicApp.Obra.InitMap">
</script>

{!! Html::script('assets/js/Custom/gmaphelper.js') !!}
{!! Html::script('assets/js/Custom/gmaphelper2.js') !!}
{!! Html::script('assets/js/Custom/popup-location-map.js') !!}
{!! Html::script('assets/js/Custom/obras-admin.js') !!}
{!! Html::script('assets/js/Custom/obras-importFile.js') !!}

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{env("GMAP_APIKEY")}}&libraries=places&callback=CivicApp.Obra.InitMap">
</script>

@endpush