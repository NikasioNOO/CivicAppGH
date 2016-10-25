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
                <div class="row">
                    {!! Form::open(['url' => '#', 'class' => 'form-social-singin form-horizontal' ] ) !!}

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


@endpush