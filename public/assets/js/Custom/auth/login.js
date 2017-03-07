(function(){



    this.CivicApp = this.CivicApp || {};
    this.CivicApp.Login = this.CivicApp.Login || new function(){

        var messageDiv = $('#divMessageLogin');
        var emailInput = $('#email');
        var passwordInput = $('#password');
        var rememberCheck = $('#remember')


        var InitEvents = function() {


            $('#loginBtn').on('click',function(e)
            {
                e.preventDefault();
                Login();

            });


        };

        var  Login = function()
        {

            var email = emailInput.val();
            var password = passwordInput.val();

            var remember = rememberCheck.is(':checked');

            $.post('/SocialLogin',{ "email": email, "password":password, "remember":remember},
                function(data){
                    if(data.status == 'OK')
                    {
                        window.location.href =  '/';
                    }
                    else
                    {
                        if(data.htmlMessage)
                            messageDiv.html(data.htmlMessage);
                    }


                }).fail(function(err)
                {
                    Utilities.ShowError('Ocurrió un error al intentar iniciar sessión.');
                });




        };


        return {
            InitEvents: InitEvents


        }

    };
})();
$(document).ready(function(){

    CivicApp.Login.InitEvents();

});

