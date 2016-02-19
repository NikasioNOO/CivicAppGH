<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Nuestra Córdoba">
    <meta name="author" content="Ortiz Olmos, Nicolás D.">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/vnd.microsoft.icon">
    <title>Nuestra C&oacute;rdoba</title>

    {!! Html::style('assets/css/bootstrap.css') !!}
    {!! Html::style('assets/css/CivicApp.css') !!}
    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->

    {!! Html::script('assets/js/jquery-1.11.3.min.js') !!}
    {!! Html::script('assets/js/jquery-ui.min.js') !!}
    {!! Html::script('assets/js/bootstrap.min.js') !!}
    {!! Html::script('assets/js/Custom/menu.js') !!}
    {!! Html::script('assets/js/Custom/utilities.js') !!}
    @yield('scripts')


    @yield('head')

</head>
<body>

<div class="container">
    {!! csrf_field() !!}
<header>
    <div style="width: 100%">
        <div class="img-logo-wrapper" >
            <img src="{{ asset('assets/images/logo_nc.gif') }}" class="img-responsive" alt="LOGO">
        </div>
        @if(Auth::check())
            <div class="label label-default" style="right: 0;" >
                <span>{{ Auth::user()->username }}</span>
            </div>
        @endif

    </div>
</header>
<nav class="navbar navbar-default">

    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Ciudadano</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li  ><a href="/home"><span class="glyphicon glyphicon-home"></span></a></li>
                <li ><a href="/">Presupuesto P&uacute;blico</a></li>
                <li><a href="#">Presupuesto Participativo</a></li>
                <li><a href="#">Concejo Deliberante</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administraci&oacute;n <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/CrearAppUser">Crear usuario</a></li>
                        <li><a href="#">Another action</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
                @if(Auth::check())
                    <li><a href="#/Logout">Cerrar sessi&oacute;n</a></li>
                @endif

            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>






@yield('content')

    </div>

</body>
</html>