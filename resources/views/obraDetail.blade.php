<div class="modal fade custom-modal modal-obraDetail "  id="ObraDetail" tabindex="-1" role="dialog" aria-labelledby="ObraDetail">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content cus-modal-images">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"  id="obraDetailTitle">Equipamiento de Bancos de H A y cestos papeloros para las plazas</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="obraDetailId">
                <div class="row obraPhotosPanel">
                    <div class="col-sm-8">
                        <div id="carouselPhotosObra" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <!--<ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>-->

                            <!-- Wrapper for slides -->
                            <div id="carouselItemsContent" class="carousel-inner " role="listbox" >
                               <div class="item active" id="imgWithoutPhoto">
                                    <img class="img-responsive img-rounded" src="{{ asset(env('WITHOUT_PHOTO_IMG')) }}" alt="...">
                                    <div class="carousel-caption">
                                        Subí una foto para reportar el estado.
                                    </div>
                                </div>
                                <!--<div class="item ">
                                    <img class="img-responsive img-rounded" src="{{ asset('assets/images/parque1.png') }}" alt="...">

                                </div>
                                <div class="item">
                                    <a href="#" data-toggle="modal" data-slide-to="1"><img class="img-responsive img-rounded" src="{{ asset('assets/images/parque2.png') }}" alt="..."></a>
                                    <div class="carousel-caption">

                                    </div>
                                </div>
                                <div class="item active">
                                    <a href="#" data-toggle="modal" data-slide-to="3"><img class="img-responsive img-rounded" src="{{ asset('assets/images/parque1.png') }}" alt="..."></a>
                                    <div class="carousel-caption">

                                    </div>
                                </div>-->

                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="#carouselPhotosObra" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carouselPhotosObra" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div id="imgThumbnailPanel" class="col-sm-4 gridthumbnail"  >


                    </div>
                </div>
                <div class="row obraInfoPanel">
                    <div class="">
                        <label class="labelTitle"  >AÑO:</label>
                        <label class="labelValue"  id="obraDetailYear"></label>
                    </div>
                    <div class="">
                        <label class="labelTitle">CPC:</label>
                        <label class="labelValue" id="obraDetailCPC"  ></label>
                    </div>
                    <div class="">
                        <label class="labelTitle">BARRIO:</label>
                        <label class="labelValue" id="obraDetailBarrio"></label>
                    </div>
                    <div class="">
                        <label class="labelTitle">CATEGORÍA:</label>
                        <label class="labelValue" id="obraDetailCategory"></label>
                    </div>
                    <div class="">
                        <label class="labelTitle">PRESUPUESTO:</label>
                        <label class="labelValue" id="obraDetailBudget"></label>
                    </div>
                    <div class="">
                        <label class="labelTitle">ESTADO:</label>
                        <label class="labelValue" id="obraDetailStatus"></label>
                    </div>
                    <div class="">
                        <label class="labelTitle">NRO EXPEDIENTE:</label>
                        <label class="labelValue" id="obraDetailNroExpediente"></label>
                    </div>
                </div>
                <div class="row sharePanel">
                    <span><label class="labelValue">COMENTAR</label></span>
                        <span class="socialSharePanel">
                            <label class="labelValue">Compartir:</label>

                                <span class="fa fa-facebook-f iconSocialShare fbk_share" data-href="" data-image="http://appcivica.dev:8000/assets/images/favicon.ico" data-title="Article Title" data-desc="Some description for this article" ></span>


                             <div class="fb-share-button" data-href="http://appcivica.dev:8000/obraId/37" data-size="samll"  data-layout="button" >

                             </div>
                            <!--<a href="https://twitter.com/share" class="twitter-share-button" data-text="HOla">Tweet</a>-->
                            <span class="fa fa-twitter iconSocialShare" id="twitterShareBtn" target="_blank"></span>
                        </span>
                </div>
                <div id="panelUserComment">
                    <div class="row comment">
                        <div class="col-md-12">
                                    <textarea id="commentTxt" class="form-control textComment" placeholder="Dejá tu comentario"></textarea>
                        </div>
                    </div>
                    <div class="row photos-panel">
                        <div class="col-sm-2">

                            <div class="btn custom-bottom btn-sm file-upload-custom-btn" >
                                <input type="file" class="file-upload-custom" id="photosUploadFile" multiple="true" >
                                <sapn class="fa fa-camera"></sapn> Subir Foto
                            </div>

                        </div>
                        <div class="col-sm-10">
                            <div class="row photos-panel" id="photosUploadPreview" style="margin-top: 2px">

                            </div>
                        </div>
                    </div>
                    <div class="row commentFotter" >
                        <div class="col-sm-9">
                            <label >ESTADO DE LA OBRA</label>

                            <select class="custom-select" id="statusComment">
                                <option value="-1"></option>
                                @foreach( $statuses as $status )
                                    <option value="{{$status->id}}">{{ $status->status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                                 <span>
                                    <button class="btn custom-bottom btn-sm" id="btnComment">
                                        COMENTAR
                                    </button>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <p class="subtitle fancy"><label><span id="commentsCount">0</span> Comentarios </label></p>
                </div>
                <div id="allCommentsPanel">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ComplaintModal" tabindex="-1" role="dialog" aria-labelledby="ComplaintModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Denuncia el comentario</h4>
            </div>
            <div class="modal-body">
                <textarea id="complaintComment" placeholder="Agrega un comentario a tu denuncia" class="form-control textComment" rows="4" ></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn custom-bottom btn-sm" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn custom-bottom btn-sm" id="SendComplaint">Denunciar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {!! Html::script('assets/js/Custom/obra-detail.js') !!}
@endpush