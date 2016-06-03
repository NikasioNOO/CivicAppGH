<input type="hidden" id="categoriesJson" value="{{ $categories }}" />
<input type="hidden" id="barriosJson" value="{{$barrios}}" />
<input type="hidden" id="statusesJson" value="{{$statuses}}" />
<input type="hidden" id="cpcsJson" value="{{$cpcs}}" />
<div class="panel panel-primary ">
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
        <div class="form-horizontal col-sm-12">
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                    <label for="Ano" class="col-sm-4 control-label">Año</label>
                    <div class="col-sm-8">
                        <select id="Ano" name="Ano" class="form-control input-sm">
                            <option>2016</option>
                            <option>2015</option>
                            <option>2014</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group" >
                    <label for="CPC" class="col-sm-4 control-label">CPC</label>
                    <div class="col-sm-8">
                        <select id="CPC" name="CPC" class="form-control input-sm fullWidth">
                            <option>Villa Libertador</option>
                            <option>Ruta 20</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-horizontal col-sm-12">
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                    <label for="barrio" class="col-sm-4 control-label">Barrio</label>
                    <div class="col-sm-8">
                        <input name="barrio" id="barrio" class="form-control input-sm fullWidth" type="text"/>
                    </div>
                </div>

            </div>
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                    <label for="categoria" class="col-sm-4 control-label">Categor&iacute;a</label>
                    <div class="input-group col-sm-8" style="padding-left: 15px;padding-right: 15px">
                        <input name="category" id="category" class="form-control input-sm fullWidth " data-methodadd="" data-listvalues="{{ $categories }}" type="text"/>
                        <span class="input-group-btn" >
                                <button id="addcategory" class="btn btn-primary input-sm fullWidth " style="display: none" type="button">
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
                    <label for="" class="col-sm-4 control-label">T&iacute;tulo</label>
                    <div class="col-sm-8">
                        <input name="categoria" id="categoria" class="form-control input-sm fullWidth" type="text"/>
                    </div>
                </div>
            </div>
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                    <label for="presupuesto" class="col-sm-4 control-label">Presupuesto</label>
                    <div class="col-sm-8">
                        <input name="presupuesto" id="presupuesto" class="form-control input-sm fullWidth" type="text"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-horizontal col-sm-12">
            <div class="form-inline col-sm-6 custom-form-inline" >
                <div class="form-group form-group-sm col-sm-12 custom-form-group " >
                    <label for="estado" class="col-sm-4 control-label">Estado</label>
                    <div class="col-sm-8">
                        <select id="estado" name="CPC" class="form-control input-sm fullWidth">
                            <option>Comprometido</option>
                            <option>En Ejecuci&oacute;n</option>
                            <option>Finalizado</option>
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
                                <label for="barrio" class="col-sm-3 control-label">Ubicar</label>
                                <div class="col-sm-9">
                                    <input type="text" name="autocompleteMap" id="autocompleteMap" class="form-control input-sm fullWidth" placeholder="Buscar"  autofocus>
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
                <button class="btn btn-sm  btn-primary btn-block" type="button">Cancelar</button>
            </div>
            <div class="col-sm-2">
                <div class="btn btn-sm btn-primary btn-block fullWidth"  type="submit">Guardar</div>
            </div>
        </div>


    </div>
</div>

@push('scripts')


{!! Html::script('assets/js/Custom/obras-admin.js') !!}
@endpush