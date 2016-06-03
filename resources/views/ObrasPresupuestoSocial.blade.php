@extends('shared.layout')

@section('head')
    {!! Html::style('assets/css/Custom/singin.css') !!}
@stop
@section('content')

    <div class="modal fade and carousel slide" id="lightbox">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-body">

                        <ol class="carousel-indicators">
                            <li data-target="#lightbox" data-slide-to="0" class="active"></li>
                            <li data-target="#lightbox" data-slide-to="1"></li>
                            <li data-target="#lightbox" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="{{ asset('assets/images/parque2.png') }}" alt="First slide">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/images/parque1.png') }}" alt="Second slide">
                            </div>
                            <div class="item">
                                <img src="http://placehold.it/900x500/555/" alt="Third slide">
                                <div class="carousel-caption"><p>even with captions...</p></div>
                            </div>
                        </div><!-- /.carousel-inner -->
                        <a class="left carousel-control" href="#lightbox" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#lightbox" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div><!-- /.modal-body -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="panel panel-primary ">
        <div class="panel-heading">
            <h1 class="panel-title">Obras del Presupuesto Participativo</h1>
        </div>
        <div class="panel-body custom-panel-primary-body " >
            @include('includes.errors')



            <div class="panel panel-default" style="background-color: #B0CFDE;">
                <div class="panel-body">
                    <div class="form-inline">
                        <div class="form-group col-sm-2">
                            <label for="anoFilter" class="label-blue">Año</label>
                            <select id="anoFilter" name="anoFilter" class="form-control input-sm">
                                <option>2016</option>
                                <option>2015</option>
                                <option>2014</option>
                                <option>2013</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-5">
                            <label for="categoriaFilter" class="label-blue">Categoría</label>
                            <select id="categoriaFilter" style="width: 78%" name="categoriaFilte" class="form-control input-sm ">
                                <option>Espacios Verdes</option>
                                <option>Trasito</option>
                                <option>Social</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-5">
                            <label for="barrioFilter" class="label-blue">Barrio</label>
                            <select id="barrioFilter" style="width: 78%" name="barrioFilter" class="form-control input-sm">
                                <option>Barrio Jardin</option>
                                <option>Cofico</option>
                                <option>Alta Córdoba</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="panel panel-success panel-info-obra espacios-verdes">
                    <div class="panel-heading" ><h3 class="panel-title"></h3>Equipamiento de Bancos de H°A° y Cestos Papeleros para las plazas .Equipamiento Global</div>
                    <div class="panel-body">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner " role="listbox">
                                <div class="item active">
                                    <a href="#lightbox" data-toggle="modal" data-slide-to="0"><img class="img-responsive img-rounded" src="{{ asset('assets/images/parque2.png') }}" alt="..."></a>
                                    <div class="carousel-caption">

                                    </div>
                                </div>
                                <div class="item">
                                    <a href="#lightbox" data-toggle="modal" data-slide-to="1"><img class="img-responsive img-rounded" src="{{ asset('assets/images/parque1.png') }}" alt="..."></a>
                                    <div class="carousel-caption">

                                    </div>
                                </div>
                                <div class="item">
                                    <a href="#lightbox" data-toggle="modal" data-slide-to="2"><img class="img-responsive img-rounded" src="{{ asset('assets/images/parque1.png') }}" alt="..."></a>
                                    <div class="carousel-caption">

                                    </div>
                                </div>

                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="container-fluid containter-info-obra">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Año</label>
                            </div>
                            <div class="col-sm-8">
                                <label>2016</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label>CPC</label>
                            </div>
                            <div class="col-sm-8">
                                <label>Villa Libertador</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Barrio</label>
                            </div>
                            <div class="col-sm-8">
                                <label>Santa Isabel</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Categoría</label>
                            </div>
                            <div class="col-sm-8">
                                <label>Espacios Verdes</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Presupuesto</label>
                            </div>
                            <div class="col-sm-8">
                                <label>$ 100.000</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Estado</label>
                            </div>
                            <div class="col-sm-8">
                                <label>Comprometido</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div id="map" class="map-wrapper">

                </div>
            </div>

        </div>

    </div>
    <div class="panel panel-primary ">
        <div class="panel-heading">
            <h1 class="panel-title">Comentarios</h1>
        </div>
        <div class="panel-body custom-panel-primary-body " style="padding: 10px" >
            <div class="panel panel-default">
                <div class="panel-title user-comment">
                    <div class="form-inline">
                        <div class="form-group">
                            <div class="avatar-wrapper img-circle">
                                <img src="{{ Auth::guard('websocial')->user()->avatar }}"  class="img-responsive avatar-width" alt="Avatar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="">{{ Auth::guard('websocial')->user()->username }}</label>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="padding-bottom: 0">
                    <div class="container-fluid">
                       <div class="row" style="padding-bottom: 15px">
                           <div class="col-md-9">
                               <div class="row">
                                   <div class="col-md-12">
                                   <textarea class="form-control" style="resize: none"  >

                                   </textarea>
                                   </div>

                               </div>
                               <div class="row" style="margin-top:5px;" >

                                   <div class="col-sm-8">
                                       <div class="form-inline">
                                           <div class="form-group">
                                               <label class="control-label label-small ">Sugerir cambio de estado</label>
                                               <select class="form-control input-sm small-select status-select ">
                                                   <option></option>
                                                   <option>En ejecucion</option>
                                                   <option>Finalizado</option>
                                               </select>
                                           </div>
                                       </div>

                                   </div>
                                   <div class="col-sm-4">
                                       <div class="btn-group  btn-group-xs btn-group-justified" role="group" aria-label="...">
                                           <div class="btn-group btn-group-xs" role="group">
                                               <button type="button" class="btn btn-danger">Reclamo</button>
                                           </div>
                                           <div class="btn-group btn-group-xs" role="group">
                                               <button type="button" class="btn btn-success">Positivo</button>
                                           </div>
                                           <div class="btn-group btn-group-xs" role="group">
                                               <button type="button" class="btn btn-warning">Novedad</button>
                                           </div>
                                       </div>
                                   </div>

                               </div>
                           </div>
                           <div class="col-md-3">

                               <div class="row">
                                   <div class="col-sm-5"><a class="btn btn-sm btn-default "><sapn class="fa fa-camera"></sapn> Subir Foto</a></div>
                                   <div class="col-sm-7">
<!--                                       <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">


                                           <!-- Wrapper for slides --
                                           <div class="carousel-inner " role="listbox">
                                               <div class="item active">
                                                   <a href="#lightbox" data-toggle="modal" data-slide-to="0"><img class="img-responsive img-rounded" src="{{ asset('assets/images/parque2.png') }}" alt="..."></a>
                                                   <div class="carousel-caption">

                                                   </div>
                                               </div>
                                               <div class="item">
                                                   <a href="#lightbox" data-toggle="modal" data-slide-to="1"><img class="img-responsive img-rounded" src="{{ asset('assets/images/parque1.png') }}" alt="..."></a>
                                                   <div class="carousel-caption">

                                                   </div>
                                               </div>
                                               <div class="item">
                                                   <a href="#lightbox" data-toggle="modal" data-slide-to="2"><img class="img-responsive img-rounded" src="{{ asset('assets/images/parque1.png') }}" alt="..."></a>
                                                   <div class="carousel-caption">

                                                   </div>
                                               </div>

                                           </div>

                                           <!-- Controls --
                                           <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                               <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                               <span class="sr-only">Previous</span>
                                           </a>
                                           <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                               <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                               <span class="sr-only">Next</span>
                                           </a>
                                       </div> -->
                                   </div>

                               </div>

                           </div>
                       </div>

                    </div>
                </div>
            </div>
            <div class="row">
            <p class="subtitle fancy"><label>3 Comentarios </label></p>
            </div>
            <div class="panel panel-default">
                <div class="panel-title user-comment posted novedad">
                    <div class="form-inline">
                        <div class="form-group">
                            <div class="avatar-wrapper img-circle">
                                <img src="{{ Auth::guard('websocial')->user()->avatar }}"  class="img-responsive avatar-width" alt="Avatar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="">{{ Auth::guard('websocial')->user()->username }}</label>
                            <label >01/05/2016 12:34:21</label>
                        </div>
                        <div class="form-group pull-right">
                            <span class="glyphicon glyphicon-thumbs-up"></span><span style="margin-left: 5px" class="badge">4</span>
                            <span class="glyphicon glyphicon-thumbs-down"></span><span style="margin-left: 5px" class="badge">2</span>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="padding-bottom: 0">
                    <div class="container-fluid">
                        <div class="row" style="padding-bottom: 15px">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12 well">Se estan iniciando las instalaciones de bancos en las plazas </div>
                                </div>
                                <div class="row" style="margin-top:5px;" >

                                    <div class="col-sm-6">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <label class="control-label label-small ">Cambio de estado: <b> En Ejecucion </b></label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-inline pull-right">
                                            <div class="form-group">
                                                <a class="" style="margin-right: 5px"><span class="glyphicon glyphicon-thumbs-up" style="margin-right: 3px"></span>Me gusta</a>
                                            </div>
                                            <div class="form-group">
                                                <a class="" style="margin-right: 5px"><span class="glyphicon glyphicon-thumbs-down" style="margin-right: 3px"></span>No me gusta</a>
                                            </div>
                                            <div class="form-group">
                                                <a class="" style="margin-left: 20px"><span class="fa fa-hand-stop-o" style="margin-right: 3px"></span>Denunciar comentario</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="row">
                                    <div class="col-sm-5">
                                        <span  class="label label-warning" style="padding: 3px 20px">Novedad</span>
                                    </div>
                                    <div class="col-sm-7">
                                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                            <!-- Indicators -->

                                            <!-- Wrapper for slides -->
                                            <div class="carousel-inner " role="listbox">
                                                <div class="item active">
                                                    <a href="#lightbox" data-toggle="modal" data-slide-to="0"><img class="img-responsive img-rounded" src="{{ asset('assets/images/parque2.png') }}" alt="..."></a>
                                                    <div class="carousel-caption">

                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <a href="#lightbox" data-toggle="modal" data-slide-to="1"><img class="img-responsive img-rounded" src="{{ asset('assets/images/parque1.png') }}" alt="..."></a>
                                                    <div class="carousel-caption">

                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <a href="#lightbox" data-toggle="modal" data-slide-to="2"><img class="img-responsive img-rounded" src="{{ asset('assets/images/parque1.png') }}" alt="..."></a>
                                                    <div class="carousel-caption">

                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Controls -->
                                            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-title user-comment posted positivo">
                    <div class="form-inline">
                        <div class="form-group">
                            <div class="avatar-wrapper img-circle">
                                <img src="{{ Auth::guard('websocial')->user()->avatar }}"  class="img-responsive avatar-width" alt="Avatar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="">{{ Auth::guard('websocial')->user()->username }}</label>
                            <label >01/05/2016 12:34:21</label>
                        </div>
                        <div class="form-group pull-right">
                            <span class="glyphicon glyphicon-thumbs-up"></span><span style="margin-left: 5px" class="badge">4</span>
                            <span class="glyphicon glyphicon-thumbs-down"></span><span style="margin-left: 5px" class="badge">2</span>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="padding-bottom: 0">
                    <div class="container-fluid">
                        <div class="row" style="padding-bottom: 15px">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12 well">Que bueno que van a arreglar las plazas jajajajjajaajjajajajaj ajajaj jaja ajaja aj jajajaja ja aja  jajajajjajaajjajajajaj ajajaj jajajajjajaajjajajajaj ajajaj jajajajjajaajjajajajaj ajajaj jajajajjajaajjajajajaj ajajaj jajajajjajaajjajajajaj ajajaj jajajajjajaajjajajajaj ajajaj jajajajjajaajjajajajaj ajajajaja a ajajaja a ja jaaj ajajajja aja ja  </div>
                                </div>
                                <div class="row" style="margin-top:5px;" >

                                    <div class="col-sm-6">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <label class="control-label label-small "></label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-inline pull-right">
                                            <div class="form-group">
                                                <a class="" style="margin-right: 5px"><span class="glyphicon glyphicon-thumbs-up" style="margin-right: 3px"></span>Me gusta</a>
                                            </div>
                                            <div class="form-group">
                                                <a class="" style="margin-right: 5px"><span class="glyphicon glyphicon-thumbs-down" style="margin-right: 3px"></span>No me gusta</a>
                                            </div>
                                            <div class="form-group">
                                                <a class="" style="margin-left: 20px"><span class="fa fa-hand-stop-o" style="margin-right: 3px"></span>Denunciar comentario</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="row">
                                    <div class="col-sm-5">
                                        <span  class="label label-success" style="padding: 3px 20px">Positivo</span>
                                    </div>
                                    <div class="col-sm-7">

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-title user-comment posted reclamo">
                    <div class="form-inline">
                        <div class="form-group">
                            <div class="avatar-wrapper img-circle">
                                <img src="{{ Auth::guard('websocial')->user()->avatar }}"  class="img-responsive avatar-width" alt="Avatar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="">{{ Auth::guard('websocial')->user()->username }}</label>
                            <label >01/05/2016 12:34:21</label>
                        </div>
                        <div class="form-group pull-right">
                            <span class="glyphicon glyphicon-thumbs-up"></span><span style="margin-left: 5px" class="badge">4</span>
                            <span class="glyphicon glyphicon-thumbs-down"></span><span style="margin-left: 5px" class="badge">2</span>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="padding-bottom: 0">
                    <div class="container-fluid">
                        <div class="row" style="padding-bottom: 15px">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12 well">Hace 2 meses que estan paradas las obras </div>
                                </div>
                                <div class="row" style="margin-top:5px;" >

                                    <div class="col-sm-6">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <label class="control-label label-small "></label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-inline pull-right">
                                            <div class="form-group">
                                                <a class="" style="margin-right: 5px"><span class="glyphicon glyphicon-thumbs-up" style="margin-right: 3px"></span>Me gusta</a>
                                            </div>
                                            <div class="form-group">
                                                <a class="" style="margin-right: 5px"><span class="glyphicon glyphicon-thumbs-down" style="margin-right: 3px"></span>No me gusta</a>
                                            </div>
                                            <div class="form-group">
                                                <a class="" style="margin-left: 20px"><span class="fa fa-hand-stop-o" style="margin-right: 3px"></span>Denunciar comentario</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="row">
                                    <div class="col-sm-5">
                                        <span  class="label label-danger" style="padding: 3px 20px">Reclamo</span>
                                    </div>
                                    <div class="col-sm-7">

                                    </div>

                                </div>

                            </div>
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
        src="https://maps.googleapis.com/maps/api/js?key={{env("GMAP_APIKEY")}}&callback=CivicApp.GmapHelper.InitMap">
</script>

@endpush