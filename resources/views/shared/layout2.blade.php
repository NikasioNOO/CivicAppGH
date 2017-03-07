<!DOCTYPE html>
<html>
<head>
    <meta property="fb:app_id" content="{{ env('FB_ID') }}" />
    <meta property="og:url"                content="" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="" />
    <meta property="og:description"        content="" />
    <meta property="og:image"              content="{{ asset('assets/images/favicon.ico') }}" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Nuestra Córdoba">
    <meta name="author" content="Ortiz Olmos, Nicolás D.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/vnd.microsoft.icon">
    <title>Nuestra C&oacute;rdoba</title>

    {!! Html::style('assets/css/bootstrap.css') !!}
    {!! Html::style('assets/jquery-ui/jquery-ui.css') !!}
    {!! Html::style('assets/css/font-awesome.min.css') !!}
    {!! Html::style('assets/css/CivicApp.css') !!}

    @stack('cssCustom')

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->



</head>
<body>
<div id="fb-root"></div>
<div class="container-fluid main-container" >
    {!! csrf_field() !!}
    <header>

        <nav class="navbar  navbar-static-top navbar-layout">

            <div class="container-fluid">
                <div class="navbar-header ">

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar" ></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">

                        <img alt="Brand" src="{{ asset('assets/images/logo_nc.gif') }}" class="img-responsive" width="80px">

                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse ">
                    <ul class="nav navbar-nav" >
                        <li><a href="/">INICIO</a></li>
                        <li><a href="#">ACERCA DE</a></li>
                        <li><a href="#">PREGUNTAS FRECUENTES</a></li>
                        @if(  Auth::guard("webadmin")->check() && Auth::guard("webadmin")->user()->hasRole('Admin'))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ADMINISTRACION<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/admin/CrearAppUser">Crear usuario</a></li>
                                <li><a href="/admin/ObrasPresupAdmin">Presupuesto Participativo</a></li>
                                <li><a href="/admin/ObrasPresupAdmin">Espacios Verdes</a></li>
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>
                        @endif
                        @if(  Auth::guard("webadmin")->check())
                            <li style=""><a href="/Logout" >CERRAR SESION</a></li>
                        @elseif(Auth::guard("websocial")->check())
                            <li style=""><a href="/LogoutSocial" >CERRAR SESION</a></li>
                        @else
                            <li><a href="#" data-toggle="modal" data-target="#modalRegister" >REGISTRARSE</a></li>
                            <li><a href="#"  data-toggle="modal" data-target="#modalLogin">INGRESAR</a></li>
                        @endif
                        @if(Auth::guard('webadmin')->check())
                            <li class="right user-loggued" >
                                        <span class="label label-blue " style="font-size: smaller">Administrador</span>
                                        <span class="label label-success">{{ Auth::guard('webadmin')->user()->username }}</span>
                            </li>
                        @elseif(Auth::guard('websocial')->check())
                            <li class="right user-loggued">
                                <div style="" class="avatar-wrapper img-circle">
                                    <img src="{{ Auth::guard('websocial')->user()->avatar }}"  class="img-responsive avatar-width" alt="Avatar">
                                </div>
                            </li>
                            <li class="right user-loggued" >
                                <span class="label" style="color: #000000;text-decoration: underline">{{ Auth::guard('websocial')->user()->username }}</span>
                            </li>
                        @endif
                    </ul>
                </div><!--/.nav-collapse -->


            </div><!--/.container-fluid -->
        </nav>
    </header>


    @yield('content')
    @include('auth.loginSocial')
    @include('auth.registerSocial')
</div>
{!! Html::script('assets/js/jquery-1.11.3.min.js') !!}
{!! Html::script('assets/jquery-ui/jquery-ui.js') !!}
{!! Html::script('assets/js/bootstrap.min.js') !!}
{!! Html::script('assets/js/jquery.blockUI.js') !!}
{!! Html::script('assets/js/Custom/menu.js') !!}
{!! Html::script('assets/js/Custom/utilities.js') !!}
@stack('scripts')


@yield('head')
</body>
</html>