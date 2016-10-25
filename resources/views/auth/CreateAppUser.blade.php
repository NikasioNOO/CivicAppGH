@extends('shared.layout2')

@section('head')
    {!! Html::style('assets/css/Custom/register.css') !!}
@stop

@section('content')

    <div class="panel panel-primary ">
        <div class="panel-heading">
            <h class="panel-title">Crear Usuario</h>
        </div>
        <div class="panel-body">
            {!! Form::open(['url' => '#', 'class' => 'form-signin form-horizontal' ] ) !!}
            {!! Form::hidden('hdnRoles','',['id' => 'hdnRoles' ]) !!}
            @include('includes.errors')
            <div class="form-group form-group-sm">
                <label for="inputUserName" class="col-sm-4 control-label">Nombre Usuario</label>
                <div class="col-sm-8">
                    {!! Form::text('username', null, ['class' => 'form-control input-sm', 'placeholder' => 'Usuario', 'required', 'autofocus', 'id' => 'inputUserName' ]) !!}
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="inputEmail" class="col-sm-4 control-label">Direcci&oacute;n de mail</label>
                <div class="col-sm-8">
                    {!! Form::email('email', null, ['class' => 'form-control input-sm', 'placeholder' => 'Dirección Email', 'required', 'autofocus', 'id' => 'inputEmail' ]) !!}
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="inputFirstName" class="col-sm-4 control-label">Nombres</label>
                <div class="col-sm-8">
                    {!! Form::text('first_name', null, ['class' => 'form-control input-sm', 'placeholder' => 'Nombre', 'required', 'id' => 'inputFirstName' ]) !!}
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="inputLastName" class="col-sm-4 control-label">Apellidos</label>
                <div class="col-sm-8">
                    {!! Form::text('last_name', null, ['class' => 'form-control input-sm', 'placeholder' => 'Apellidos', 'required', 'id' => 'inputLastName' ]) !!}
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="inputPassword" class="col-sm-4 control-label">Contraseña</label>
                <div class="col-sm-8">
                    {!! Form::password('password', ['class' => 'form-control input-sm', 'placeholder' => 'Contraseña', 'required','pattern' => '.{5,10}' , 'id' => 'inputPassword' ]) !!}
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label for="inputPasswordConfirm" class="col-sm-4  control-label">Confirme Contraseña</label>
                <div class="col-sm-8">
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Password confirmation', 'required', 'confirmed',  'id' => 'inputPasswordConfirm' ]) !!}
               </div>
            </div>

            <div class="form-group form-group-sm">
                <label for="selectRole" class="col-sm-4 control-label">Rol</label>
                <div class="col-sm-5">
                    {!! Form::select('role', $ddlRoles,'', ['class' => 'form-control','placeholder' => 'Seleccione el rol', 'id'=> 'selectRole'])!!}
                </div>
                <button type="button" class="col-sm-3 btn btn-primary btn-sm" id="btnAddRole">Agregar role</button>
            </div>
            <div class="col-sm-8 col-sm-offset-2">
            <div class="panel panel-info table-responsive">
                <div class="panel-heading">
                    <h>Roles seleccionados</h>
                </div>
                <table id="tbRole" class="table table-striped table-hover  ">
                    <thead>
                        <tr>
                            <th class="col-xs-1">Id</th>
                            <th class="col-xs-8">Role</th>
                            <th class="col-xs-3">Opci&oacute;n</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Registrar</button>


            {!! Form::close() !!}
        </div>
    </div>

@stop
@push('scripts')
{!! Html::script('assets/js/Custom/auth/createUser.js') !!}

@endpush