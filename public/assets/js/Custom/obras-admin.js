(function(){



    this.CivicApp = this.CivicApp || {};
    this.CivicApp.Obra = this.CivicApp.Obra || new function(){

        var map = null;



        var yearSelect = $('#year');
        var locationInput = $('#autocompleteMap');
        var cpcInput = $('#CPC');
        var barrioInput = $('#barrio');
        var categoryInput = $('#category');
        var titleInput = $('#title');
        var badgetInput = $('#badget');
        var statusSelect = $('#status');
        var idObra = $('#idObra');
        var nroExpedienteInput = $('#nro_expediente');
        var commentsCount = $('#commentsCount');
        var complaintsModal = $('#ComplaintsModal');
        var complaintsListDiv = $('#complaintsList');

        var obraCommentsDiv = $('#obraComments');
        var noCommentsMsgDiv = $('#noCommentsMsg');
        var obraCommentPanelDiv = $('#obraCommentsPanel');



        function Obra()
        {
            /*this.Clean = function()
            {
                this.id = 0;
                this.budget = '';
                this.barrio = '';
                this.category = '';
                this.cpc = '';
                this.address='';
                this.location = {id:0,location:''};
                this.status = '';
                this.description = '';
                this.year = '';
                this.nro_expediente ='';

            };*/
            Object.defineProperty(this, 'id', {
                get: function() {
                    var id = idObra.val();
                    return id ? id : 0;
                },
                set: function(value) {

                    idObra.val(value ? value : 0);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'year', {
                get: function() {

                    return yearSelect.val();
                },
                set: function(value) {
                    yearSelect.val(value);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'address', {
                get: function() {

                    return  locationInput.val();
                },
                set: function(value) {
                    locationInput.val(value);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'location', {
                get: function() {

                    return {
                            id: locationInput.data('idgeopoint'),
                            location: locationInput.data('latLng')};
                },
                set: function(value) {
                    if(value) {
                        locationInput.data('idgeopoint', value.id);
                        locationInput.data('latLng', value.location);
                        map.SetIndividualMarker(value.location, this.address);
                        //CivicApp.GmapHelper.SetIndividualMarker(value.location, this.address);
                    }
                    else
                    {
                        locationInput.data('idgeopoint', 0);
                        locationInput.data('latLng', '');
                        map.HideIndividualMarker();
                    }
                },
                enumerable:true
            });

            Object.defineProperty(this, 'cpc', {
                get: function() {
                    var id = cpcInput.data('idSelected');
                    return id ? { id:id }: {id:0} ;
                },
                set: function(value) {
                    var listvalues = cpcInput.data('listvalues');
                    var newValue = Utilities.findandGetInList(listvalues,'id',value.id);
                    if(newValue) {
                        cpcInput.data('idSelected',newValue.id);
                        cpcInput.val(newValue.value);
                    }
                    else
                    {
                        cpcInput.data('idSelected',0);
                        cpcInput.val('');
                    }
                },
                enumerable:true
            });

            Object.defineProperty(this, 'barrio', {
                get: function() {
                    var id = barrioInput.data('idSelected');
                    return id ? { id:id }: {id:0} ;
                },
                set: function(value) {
                    var listvalues = barrioInput.data('listvalues');
                    var newValue = Utilities.findandGetInList(listvalues,'id',value.id);
                    if(newValue) {
                        barrioInput.data('idSelected',newValue.id);
                        barrioInput.data('location', newValue.location);
                        barrioInput.val(newValue.value);
                        $('#editBarrio').toggle(true);
                    }
                    else
                    {
                        barrioInput.data('idSelected',0);
                        barrioInput.data('location', '');
                        barrioInput.val('');
                        $('#editBarrio').toggle(false);
                    }




                },
                enumerable:true
            });

            Object.defineProperty(this, 'category', {
                get: function() {
                    var id = categoryInput.data('idSelected');
                    return id ? { id:id , category:categoryInput.val()}: {id:0, category:''} ;
                },
                set: function(value) {
                    var listvalues = categoryInput.data('listvalues');
                    var newValue = Utilities.findandGetInList(listvalues,'id',value.id);
                    if(newValue) {
                        categoryInput.data('idSelected',newValue.id);
                        categoryInput.val(newValue.value);
                        $('#editIcons').toggle(true);
                    }
                    else
                    {
                        categoryInput.data('idSelected',0);
                        categoryInput.val('');
                        $('#editIcons').toggle(false);
                    }

                },
                enumerable:true
            });

            Object.defineProperty(this, 'description', {
                get: function() {

                    return titleInput.val();
                },
                set: function(value) {
                    titleInput.val(value);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'nro_expediente', {
                get: function() {

                    return nroExpedienteInput.val();
                },
                set: function(value) {
                    nroExpedienteInput.val(value);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'budget', {
                get: function() {

                    return badgetInput.val();
                },
                set: function(value) {
                    badgetInput.val(value);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'status', {
                get: function() {

                    var id= statusSelect.val();
                    return id ? { id:id }: {id:0} ;
                },
                set: function(value) {
                    statusSelect.val(value.id);
                },
                enumerable:true
            });

            Object.defineProperty(this, 'commentsCount', {
                get: function() {

                    var count= commentsCount.text();
                    return parseInt(count);
                },
                set: function(value) {
                    commentsCount.text(value);
                },
                enumerable:false
            });

        }


        var obra = new Obra();

        var CleanObra = function()
        {
            //obra.Clean();
            obra.id = 0;
            obra.budget = '';
            obra.barrio = '';
            obra.category = '';
            obra.cpc = '';
            obra.address='';
            obra.location = {id:0,location:''};
            obra.status = '';
            obra.description = '';
            obra.year = '';
            obra.nro_expediente='';
            obra.commentsCount = 0;
            map.HideIndividualMarker();

            obraCommentsDiv.html('');
            obraCommentPanelDiv.hide();
            //noCommentsMsgDiv.show();

            CivicApp.ObrasGrid.CleanRowEdited();

        };

        var InitEvents = function()
        {
            $('#autocompleteMap').on('change',function()
            {
         //       alert( obra.Location.address +','+ obra.Location.geoPoint);
            });

            $('#save').on('click',function()
            {
                SaveObra();
            });

            $('#cancel').on('click',function()
            {
              CleanObra();
            });

            $('.imageUploader').on('change',function(){
                var file = this.files[0];
                var id = this.id ;
                var imageFile = file.type;
               // var match= ["image/jpeg","image/png","image/jpg"];
                var match= "image/png";
                var img = $('#img'+id);
                if(!(imageFile==match))
                {
                    //$('#previewing').attr('src','noimage.png');
                    Utilities.ShowMessage('Debe elegir archivos de imagen png, gracias');
                    if(!img.hasClass('hidden'))
                        img.addClass('hidden');
                    return false;
                }
                else
                {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        img.attr('src', e.target.result).removeClass('hidden');
                    };

                    reader.readAsDataURL(this.files[0]);
                }
            });

            $('#saveIcons').on('click',function()
            {
                var inputFiles = $('.imageUploader');
                var inputFileNames = [];
                for(var i=0; i< inputFiles.length ; i++)
                {
                    inputFileNames.push(inputFiles[i].name);
                }

                var formData = new FormData($('#imgUploadForm')[0]);
                formData.append('filesNames',inputFileNames);
                formData.append('categoryId', obra.category.id);
                formData.append('category',obra.category.category);

                $.ajax({
                    url: "/admin/UploadIcons", // Url to which the request is send
                    type: "POST",             // Type of request to be send, called as method
                    data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,             // To unable request pages to be cached
                    processData:false,        // To send DOMDocument or non processed data file it is set to false
                    success: function(data)   // A function to be called if request succeeds
                    {
                        $('#imagesUpload').modal('hide');
                        if(data.status == 'Ok' ) {
                            Utilities.ShowSuccesMessage('Se ha subido correctamente los iconos');

                        }
                        else
                        {
                            Utilities.ShowError(data.message);
                        }



                    },
                    error:function( jqXHR, textStatus,  errorThrown )
                    {
                        Utilities.ShowError('Se ha producido un error al subir los iconos.'+errorThrown);
                    }
                });

            });

            $('#imagesUpload').on('show.bs.modal',function(e)
            {
                LoadCategoryIcons();
            });

            CivicApp.PopUpLocation.AddCallBackShownModal(function(e)
            {


                if(e.relatedTarget.id=='editBarrio') {
                    CivicApp.PopUpLocation.isLocationBarrio= true;
                    var location = barrioInput.data('location');
                    if (location) {
                        var latlng = location.split(',');
                        CivicApp.PopUpLocation.mapPopUp().SetAutocompleteAddressAndMarker(latlng[0], latlng[1]);

                    }
                    else {
                        CivicApp.PopUpLocation.mapPopUp().MapCenter();
                        CivicApp.PopUpLocation.mapPopUp().CleanAutocomplete();

                    }
                    google.maps.event.trigger(CivicApp.PopUpLocation.mapPopUp().map, 'resize');
                }




            });



            CivicApp.PopUpLocation.AddCallBackSave(function(){
                if(CivicApp.PopUpLocation.isLocationBarrio)
                {
                    SaveBarrioLocation();
                    CivicApp.PopUpLocation.HidePopUpLocation();
                }

            });

            CivicApp.PopUpLocation.AddCallBackHideModal(function(){
               if(CivicApp.PopUpLocation.isLocationBarrio)
               {
                    delete  CivicApp.PopUpLocation.isLocationBarrio;
                   CivicApp.PopUpLocation.mapPopUp().CleanAutocomplete();
               }
            });




        };




        var LoadCategoryIcons =  function()
        {
            $("#status option").each(function(status)
            {
                // Add $(this).val() to your list
                if(this.value) {
                    var id = this.value;
                    var name = this.text.replace(' ', '');

                    var inputName = 'imgico_' + id + '_' + name;
                    var img = 'ico_' + id + '_' + name+'.png';
                    var host = window.location.protocol+'//'+window.location.host+'//';
                    var src = host+ ENV_MAPICONS_PATH + 'cat' + obra.category.id + '_' + img +"?ver="+  Date.now().toString();

                    if (Utilities.ImageExists(src))
                        $('#' + inputName).attr('src', src);
                    else {
                        src = host + ENV_MAPICONS_PATH + '_' + img;
                        if (Utilities.ImageExists(src))
                            $('#' + inputName).attr('src', src);
                        else
                            $('#' + inputName).attr('src', host + ENV_MAPICONS_PATH + ENV_DEFAULT_ICON);
                    }
                }

            });

        };

        var FocusForm= function()
        {
            $(window).scrollTop($('#FormObra').position().top);
        };

        var SaveObra = function()
        {
            Utilities.block();


            $.post('/admin/SaveObra',{"obra":obra},
                function(data)
                {
                    if(data.status == 'Ok')
                    {
                       // Utilities.ShowSuccesMessage('Se ha guardado correctamente la Obra del Presupuesto Participativo');
                        CleanObra();
                        CivicApp.ObrasGrid.ReloadGrid();
                        $('#divMessages').html(data.htmlMessage);
                    }
                    else
                    {
                        if(data.htmlMessage)
                        {
                            $('#divMessages').html(data.htmlMessage);
                        }
                        else
                            Utilities.ShowError(data.message);
                    }
                    $.unblockUI();

                }).fail(function()
                {
                    $.unblockUI();
                    Utilities.ShowError('Ocurrió un error al intentar guardar la Obra del presupuesto participativo');
                })

        };

        var DeleteObra = function(id)
        {
            Utilities.block();
            $.post('/admin/DeleteObra',{"obraId":id},
                function(data)
                {
                    if(data.status == 'Ok')
                    {
                        Utilities.ShowSuccesMessage('Se ha eliminado correctamente la Obra del Presupuesto Participativo');
                        CivicApp.ObrasGrid.ReloadGrid();
                    }
                    else
                    {
                        Utilities.ShowError(data.message);
                    }
                    $.unblockUI();

                }).fail(function()
                {
                    $.unblockUI();
                    Utilities.ShowError('Ocurrió un error al intentar eliminar la Obra del presupuesto participativo');
                })

        };

        var LoadObra = function(editObra)
        {
            obra.id = editObra.id;
            obra.budget = editObra.budget;
            obra.barrio = editObra.barrio;
            obra.category = editObra.category;
            obra.cpc = editObra.cpc;
            obra.address=editObra.address;
            obra.location = editObra.location;
            obra.status = editObra.status;
            obra.description = editObra.description;
            obra.year = editObra.year;
            obra.nro_expediente = editObra.nro_expediente;

            obraCommentsDiv.html('');
            noCommentsMsgDiv.hide();

            obraCommentPanelDiv.show();

            $.post('/admin/GetPosts/',{"obraId":obra.id},function(result){

                debugger;
                if(result.status=='OK')
                {
                    obra.commentsCount =result.data ? result.data.length : 0;
                    if(result.data && result.data.length > 0)
                    {
                        for(var i =0 ; i < result.data.length; i++)
                        {
                            obraCommentsDiv.append(BuildComment(result.data[i]))

                        }

                    }
                    else
                        noCommentsMsgDiv.show();


                }
                else
                {
                    Utilities.ShowError('Se ha producido un error al obtener los comentarios');
                }
            }).fail(function(err){
                Utilities.ShowError('Se ha producido un error al obtener los comentarios');
            });

        };

        var BuildComment = function(post)
        {
            var photos='';


            if(post.photos && post.photos.length>0)
                for(var i=0; i< post.photos.length;i++) {
                    photos = photos + ' \
                            <div class="col-sm-1 thumbnail" > \
                                <a  href="'+ window.location.origin+'/'+ post.photos[i].path +'" data-toggle="lightbox" data-gallery="multiimages" >\
                                    <img class="img-responsive" src="' +window.location.origin+'/'+ post.photos[i].path + '" alt="..."> \
                                    <a data-filename="'+ window.location.origin+'/'+ post.photos[i].path+'" data-photoid="'+post.photos[i].id+'" onclick="CivicApp.Obra.RemovePhoto(this);" >Eliminar</a> \
                                </a>\
                            </div> ';

                   // countPhotos++;
                }

            var htmlStatus = '';
            if(post && post.status && post.status.status)
                htmlStatus = '<label class="control-label label-small ">Cambio de estado: <b> '+post.status.status+' </b></label>';

            var htmlComment =
                "<div id='commentPosted_"+post.id+"' class='panel panel-default panel-user-comment ' data-postcomplaintscount='"+post.post_complaints_count+"'> \
                    <div class='panel-title  '>  \
                        <div class='avatar-wrapper img-circle '> \
                            <img src='"+  post.user.avatar + "'  class='img-responsive avatar-width' alt='Avatar'> \
                        </div> \
                        <label class='user-"+post.user.id+" "+ (post.user.is_spamer == 1 ? "user-spamer" : "")+" ' >"+ post.user.username+"</label> \
                        <label >"+ post.created_at+"</label> \
                        <div class='pull-right'> \
                            <span class='glyphicon glyphicon-thumbs-up'></span><span style='margin-left: 5px' class='badge' id='positiveCountMarkers_"+post.id+"' >"+post.positiveCount+"</span> \
                            <span class='glyphicon glyphicon-thumbs-down'></span><span style='margin-left: 5px' class='badge' id='negativeCountMarkers_"+post.id+"'>"+post.negativeCount+"</span> \
                            <span class='glyphicon fa fa-hand-stop-o'></span><span style='margin-left: 5px' class='badge' id='complaints_"+post.id+"'>"+post.post_complaints_count+"</span> \
                        </div> \
                    </div> \
                    <div class='panel-body'> \
                        <div class='container-fluid'> \
                            <div class='row comment'> \
                                <div class='col-md-12 well'>"+ post.comment+" </div> \
                            </div> \
                            <div class='row photos-panel'> \
                               "+ photos +" \
                            </div>\
                            <div class='row' > \
                                <div class='col-sm-6'> \
                                    "+htmlStatus+" \
                                </div> \
                                <div class='col-sm-6'> \
                                    <div class='form-inline pull-right vote-action'> \
                                        <a class='"+(post.post_complaints_count == 0 ? "post-linkdisabled" : "")+"' id='viewPostComplaints_"+post.id+"' data-postcomplaints='"+ JSON.stringify(post.postComplaints) +"' onclick='CivicApp.Obra.ShowComplaintView(this)'><span style='margin-right: 3px' class='glyphicon glyphicon-list-alt' ></span>Ver Denuncias</a> \
                                        <a class='"+(post.user.is_spamer == 1 ? "post-linkdisabled" : "")+"'  id='markspamer_"+post.id+"' data-userid='"+post.user.id+"' data-username='"+post.user.username+"'  onclick='CivicApp.Obra.UserSpamerConfirm(this)'><span  style='margin-right: 3px' class='fa fa-user-times' ></span>Marcar usuario como Spamer</a> \
                                        <a id='postDelete_"+post.id+"' data-postid='"+post.id+"'  onclick='CivicApp.Obra.DeletePostConfirm(this);'><span  style='margin-right: 3px' class='glyphicon glyphicon-trash' ></span>Eliminar</a> \
                                    </div> \
                                </div> \
                            </div> \
                        </div> \
                    </div> \
                </div>";

            return htmlComment;
        };

        var ShowComplaintView = function(link)
        {
          //  var postId = link.id.split('_')[1];
            var linkControl = $(link);
            complaintsListDiv.html('');
            var complaints = linkControl.data('postcomplaints');
            if(complaints && complaints.length > 0)
                for(var i=0;i < complaints.length; i++)
                {
                    complaintsListDiv.append(BuildComplaintHtml(complaints[i]));
                }

            complaintsModal.modal('show');


        };

        var BuildComplaintHtml = function(complaint)
        {
           return  '<div id="commentPosted_'+complaint.id+'" class="panel panel-default panel-user-comment " > \
                    <div class="panel-title  ">  \
                        <div class="avatar-wrapper img-circle "> \
                            <img src="'+  complaint.user.avatar + '"  class="img-responsive avatar-width" alt="Avatar"> \
                        </div> \
                        <label >'+ complaint.user.username+'</label> \
                        <label >'+ complaint.created_at+'</label> \
                    </div> \
                    <div class="panel-body"> \
                        <div class="container-fluid"> \
                            <div class="row comment"> \
                                <div class="col-md-12 well">'+ complaint.comment+' </div> \
                            </div> \
                        </div> \
                    </div> \
                </div>';

        };

        var RemovePhoto = function(link)
        {
            var linkvalues = $(link);

            var id = linkvalues.data('photoid');

            var path = linkvalues.data('filename');


            $.post('/admin/RemovePhoto/',{"photo":{"id": id ,"path":path}},function(result){

                debugger;
                if(result.status=='OK')
                {
                    linkvalues.parent().remove();

                }
                else if(result.message)
                {
                    Utilities.ShowError(result.message);
                }
                else
                {
                    Utilities.ShowError('Se ha producido un error al eliminar la photo');
                }
            }).fail(function(err){
                Utilities.ShowError('Se ha producido un error al eliminar la photo');
            });
        };

        var DeletePostConfirm = function(link)
        {
            var linkvalues = $(link);

            var id = linkvalues.data('postid');

           Utilities.ConfirmDialog('¿Esta seguro que desea eliminar el Post seleccionado?',CivicApp.Obra.DeletePost, id);


        };

        var UserSpamerConfirm = function(link)
        {
            var linkvalues = $(link);

            var id = linkvalues.data('userid');

            var username = linkvalues.data('username');

            Utilities.ConfirmDialog('¿Esta seguro que desea marcar como spamer el usuario '+username+' ?',CivicApp.Obra.MarkAsSpamer, linkvalues);

        };

        var MarkAsSpamer = function(link)
        {
            var userId = link.data('userid');

            $.post('/admin/MarkAsSpamer/',{"userId":userId} ,function(result){

                if(result.status=='OK')
                {
                    $('.user-'+userId).addClass('user-spamer');
                    link.addClass('post-linkdisabled');
                }
                else if(result.message)
                {
                    Utilities.ShowError(result.message);
                }
                else
                {
                    Utilities.ShowError('Se ha producido un error al intentar marcar como spamer el usuario');
                }
            }).fail(function(err){

                Utilities.ShowError('Se ha producido un error al intentar marcar como spamer el usuario.'+(err.message && err.message? err.message : ''));
            });
        };

        var DeletePost = function(id)
        {
            $.post('/admin/DeletePost/',{"postId":id} ,function(result){

                if(result.status=='OK')
                {
                    var postRemoved = $('#commentPosted_'+id);
                    var countComplaint = parseInt(postRemoved.data('postcomplaintscount'));
                    CivicApp.ObrasGrid.UpdatePostComplaintsCountEdited(-countComplaint);
                    postRemoved.remove();
                    obra.commentsCount = --obra.commentsCount;

                }
                else if(result.message)
                {
                    Utilities.ShowError(result.message);
                }
                else
                {
                    Utilities.ShowError('Se ha producido un error al eliminar la photo');
                }
            }).fail(function(err){

                Utilities.ShowError('Se ha producido un error al eliminar el post'+(err.message && err.message? err.message : ''));
            });
        };

        var SaveBarrioLocation = function()
        {

            var location = CivicApp.PopUpLocation.mapPopUp().GetLatLng();
            if(!location) {
                Utilities.ShowError('No hay ningúna ubicación seleccionada para guardar');
                return;
            }
            Utilities.block();
            $.post('/admin/SaveBarrioLocation',{"barrioId":obra.barrio.id, "location": location},
                function(data)
                {
                    if(data.status == 'Ok')
                    {
                        var listvalues = barrioInput.data('listvalues');
                        var barrioSelectedId = barrioInput.data('idSelected');

                        var barrio = Utilities.findandGetInList(listvalues,'id',barrioSelectedId);
                        barrio.location = location;
                        Utilities.findAndReplaceList(listvalues,'id',barrioSelectedId,barrio);

                        barrioInput.data('location', location);
                    }
                    else
                    {
                        Utilities.ShowError(data.message);
                    }

                    $.unblockUI();

                }).fail(function()
                {
                    $.unblockUI();
                    Utilities.ShowError('Ocurrió un error al intentar guardar la ubicación del barrio');
                });



        };


        var InitilizeMap = function()
        {
           /* var init = CivicApp.GmapHelper.InitMap();
            init.then(function() {

                CivicApp.GmapHelper.SouthWest = '-31.471168, -64.278946';
                CivicApp.GmapHelper.NorthEast = '-31.361003, -64.090805';
                CivicApp.GmapHelper.CreateAutocomplete('autocompleteMap');
                CivicApp.GmapHelper.AddEventClickAddMarker();
            });*/

            map = new CivicApp.GmapHelper2.Map();
            var init = map.InitMap('map');
            init.then(function() {
                map.southWest = '-31.471168, -64.278946';
                map.northEast = '-31.361003, -64.090805';
                map.CreateSearchBox('autocompleteMap');
                map.AddEventClickAddMarker();
            });


            CivicApp.PopUpLocation.InitializeMap();
/*
            mapPopUp = new CivicApp.GmapHelper2.Map();
            var initmapPopUp = mapPopUp.InitMap('popUpMap');
            initmapPopUp.then(function() {
                mapPopUp.southWest = '-31.471168, -64.278946';
                mapPopUp.northEast = '-31.361003, -64.090805';
                mapPopUp.CreateAutocomplete('autocompletepopUpMap');
                mapPopUp.AddEventClickAddMarker();

            });
*/
        };

        var LoadCatalogs = function() {
            debugger;


            Utilities.Autocomplete('category','/admin/AddCategory',
                function(value, ui, event, control){
                    var flag =  value.trim() != "" && !ui.item;
                    $('#editIcons').toggle(!flag);
                },
                function(){
                    $('#imagesUpload').modal('show');
                    $('#editIcons').toggle(true);
                });
            Utilities.Autocomplete('barrio','/admin/AddBarrio',
                function(value, ui, event, control){
                    var flag =  value.trim() != "" && !ui.item;

                    if(!flag)
                        $(control).data('location', ui.item.location)

                    $('#editBarrio').toggle(!flag);
                },
                function(){
                    CivicApp.PopUpLocation.DisplayPopUpLocation();
                    //$('#popUpLocation').modal('show');
                    $('#editBarrio').toggle(true);
                });
            Utilities.Autocomplete('CPC','/admin/AddCpc');

        };

        return {

            LoadCatalogs : LoadCatalogs,
            InitMap : InitilizeMap,
            InitEvents: InitEvents,
            Obra : obra,
            LoadObra : LoadObra,
            FocusForm: FocusForm,
            DeleteObra: DeleteObra,
            RemovePhoto:RemovePhoto,
            DeletePost:DeletePost,
            DeletePostConfirm:DeletePostConfirm,
            ShowComplaintView:ShowComplaintView,
            MarkAsSpamer:MarkAsSpamer,
            UserSpamerConfirm:UserSpamerConfirm


        };

    };

})();

$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});

$(document).ready(function(){
    debugger;
    CivicApp.Obra.LoadCatalogs();
    CivicApp.Obra.InitEvents();
});
