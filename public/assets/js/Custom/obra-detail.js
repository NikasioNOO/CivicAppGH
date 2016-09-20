(function(){



    this.CivicApp = this.CivicApp || {};
    this.CivicApp.ObrasSocial = this.CivicApp.ObrasSocial || {};
    this.CivicApp.ObrasSocial.ObraDetail = this.CivicApp.ObrasSocial.ObraDetail ||  new function() {

        var allCommentsDiv = $('#allCommentsPanel');
        var photosUploadPreviewDiv = $('#photosUploadPreview');
        var carouselItemsContentDiv = $('#carouselItemsContent');
        var carouselPhotosObraDiv = $('#carouselPhotosObra');
        var imgthumbnailPanelDiv = $('#imgThumbnailPanel');
        var countPhotos = 0;
        var imgWhitoutPhoto = '<div id="imgWithoutPhoto" class="item active" > \
                                    <img class="img-responsive img-rounded" src="'+ENV_WITHOUT_PHOTO_IMG +'" alt="..."> \
                                    <div class="carousel-caption"> \
                                    Subí tu foto para reportar el estado \
                                    </div> \
                                </div>';

      //  var photosUploadFiles = []
        var flagImgRemoved = false;
        function ObraDetail() {
            var obraId =0;
            var idHdn = $('#obraDetailId');
            var titleLbl = $('#obraDetailTitle');
            var yearLbl = $('#obraDetailYear');
            var CPCLbl = $('#obraDetailCPC');
            var barrioLbl = $('#obraDetailBarrio');

            var statusLbl = $('#obraDetailCategory');
            var nroExpedienteLbl = $('#obraDetailNroExpediente');
            var categoryLbl = $('#obraDetailStatus');
            var budgetLbl = $('#obraDetailBudget');
            var commentsCountSpan = $('#commentsCount');




            Object.defineProperty(this, 'id', {
                get: function() {
                    return obraId;
                },
                set: function(value) {

                    obraId = value;
                },
                enumerable:true
            });

            Object.defineProperty(this, 'title', {
                get: function() {
                    return titleLbl.text();
                },
                set: function(value) {

                    titleLbl.text(value)
                },
                enumerable:true
            });

            Object.defineProperty(this, 'year', {
                get: function() {
                    return yearLbl.text();
                },
                set: function(value) {

                    yearLbl.text(value)
                },
                enumerable:true
            });

            Object.defineProperty(this, 'CPC', {
                get: function() {
                    return CPCLbl.text();
                },
                set: function(value) {

                    CPCLbl.text(value)
                },
                enumerable:true
            });

            Object.defineProperty(this, 'barrio', {
                get: function() {
                    return barrioLbl.text();
                },
                set: function(value) {

                    barrioLbl.text(value)
                },
                enumerable:true
            });

            Object.defineProperty(this, 'category', {
                get: function() {
                    return categoryLbl.text();
                },
                set: function(value) {

                    categoryLbl.text(value)
                },
                enumerable:true
            });

            Object.defineProperty(this, 'budget', {
                get: function() {
                    return budgetLbl.text();
                },
                set: function(value) {

                    budgetLbl.text(value)
                },
                enumerable:true
            });

            Object.defineProperty(this, 'status', {
                get: function() {
                    return statusLbl.text();
                },
                set: function(value) {

                    statusLbl.text(value)
                },
                enumerable:true
            });

            Object.defineProperty(this, 'nroExpediente', {
                get: function() {
                    return nroExpedienteLbl.text();
                },
                set: function(value) {

                    nroExpedienteLbl.text(value)
                },
                enumerable:true
            });

            Object.defineProperty(this, 'commentsCount', {
                get: function() {
                    return commentsCountSpan.text();
                },
                set: function(value) {

                    commentsCountSpan.text(value)
                },
                enumerable:true
            });

            /*this.SetObra = function(id, title, year, cpc, barrio, category, budget, status, nroExpediente )
            {
                this.id = id;
                this.title = title;
                this.year = year;
                this.CPC = cpc;
                this.barrio = barrio;
                this.category = category;
                this.budget = budget;
                this.status = status;
                this.nroExpediente = nroExpediente;

            }*/

        }

        function Comment()
        {
            var commentTxt = $('#commentTxt');
            var statusSelect = $('#statusComment');
            var photosUploadFiles = [];

            Object.defineProperty(this, 'comment', {
                get: function() {
                    return commentTxt.val();
                },
                set: function(value) {

                    commentTxt.val(value);
                },
                enumerable:true
            });


            Object.defineProperty(this, 'status', {
                get: function() {

                    var id= statusSelect.val();
                    var text=statusSelect.find('option:selected').text();
                    return id ? { id:id,status:text }: {id:0} ;
                },
                set: function(value) {
                    statusSelect.val(value.id);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'photos', {
                get: function() {
                    return photosUploadFiles;
                },

                enumerable:false
            });

            this.AddPhoto = function(file)
            {
                photosUploadFiles.push(file);
            };

            this.RemovePhoto = function (filename)
            {
                Utilities.findAndRemoveList(photosUploadFiles,'name',filename  );
            };

            this.CleanComment = function()
            {
                this.comment = '';
                this.status = '';
                photosUploadFiles = [];
            }

        }

        var obra = new ObraDetail();
        var comment = new Comment();
        var fileNameUploading = '';
        var InitEvents = function()
        {
            $('#photosUploadFile').on('change',function(){
                //var file = this.files[0];
                var filesUpload = this.files;
                for(var i=0; i <filesUpload.length; i++) {
                    var imageFile = filesUpload[i].type;
                    var match = ["image/jpeg", "image/png", "image/jpg"];

                    if (!((imageFile == match[0]) || (imageFile == match[1]) || (imageFile == match[2]))) {
                        Utilities.ShowMessage('Debe elegir archivos de imagen , gracias');
                        return false;
                    }
                    else {
                        comment.AddPhoto(filesUpload[i]);
                        fileNameUploading = filesUpload[i].name;
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            var previewDiv =
                                '<div class="col-sm-1 thumbnail previewImg" > \
                                    <img class="img-responsive" src="'+e.target.result+'" alt="..."> \
                                    <a data-filename="'+fileNameUploading+'" onclick="CivicApp.ObrasSocial.ObraDetail.RemovePhotoUpload(this);" >Quitar</a> \
                                 </div>';

                            photosUploadPreviewDiv.append(previewDiv);

                        };

                        reader.readAsDataURL(this.files[i]);
                    }
                }
            });

            $('#btnComment').on('click',function(){

                var formData = new FormData();

                formData.append('comment',JSON.stringify(comment));
                formData.append('obraId',obra.id);
                for(var i=0; i< comment.photos.length;i++)
                {
                    formData.append('photos[]',comment.photos[i]);
                }


                $.ajax({
                    url: "/social/SendPost", // Url to which the request is send
                    type: "POST",             // Type of request to be send, called as method
                    data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,             // To unable request pages to be cached
                    processData:false,        // To send DOMDocument or non processed data file it is set to false
                    success: function(data)   // A function to be called if request succeeds
                    {
                        if(data.status == 'Ok')
                        {
                            var newPost = JSON.parse(data.post);
                            if(data.statusChange) {
                                $('#searchObrasBtn').trigger('click');
                                obra.status = newPost.status.status;
                            }

                            obra.commentsCount = parseInt(obra.commentsCount) + 1;

                            if(data.post)
                                allCommentsDiv.prepend(BuildComment(newPost));
                            photosUploadPreviewDiv.html('');

                            if(countPhotos != 0 && !flagImgRemoved ) {
                                carouselPhotosObraDiv.find('#imgWithoutPhoto').remove();
                                flagImgRemoved = true;
                                carouselPhotosObraDiv.find('.item').first().addClass('active');
                            }

                            ResizeImg();


                            comment.CleanComment();
                        }
                        else
                        {
                                Utilities.ShowError(data.message);
                        }

                    },
                    error:function( jqXHR, textStatus,  errorThrown )
                    {
                        Utilities.ShowError('Ocurrió un error al intentar guardar la Obra del presupuesto participativo'+errorThrown);
                    }
                });


            });
        };

        var RemovePhotoUpload = function(photolink){
            var link = $(photolink);
            var filename = link.data('filename');
            comment.RemovePhoto(filename);
            link.parent().remove();
        };

        var SetObra = function(id, title, year, cpc, barrio, category, budget, status, nroExpediente )
        {
            debugger;
            obra.id = id;
            obra.title = title;
            obra.year = year;
            obra.CPC = cpc;
            obra.barrio = barrio;
            obra.category = category;
            obra.budget = budget;
            obra.status = status;
            obra.nroExpediente = nroExpediente;

            allCommentsDiv.html('');
            photosUploadPreviewDiv.html('');
            imgthumbnailPanelDiv.html('');
            if(flagImgRemoved)
            {
                carouselItemsContentDiv.prepend(imgWhitoutPhoto);
                flagImgRemoved = false;
            }
            carouselItemsContentDiv.find('.item').not('#imgWithoutPhoto').remove();
            countPhotos = 0;


            $.get('/ObraPP/Posts/'+obra.id,function(result){
                debugger;
                if(result.status='OK')
                {
                    obra.commentsCount= result.data ? result.data.length : 0;
                    if(result.data && result.data.length > 0)
                    {
                        for(var i =0 ; i < result.data.length; i++)
                        {
                            allCommentsDiv.append(BuildComment(result.data[i]))

                        }

                        if(countPhotos != 0 ) {
                            carouselPhotosObraDiv.find('#imgWithoutPhoto').remove();
                            flagImgRemoved = true;
                          //  carouselItemsContentDiv.append(imgWhitoutPhoto.html());
                        }

                    }
                    else if(flagImgRemoved)
                        carouselItemsContentDiv.prepend(imgWhitoutPhoto);

                    carouselPhotosObraDiv.find('.item').first().addClass('active');

                    ResizeImg();
                    //carouselPhotosObraDiv.carousel();
                }
                else
                {
                    Utilities.ShowError('Se ha producido un error al obtener los comentarios');
                }
            }).fail(function(err){
                Utilities.ShowError('Se ha producido un error al obtener los comentarios');
            });

        };

        var ResizeImg = function()
        {
            var winHeight = $( window ).height();
            var height = winHeight*0.4;
            $('#ObraDetail .modal-dialog').height(winHeight*0.8);
            $('#ObraDetail .carousel-inner img').height(height);
            $('.gridthumbnail').height(height);
        };

        var BuildComment = function(post)
        {
            var photos='';


            if(post.photos && post.photos.length>0)
                for(var i=0; i< post.photos.length;i++) {
                    photos = photos + ' \
                            <div class="col-sm-1 thumbnail" > \
                                <img class="img-responsive" src="' + post.photos[i].path + '" alt="..."> \
                            </div> ';

                    carouselItemsContentDiv.append(
                    '<div class="item " > \
                            <img class="img-responsive img-rounded" src="'+ post.photos[i].path +'" alt="..."> \
                     </div> ');

                    imgthumbnailPanelDiv.append(' \
                    <div class="col-sm-6" >  \
                        <div class="thumbnail" data-target="#carouselPhotosObra" data-slide-to="'+ countPhotos +'">  \
                            <img class="img-responsive" src="'+post.photos[i].path +'" alt="...">  \
                        </div> \
                    </div> ');
                    countPhotos++;
                }

            var htmlStatus = '';
            if(post && post.status && post.status.status)
                htmlStatus = '<label class="control-label label-small ">Cambio de estado: <b> '+post.status.status+' </b></label>';

            var htmlComment =
                '<div id="commentPosted_"'+post.id+' class="panel panel-default panel-user-comment "> \
                    <div class="panel-title  ">  \
                        <div class="avatar-wrapper img-circle "> \
                            <img src="'+  post.user.avatar + '"  class="img-responsive avatar-width" alt="Avatar"> \
                        </div> \
                        <label >'+ post.user.username+'</label> \
                        <label >'+ post.created_at+'</label> \
                        <div class="pull-right"> \
                            <span class="glyphicon glyphicon-thumbs-up"></span><span style="margin-left: 5px" class="badge" id="positiveCountMarkers_'+post.id+'" >'+post.positiveCount+'</span> \
                            <span class="glyphicon glyphicon-thumbs-down"></span><span style="margin-left: 5px" class="badge" id="negativeCountMarkers_'+post.id+'">'+post.negativeCount+'</span> \
                        </div> \
                    </div> \
                    <div class="panel-body"> \
                        <div class="container-fluid"> \
                            <div class="row comment"> \
                                <div class="col-md-12 well">'+ post.comment+' </div> \
                            </div> \
                            <div class="row photos-panel"> \
                               '+ photos +' \
                            </div>\
                            <div class="row" > \
                                <div class="col-sm-6"> \
                                    '+htmlStatus+' \
                                </div> \
                                <div class="col-sm-6"> \
                                    <div class="form-inline pull-right vote-action"> \
                                        <a id="markPositive_'+post.id+'"><span class="glyphicon glyphicon-thumbs-up" ></span>Me gusta</a> \
                                        <a id="markNegative_'+post.id+'"><span class="glyphicon glyphicon-thumbs-down" ></span>No me gusta</a> \
                                        <a id="complaint_'+post.id+'"><span class="fa fa-hand-stop-o" ></span>Denunciar comentario</a> \
                                    </div> \
                                </div> \
                            </div> \
                        </div> \
                    </div> \
                </div>';

            return htmlComment;
        };



        return {
            SetObra : SetObra,
            InitEvents: InitEvents,
            RemovePhotoUpload: RemovePhotoUpload
        }


    };
})();

$(document).ready(function(){

    CivicApp.ObrasSocial.ObraDetail.InitEvents();

});
