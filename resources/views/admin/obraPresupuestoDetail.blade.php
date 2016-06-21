<div class="panel panel-primary " id="FormObra">
    <div class="panel-heading">
        <h1 class="panel-title">Agregar / Editar Obra </h1>
    </div>
    <div class="panel-body custom-panel-primary-body">

        @include('includes.errors')
        <div>

        </div>
        <div class="form-horizontal col-sm-12">
            <div class="form-inline col-sm-offset-6 col-sm-6 custom-form-inline" >
                <div class="form-group col-sm-12 ">
                    <label class="col-sm-4 control-label">Cargar desde archivo</label>
                    <div class="input-group col-sm-8">
                        <input type="text" class="form-control" placeholder="Seleccionar archivo">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button">Buscar
                                    <span class="glyphicon glyphicon-folder-open"></span>
                                </button>
                            </span>
                    </div>
                </div>
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
                            <input name="CPC" id="CPC" class="form-control input-sm fullWidth" type="text" data-methodadd="" data-listvalues="{{ $cpcs }}"/>
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
                                <button id="addcategory" class="btn btn-primary input-sm fullWidth display-none"  type="button">
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

@push('scripts')

{!! Html::script('assets/js/Custom/gmaphelper.js') !!}
{!! Html::script('assets/js/Custom/obras-admin.js') !!}

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKekXfhDy5EcVFpKfifb4eKgc3wRy3GgE&libraries=places&callback=CivicApp.Obra.InitMap">
</script>
@endpush