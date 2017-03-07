@extends('shared.layout2')

@section('head')
    {!! Html::style('assets/css/Custom/singin.css') !!}
@stop

@section('content')


    {!! Form::open(['url' => '#', 'class' => 'form-signin' ] ) !!}

        @include('includes.status')

        <div class="form-group">
            <h class="form-signin-heading">Por favor inicie sesi&oacute;n</h>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="sr-only">Email</label>
            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        </div>
        <div class="form-group">
            <label for="inputPassword" class="sr-only">Contraseña</label>
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required',  'id' => 'inputPassword' ]) !!}
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" id="rememberCheck" name="remember" value="1"> Recordarme
            </label>
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar Sesi&oacute;n</button>
            <a href="#">¿Olvid&oacute; su contraseña?</a>
        </div>
    {!! Form::close() !!}
@stop
