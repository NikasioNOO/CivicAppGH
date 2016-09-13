<div class="modal fade custom-modal modal-obraDetail " data-backdrop="static" id="ObraDetail" tabindex="-1" role="dialog" aria-labelledby="ObraDetail">
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
                    <div id="ImgPanel" class="col-sm-4 gridthumbnail" style="overflow-y: scroll" >
                        <div class="col-sm-6" style="padding: 0;">
                            <div class="thumbnail">
                                <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                            </div>
                        </div>
                        <div class="col-sm-6" style="padding: 0;">
                            <div class="thumbnail">
                                <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                            </div>
                        </div>
                        <div class="col-sm-6" style="padding: 0;">
                            <div class="thumbnail">
                                <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                            </div>
                        </div>
                        <div class="col-sm-6" style="padding: 0;">
                            <div class="thumbnail">
                                <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                            </div>
                        </div>
                        <div class="col-sm-6" style="padding: 0;">
                            <div class="thumbnail">
                                <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                            </div>
                        </div>
                        <div class="col-sm-6" style="padding: 0;">
                            <div class="thumbnail">
                                <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                            </div>
                        </div>
                        <div class="col-sm-6" style="padding: 0;">
                            <div class="thumbnail">
                                <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                            </div>
                        </div>
                        <div class="col-sm-6" style="padding: 0;">
                            <div class="thumbnail">
                                <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                            </div>
                        </div>

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
                            <span class="fa fa-facebook-f iconSocialShare"></span>
                            <span class="fa fa-twitter iconSocialShare"></span>
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
                                <div class="col-sm-1 thumbnail previewImg" >
                                    <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    <a>Quitar</a>
                                </div>
                                <div class="col-sm-1 thumbnail" style="padding: 0; margin: 0">
                                    <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    <a>Quitar</a>
                                </div>
                                <div class="col-sm-1 thumbnail" style="padding: 0; margin: 0">
                                    <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    <a>Quitar</a>
                                </div>
                                <div class="col-sm-1 thumbnail" style="padding: 0; margin: 0">
                                    <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    <a>Quitar</a>
                                </div>
                                <div class="col-sm-1 thumbnail" style="padding: 0; margin: 0">
                                    <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    <a>Quitar</a>
                                </div>
                                <div class="col-sm-1 thumbnail" style="padding: 0; margin: 0">
                                    <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    <a>Quitar</a>
                                </div>
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
                    <p class="subtitle fancy"><label><span id="commentsCount">3</span> Comentarios </label></p>
                </div>
                <div id="allCommentsPanel">
                    <div class="panel panel-default panel-user-comment ">
                        <div class="panel-title  ">
                            <div class="avatar-wrapper img-circle ">
                                <img src="https://graph.facebook.com/v2.6/10206882125828581/picture?type=normal"  class="img-responsive avatar-width" alt="Avatar">
                            </div>
                            <label >Nicolás Daniel Ortiz Olmos</label>
                            <label >01/05/2016 12:34:21</label>
                            <div class="pull-right">
                                <span class="glyphicon glyphicon-thumbs-up"></span><span style="margin-left: 5px" class="badge">4</span>
                                <span class="glyphicon glyphicon-thumbs-down"></span><span style="margin-left: 5px" class="badge">2</span>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="container-fluid">
                                <div class="row comment">
                                    <div class="col-md-12 well">Se estan iniciando las instalaciones de bancos en las plazas </div>
                                </div>
                                <div class="row" >
                                    <div class="col-sm-6">
                                        <label class="control-label label-small ">Cambio de estado: <b> En Ejecucion </b></label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-inline pull-right vote-action">
                                            <a ><span class="glyphicon glyphicon-thumbs-up" ></span>Me gusta</a>
                                            <a ><span class="glyphicon glyphicon-thumbs-down" ></span>No me gusta</a>
                                            <a ><span class="fa fa-hand-stop-o" ></span>Denunciar comentario</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-user-comment ">
                        <div class="panel-title  ">
                            <div class="avatar-wrapper img-circle ">
                                <img src="https://graph.facebook.com/v2.6/10206882125828581/picture?type=normal"  class="img-responsive avatar-width" alt="Avatar">
                            </div>
                            <label >Nicolás Daniel Ortiz Olmos</label>
                            <label >01/05/2016 12:34:21</label>
                            <div class="pull-right">
                                <span class="glyphicon glyphicon-thumbs-up"></span><span style="margin-left: 5px" class="badge">4</span>
                                <span class="glyphicon glyphicon-thumbs-down"></span><span style="margin-left: 5px" class="badge">2</span>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="container-fluid">
                                <div class="row comment">
                                    <div class="col-md-12 well">Se estan iniciando las instalaciones de bancos en las plazas </div>
                                </div>
                                <div class="row photos-panel">
                                    <a href="{{ asset('assets/images/parque2.png') }}" data-toggle="lightbox"><div class="col-sm-1 thumbnail" >
                                            <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                        </div></a>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>
                                    <div class="col-sm-1 thumbnail" >
                                        <img class="img-responsive" src="{{ asset('assets/images/parque2.png') }}" alt="...">
                                    </div>

                                </div>
                                <div class="row" >
                                    <div class="col-sm-6">
                                        <label class="control-label label-small ">Estado de la Obra: <b> En Ejecucion </b></label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-inline pull-right vote-action">
                                            <a ><span class="glyphicon glyphicon-thumbs-up" ></span>Me gusta</a>
                                            <a ><span class="glyphicon glyphicon-thumbs-down" ></span>No me gusta</a>
                                            <a ><span class="fa fa-hand-stop-o" ></span>Denunciar comentario</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    {!! Html::script('assets/js/Custom/obra-detail.js') !!}
@endpush