@push('cssCustom')





@endpush
<div class="modal fade custom-modal modal-login "  id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLogin">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content cus-modal-images">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"  >Iniciar Session</h4>
            </div>
            <div class="modal-body">

                <div id="divMessageLogin"></div>
                <div class="row">
                    {!! Form::open(['url' => '#', 'class' => 'form-social-singin form-horizontal' ] ) !!}

                    <div class="form-group">
                        <h class="form-signin-heading">Por favor inicie sesi&oacute;n</h>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="email" class="col-sm-4 control-label ">Direcci&oacute;n de email</label>
                        <div class="col-sm-8">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required autofocus>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="inputPassword" class="col-sm-4 control-label ">Contraseña</label>
                        <div class="col-sm-8">
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña', 'required',  'id' => 'password' ]) !!}
                        </div>
                    </div>
                    <div class="">
                        <label class="">
                            <input class="checkboxRemember" type="checkbox" id="rememberCheck" name="remember" value="1"> Recordarme
                        </label>
                    </div>
                    <div class="form-group">
                        <button class="btn custom-bottom btn-block" id="loginBtn">Iniciar Sesi&oacute;n</button>
                        <a href="#">¿Olvid&oacute; su contraseña?</a>
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
{!! Html::script('assets/js/Custom/auth/login.js') !!}

@endpush