@extends('shared.layout')


@section('head')



@stop
@section('content')

    @include('admin.ObrasPresupuestoGrid')

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
                        <div class="col-sm-8">
                            <input name="categoria" id="categoria" class="form-control input-sm fullWidth" type="text"/>
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

    <div class="panel panel-primary ">
        <div class="panel-heading">
            <h1 class="panel-title">Post Publicados </h1>

        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="form-inline col-sm-12 custom-form-inline" >
            <div class="form-horizontal col-sm-4 " style="padding: 4px">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Reclamos</h3>

                    </div>
                    <div class="panel-body" style="padding:0">
                        <div class="panel panel-default" style="padding: 2px;margin: 2px">
                            <div class="panel-body" style="padding: 2px">
                                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <div class="form-horizontal col-sm-12" >
                                    <div class="form-group">

                                        <img class="img-responsive img-circle col-sm-3" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xtf1/v/t1.0-1/c13.0.50.50/p50x50/169050_193796070646914_5242956_n.jpg?oh=501474fc82d97b0213a986d046251008&oe=57B13659&__gda__=1467074271_48987bfc08085de65801dfb1f30f2369">

                                            <label class="col-xs-9" style="font-size: small; text-decoration: none;font-weight: normal; margin: 0px;padding: 0px">Lanata aadadfadf adfadf</label>
                                            <label class="col-xs-9" style="font-size: small; font-style: italic;font-weight: normal;color: #2aabd2; margin: 0px;padding: 0px">20/04/2016 14:00:00</label>
                                            <label class="col-xs-9" style="font-size: small; font-style: italic;font-weight: normal;color:red; margin: 0px;padding: 0px">Estado: Ejecución</label>

                                    </div>
                                </div>
                                <div class="col-sm-12" >
                                    <div class=" fullWidth" style="font-size: small">Value elegance, simplicity, and readability? You’ll fit right in. Laravel is designed for people just like you. If you need help getting started, check out Laracasts and our great documentation.</div>
                                           <!-- <textarea  readonly style="resize: none" disabled class="form-control  fullWidth postArea" >
                                        At w3schools.com you will learn how to make a website. We offer free tutorials in all web development technologies.
                                            </textarea> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="form-horizontal col-sm-4 " style="padding: 4px">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Novedad</h3>

                    </div>
                    <div class="panel-body">
                    </div>
                </div>
            </div>
            <div class="form-horizontal col-sm-4 " style="padding: 4px">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Positivo</h3>

                    </div>
                    <div class="panel-body">

                    </div>
                </div>
            </div>

        </div>
        </div>
    </div>

@endsection
@push('scripts')
    {!! Html::script('assets/js/Custom/gmaphelper.js') !!}
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKekXfhDy5EcVFpKfifb4eKgc3wRy3GgE&callback=CivicApp.GmapHelper.InitMap">
    </script>

@endpush