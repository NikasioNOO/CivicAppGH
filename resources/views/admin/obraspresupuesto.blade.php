@extends('shared.layout2')


@section('head')



@stop
@section('content')

    @include('admin.ObrasPresupuestoGrid')

    @include('admin.obraPresupuestoDetail')

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


@endpush