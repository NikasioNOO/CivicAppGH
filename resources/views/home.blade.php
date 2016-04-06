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
        <div class="panel-body">
            {!! Form::open(['url' => '#', 'class' => 'form-signin form-horizontal' ] ) !!}
            @include('includes.errors')
            <a href="{{ route('social.redirect', ['provider' => 'facebook']) }}" class="btn btn-primary btn-block facebook" type="submit">Facebook</a>
            <a href="{{ route('social.redirect', ['provider' => 'twitter']) }}" class="btn btn-primary btn-block twitter" type="submit">Twitter</a>

            {!! Form::close() !!}
        </div>

    </div>
    <div>
        <input type="text" name="autocompleteMap" id="autocompleteMap" class="form-control" placeholder="Buscar"  autofocus>
    </div>
    {!!$map['html']!!}
@endsection
@section('scripts')
    {!! Html::script('assets/js/Custom/gmaphelper.js') !!}

@stop