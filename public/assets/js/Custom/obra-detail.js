(function(){



    this.CivicApp = this.CivicApp || {};
    this.CivicApp.ObrasSocial = this.CivicApp.ObrasSocial || {};
    this.CivicApp.ObrasSocial.ObraDetail = this.CivicApp.ObrasSocial.ObraDetail ||  new function() {

        var allCommentsDiv = $('#allCommentsPanel');

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

        var obra = new ObraDetail();

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

            allCommentsDiv.html('')


            $.get('/ObraPP/Posts/'+obra.id,function(result){
                debugger;
                if(result.status='OK')
                {
                    obra.commentsCount= result.data.length;
                    if(result.data && result.data.length > 0)
                    {
                        for(var i =0 ; i < result.data.length; i++)
                        {
                            allCommentsDiv.append(BuildComment(result.data[i]))

                        }
                    }
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
                            <img class="img-responsive" src="' + post.photos[i].path + '" alt="..."> \
                        </div> ';
            }

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
                                    <label class="control-label label-small ">Cambio de estado: <b> '+post.status.status+' </b></label> \
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
            SetObra : SetObra
        }


    };
})();
