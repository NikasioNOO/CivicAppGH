(function(){



    this.CivicApp = this.CivicApp || {};
    this.CivicApp.RegisterUser = this.CivicApp.RegisterUser || new function(){

        var usernameInput = $('#userNameReg');
        var emailInput = $('#emailReg');
        var firstNameInput = $('#firstNameReg');
        var lastNameInput = $('#lastNameReg');
        var passwordInput = $('#passwordReg');
        var passwordConfirmInput = $('#passwordConfirmReg');
        var genderSelect = $('#gender');
        var messageDiv = $('#divMessageRegister');
        var imgAvatar = $('#imgPreviewAvatar');
        var newUser = null;



        function User()
        {



            Object.defineProperty(this, 'username', {
                get: function() {
                    return usernameInput.val();
                },
                set: function(value) {

                    usernameInput.val(value ? value : '');
                },
                enumerable:true
            });

            Object.defineProperty(this, 'email', {
                get: function() {
                    return emailInput.val();
                },
                set: function(value) {

                    emailInput.val(value ? value : '');
                },
                enumerable:true
            });

            Object.defineProperty(this, 'first_name', {
                get: function() {
                    return firstNameInput.val();
                },
                set: function(value) {

                    firstNameInput.val(value ? value : '');
                },
                enumerable:true
            });

            Object.defineProperty(this, 'last_name', {
                get: function() {
                    return  lastNameInput.val();
                },
                set: function(value) {

                    lastNameInput.val(value ? value : '');
                },
                enumerable:true
            });

            Object.defineProperty(this, 'password', {
                get: function() {
                    return passwordInput.val();
                },
                set: function(value) {

                    passwordInput.val(value ? value : '');
                },
                enumerable:true
            });

            Object.defineProperty(this, 'password_confirmation', {
                get: function() {
                    return passwordConfirmInput.val();

                },
                set: function(value) {

                    passwordConfirmInput.val(value ? value : '');
                },
                enumerable:true
            });

            Object.defineProperty(this, 'gender', {
                get: function() {
                    return genderSelect.val();

                },
                set: function(value) {

                    genderSelect.val(value);
                    genderSelect.trigger('change');
                },
                enumerable:true
            });
        }

        var CleanUserRegister = function()
        {
            newUser.username ='';
            newUser.email = '';
            newUser.first_name = '';
            newUser.last_name = '';
            newUser.password = '';
            newUser.password_confirmation = '';
            newUser.gender = -1;
            grecaptcha.reset();
        };

        var InitEvents = function() {

            $('#modalRegister').on('show.bs.modal',function(e)
            {
               newUser = new User();

            });

            $('#btnRegister').on('click',function(e)
            {
                e.preventDefault();
                SaveUser();

            });

            $('#gender').on('change',function()
                {
                    if(this.value =='M')
                    {
                        imgAvatar.prop('src', AVATAR_M).parent().removeClass('hidden');
                    }
                    else if(this.value == 'F')
                    {
                        imgAvatar.prop('src', AVATAR_F).parent().removeClass('hidden');
                    }
                    else
                    {
                        if(!imgAvatar.parent().hasClass('hidden'))
                            imgAvatar.parent().addClass('hidden');
                    }
                }
            );


            $('#avatarUpload').on('change',function(){
                var file = this.files[0];
                var id = this.id ;
                var imageFile = file.type;
                var match= ["image/jpeg","image/png","image/jpg"];


                if (!((imageFile == match[0]) || (imageFile == match[1]) || (imageFile == match[2])))
                    {

                        Utilities.ShowMessage('Debe elegir archivos de imagen de tipo jpeg, png, jpg , gracias');
                        if (!imgAvatar.parent().hasClass('hidden'))
                            imgAvatar.parent().addClass('hidden');
                        return false;
                    }
                else
                    {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            imgAvatar.attr('src', e.target.result).parent().removeClass('hidden');
                        };

                        reader.readAsDataURL(this.files[0]);
                    }
                }
            );

        };

        var ResendConfirmationEmail = function(link)
        {
            var email = $(link).data('email');
            var url = $(link).data('route');

            $.post(url,{"email" : email},function(data)
            {
                if(data.status == 'OK')
                {
                    // Utilities.ShowSuccesMessage('Se ha guardado correctamente la Obra del Presupuesto Participativo');
                    $('#divMessageLogin').html(data.htmlMessage);
                }
                else
                {
                    if(data.htmlMessage)
                    {
                        $('#divMessageLogin').html(data.htmlMessage);
                    }
                    else
                        Utilities.ShowError(data.message);
                }
            })

        };

        var  SaveUser = function()
        {
            Utilities.block();
            var avatarFile = $('#avatarUpload')[0];
            var formData = new FormData();

            formData.append('user',JSON.stringify(newUser));
            formData.append('g-recaptcha-response',$('#g-recaptcha-response').val());
            if(avatarFile.files.length==1)
                formData.append('avatarUpload',avatarFile.files[0]);


            $.ajax({
                url: "/saveOwnUser", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success:function(data)
                {
                    if(data.status == 'OK')
                    {
                        // Utilities.ShowSuccesMessage('Se ha guardado correctamente la Obra del Presupuesto Participativo');
                        CleanUserRegister();
                        messageDiv.html(data.htmlMessage);
                    }
                    else
                    {
                        if(data.htmlMessage)
                        {
                            messageDiv.html(data.htmlMessage);
                        }
                        else
                            Utilities.ShowError(data.message);
                    }
                    $.unblockUI();

                },
                error:function(jqXHR, textStatus,  errorThrown )
                {
                    $.unblockUI();
                    Utilities.ShowError('Ocurrió un error al intentar registrar el usuario');
                }});

        };


        return {
            InitEvents: InitEvents,
            ResendConfirmationEmail: ResendConfirmationEmail

        }

    };
})();
$(document).ready(function(){

    CivicApp.RegisterUser.InitEvents();

});
