(function(){



    this.CivicApp = this.CivicApp || {};
    this.CivicApp.ObrasSocial = this.CivicApp.ObrasSocial || {};
    this.CivicApp.ObrasSocial.ObraDetail = this.CivicApp.ObrasSocial.ObraDetail ||  new function() {

        var allCommentsDiv = $('#allCommentsPanel');
        var photosUploadPreviewDiv = $('#photosUploadPreview');
        var carouselItemsContentDiv = $('#carouselItemsContent');
        var carouselPhotosObraDiv = $('#carouselPhotosObra');
        var imgthumbnailPanelDiv = $('#imgThumbnailPanel');
        var modalComplaint = $('#ComplaintModal');
        var complaintComment =  $('#complaintComment');
        var countPhotos = 0;
        var imgWhitoutPhoto = '<div id="imgWithoutPhoto" class="item active" > \
                                    <img class="img-responsive img-rounded" src="'+window.location.origin+'/'+ENV_WITHOUT_PHOTO_IMG +'" alt="..."> \
                                    <div class="carousel-caption"> \
                                    Subí tu foto para reportar el estado \
                                    </div> \
                                </div>';
        var fbShareBtn = $('.fbk_share');
        var twitterShareBtn =  $('#twitterShareBtn');

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
                        Utilities.ShowMessage('Debe elegir archivos de imagen de tipo jpeg, png, jpg , gracias');
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
                        if(jqXHR.status && jqXHR.status == 401 )
                            Utilities.ShowError('Es necesario haber iniciado sesión para realizar la acción');
                        else
                            Utilities.ShowError('Ocurrió un error al intentar guardar la Obra del presupuesto participativo'+errorThrown);
                    }
                });


            });

            $("#SendComplaint").on('click',function(){
                var comment = complaintComment.val();
                ComplaintPost( modalComplaint.data('post'),comment);
                modalComplaint.modal('hide');
            });

            modalComplaint.on( 'hidden.bs.modal' , function() {
                $( 'body' ).addClass( 'modal-open' );
            } );

            var fbShareBtnt = document.querySelector('.fbk_share');
            fbShareBtnt.addEventListener('click', function(e) {
                e.preventDefault();
                var title =  fbShareBtn.data('title'),
                    desc = fbShareBtn.data('desc'),
                    url = fbShareBtn.data('href'),
                    image = fbShareBtn.data('image');
                postToFeed(title, desc, url, image);

                return false;
            });

            twitterShareBtn.on('click',function(){

                ShareTwitter();
            })
        };

        var RemovePhotoUpload = function(photolink){
            var link = $(photolink);
            var filename = link.data('filename');
            comment.RemovePhoto(filename);
            link.parent().remove();
        };

        var ShareTwitter = function()
        {
            var href = twitterShareBtn.data('href');
            var text = twitterShareBtn.data('text');

            window.open('http://twitter.com/share?url=' + href + '&text=' + text + '&', 'twitterwindow', 'height=450, width=550, top='+($(window).height()/2 - 225) +', left='+$(window).width()/2 +', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
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

            $('meta[property="og:title"]').prop('content',obra.title);
            $('meta[property="og:description"]').prop('content','Obra de tipo '+ obra.category + ' en el barrio ' + obra.barrio);
            $('meta[property="og:url"]').prop('content',window.location.origin+'/ObraId/'+obra.id);

            var descObra = 'Obra de tipo '+ obra.category + ' en el barrio ' + obra.barrio +' se encuentra en estado '+ obra.status;
            fbShareBtn.data('href',window.location.origin+'/obraId/'+obra.id);
            fbShareBtn.data('title',obra.title);
            fbShareBtn.data('image','https://pbs.twimg.com/profile_images/2397832536/Logo_FB_400x400.jpg');
            fbShareBtn.data('desc',descObra);

           // $('#twitterShareBtn').prop('href','http://twitter.com/share?url='+window.location.origin+'/obraId/'+obra.id+'&text='+obra.title);

            twitterShareBtn.data('href',window.location.origin+'/obraId/'+obra.id+'&text='+obra.title + '.'+descObra);
            twitterShareBtn.data('text',obra.title);


            $.get('/ObraPP/Posts/'+obra.id,function(result){
                debugger;
                if(result.status=='OK')
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
                            $('meta[property="og:image"]').prop('content',carouselPhotosObraDiv.find('.item').first().find('a').prop('href'));
                        }

                    }
                    else if(flagImgRemoved) {
                        carouselItemsContentDiv.prepend(imgWhitoutPhoto);
                    }

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

        var postToFeed =function(title, desc, url, image) {
            var obj = {method: 'feed',link: url, picture: image,name: title,description: desc ,caption:'Obra del presupuesto participativo'};
            function callback(response) {}
            FB.ui(obj, callback);
        };


        var ResizeImg = function()
        {
            var winHeight = $( window ).height();
            var height = winHeight*0.4;
            $('#ObraDetail .modal-dialog').height(winHeight*0.8);
            $('#ObraDetail .carousel-inner img').height(height);
            $('.gridthumbnail').height(height);
        };

        var BindCloseImageBttn = function()
        {
            setTimeout(function(){$('div[id^=ekkoLightbox-]').on( 'hidden.bs.modal' , function() {
                $( 'body' ).addClass( 'modal-open' );
                } );
            },300);
        };

        var BuildComment = function(post)
        {
            var photos='';


            if(post.photos && post.photos.length>0)
                for(var i=0; i< post.photos.length;i++) {
                    photos = photos + ' \
                            <div class="col-sm-1 thumbnail" > \
                                <img class="img-responsive" src="' + window.location.origin+'/'+  post.photos[i].path + '" alt="..."> \
                            </div> ';

                    carouselItemsContentDiv.append(
                    '<div class="item " > \
                        <a href="'+  window.location.origin+'/'+  post.photos[i].path +'" data-toggle="lightbox" data-gallery="multiimages" onclick="CivicApp.ObrasSocial.ObraDetail.BindCloseImageBttn()">        \
                            <img class="img-responsive img-rounded" src="'+  window.location.origin+'/'+ post.photos[i].path +'" alt="..."> \
                        </a>    \
                     </div> ');

                    imgthumbnailPanelDiv.append(' \
                    <div class="col-sm-6" >  \
                        <div class="thumbnail" data-target="#carouselPhotosObra" data-slide-to="'+ countPhotos +'">  \
                            <a href="'+  window.location.origin+'/'+ post.photos[i].path +'" data-toggle="lightbox" data-gallery="multiimages" onclick="CivicApp.ObrasSocial.ObraDetail.BindCloseImageBttn()">        \
                                <img class="img-responsive" src="'+ window.location.origin+'/'+ post.photos[i].path +'" alt="...">  \
                            </a> \
                        </div> \
                    </div> ');
                    countPhotos++;
                }

            var htmlStatus = '';
            if(post && post.status && post.status.status)
                htmlStatus = '<label class="control-label label-small ">Cambio de estado: <b> '+post.status.status+' </b></label>';

            var htmlComment =
                '<div id="commentPosted_'+post.id+'" class="panel panel-default panel-user-comment "> \
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
                                        <a id="markPositive_'+post.id+'" onclick="CivicApp.ObrasSocial.ObraDetail.MarkPost(this,true)"><span class="glyphicon glyphicon-thumbs-up" ></span>Me gusta</a> \
                                        <a id="markNegative_'+post.id+'" onclick="CivicApp.ObrasSocial.ObraDetail.MarkPost(this,false)"><span class="glyphicon glyphicon-thumbs-down" ></span>No me gusta</a> \
                                        <a id="complaint_'+post.id+'" onclick="CivicApp.ObrasSocial.ObraDetail.OpenComplaintDialog(this)"><span class="fa fa-hand-stop-o" ></span>Denunciar comentario</a> \
                                    </div> \
                                </div> \
                            </div> \
                        </div> \
                    </div> \
                </div>';

            return htmlComment;
        };


        var MarkPost = function(markLink,marker)  {

            var postId = markLink.id.split('_')[1];

            $.post('/social/MarkPost', {"postId":postId,"marker":marker ? 1 :0 },
            function(data)
            {
                if(data.status=="Ok")
                {
                    var markerCount = marker == true ? $('#positiveCountMarkers_'+postId) : $('#negativeCountMarkers_'+postId) ;
                    markerCount.text(parseInt(markerCount.text())+1)
                }
                else
                {
                    if(data.message)
                    {
                        Utilities.ShowMessage(data.message);
                    }
                    else
                        Utilities.ShowError('Ocurrió un error al intentar markar positivamente el comentario');
                }

            }).fail(function(err)
            {
                if(err && err.status && err.status == 401)
                    Utilities.ShowError('Es necesario haber iniciado sesión para realizar la acción');
                else
                    Utilities.ShowError('Ocurrió un error al intentar markar positivamente el comentario');
            })

        };


        var OpenComplaintDialog = function(link)
        {
            var postId = link.id.split('_')[1];
            complaintComment.val('');
            modalComplaint.modal('show');

            modalComplaint.data('post',postId);


        };

        var ComplaintPost = function(postId,comment)  {


            $.post('/social/SendPostComplaint', {"postId":postId,"comment":comment  },
                function(data)
                {
                    if(data.status!="Ok")
                    {
                        if(data.message)
                        {
                            Utilities.ShowMessage(data.message);
                        }
                        else
                            Utilities.ShowError('Ocurrió un error al intentar denunciar el comentario');
                    }

                }).fail(function(err)
                {
                    if(err && err.status && err.status == 401)
                        Utilities.ShowError('Es necesario haber iniciado sesión para realizar la acción');
                    else
                        Utilities.ShowError('Ocurrió un error al intentar denunciar el comentario');
                })

        };



        return {
            SetObra : SetObra,
            InitEvents: InitEvents,
            RemovePhotoUpload: RemovePhotoUpload,
            BindCloseImageBttn: BindCloseImageBttn,
            MarkPost: MarkPost,
            OpenComplaintDialog: OpenComplaintDialog
        }


    };
})();

$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});

$(document).ready(function(){

    CivicApp.ObrasSocial.ObraDetail.InitEvents();

});
