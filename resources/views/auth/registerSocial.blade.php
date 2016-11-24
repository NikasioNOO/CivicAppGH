@push('cssCustom')





@endpush
<div class="modal fade custom-modal modal-login "  id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="modalRegister">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content cus-modal-images">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"  >Registrarse</h4>
            </div>
            <div class="modal-body">

                <div id="divMessageRegister"></div>

                <div class="row">
                    {!! Form::open(['url' => '#', 'class' => 'form-social-singin form-horizontal' ] ) !!}

                    <div class="form-group form-group-sm">
                        <label for="inputUserName" class="col-sm-4 control-label">Nombre Usuario</label>
                        <div class="col-sm-8">
                            {!! Form::text('username', null, ['class' => 'form-control input-sm', 'placeholder' => 'Usuario', 'required', 'autofocus', 'id' => 'userNameReg' ]) !!}
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="inputEmail" class="col-sm-4 control-label">Direcci&oacute;n de mail</label>
                        <div class="col-sm-8">
                            {!! Form::email('email', null, ['class' => 'form-control input-sm', 'placeholder' => 'Dirección Email', 'required', 'id' => 'emailReg' ]) !!}
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="inputFirstName" class="col-sm-4 control-label">Nombres</label>
                        <div class="col-sm-8">
                            {!! Form::text('first_name', null, ['class' => 'form-control input-sm', 'placeholder' => 'Nombre', 'required', 'id' => 'firstNameReg'  ]) !!}
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="inputLastName" class="col-sm-4 control-label">Apellidos</label>
                        <div class="col-sm-8">
                            {!! Form::text('last_name', null, ['class' => 'form-control input-sm', 'placeholder' => 'Apellidos', 'required', 'id' => 'lastNameReg' ]) !!}
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="inputLastName" class="col-sm-4 control-label">G&eacute;nero</label>
                        <div class="col-sm-8">
                            <select class="custom-select" id="gender" style="margin: 0">
                                <option value=""></option>
                                @foreach($genders as $gender)
                                    <option value="{{$gender['value']}}">{{ $gender['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-4" style="text-align: right">

                            <div class="btn custom-bottom btn-sm file-upload-custom-btn" style="margin: 0">
                                <input type="file" class="file-upload-custom" id="avatarUpload"  >
                                <sapn class="fa fa-camera"></sapn> Subir Foto
                            </div>

                        </div>
                        <div class="col-sm-8">
                            <div class="row photos-panel" id="avatarUploadPreview" style="margin-top: 2px">
                                <div class="col-sm-2 thumbnail previewImg hidden" >
                                    <img id="imgPreviewAvatar" class="img-responsive " src="" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="inputPassword" class="col-sm-4 control-label">Contraseña</label>
                        <div class="col-sm-8">
                            {!! Form::password('password', ['class' => 'form-control input-sm', 'placeholder' => 'Contraseña', 'required','pattern' => '.{5,10}' , 'id' => 'passwordReg' ]) !!}
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <label for="inputPasswordConfirm" class="col-sm-4  control-label">Confirme Contraseña</label>
                        <div class="col-sm-8">
                            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Password confirmation', 'required', 'confirmed',  'id' => 'passwordConfirmReg' ]) !!}
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="g-recaptcha col-lg-offset-4 col-sm-8" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
                    </div>
                    <div class="form-group">
                        <button id="btnRegister" class="btn custom-bottom btn-block" type="submit">Crear Cuenta</button>
                    </div>

                    <div class="form-group or-social">
                        <h>O utilice su cuenta de red social </h>
                    </div>

                    <a href="{{ route('social.redirect', ['provider' => 'facebook']) }}" class="btn btn-primary btn-sm btn-block facebook" type="submit">Facebook <span class="fa fa-facebook-official"></span> </a>
                    <a href="{{ route('social.redirect', ['provider' => 'twitter']) }}" class="btn btn-primary btn-sm btn-block twitter" type="submit">Twitter <span class="fa fa-twitter"></span></a>

                    {!! Form::close() !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>


@push('scripts')
<script type="text/javascript">

    var AVATAR_F = window.location.origin + "/{{ env('AVATAR_F')  }}";
    var AVATAR_M = window.location.origin + "/{{ env('AVATAR_M')  }}";


</script>
{!! Html::script('assets/js/Custom/auth/register-user.js') !!}

<script src="https://www.google.com/recaptcha/api.js"></script>
@endpush