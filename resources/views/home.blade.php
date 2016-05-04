@extends('shared.layout')

@section('head')
    {!! Html::style('assets/css/Custom/singin.css') !!}
    <script type='text/javascript'>var centreGot = false;</script>
    {!!$map['js']!!}

@stop
@section('content')
    <div class="panel panel-primary ">
        <div class="panel-heading">
            <h class="panel-title">Inicio</h>
        </div>
        <div class="panel-body" style="padding: 0px">

            <div   style="width: 70%;float: left;border-top: 6px solid transparent;border-right: 20px solid transparent;border-color: #3B6999;background-color:#3B6999 ">
                <div style="margin: 4px">
                    <input type="text" name="autocompleteMap" id="autocompleteMap" class="form-control" placeholder="Buscar"  autofocus>
                </div>
                {!!$map['html']!!}
            </div>
            <div class=" " style="width:30%;float: right       ">
                <div class="" style="background-color:#3B6999;color: #fff;padding: 15px ">
                    <h>Informaci&oacute;n</h>
                </div>

            </div>


        </div>

    </div>

@endsection
@section('scripts')
    {!! Html::script('assets/js/Custom/gmaphelper.js') !!}

@stop