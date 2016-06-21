<!DOCTYPE html>
<html>
<head>
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

<div class="container-fluid">
    {!! csrf_field() !!}
<header>
    <div class="row">
        <div class="col-sm-2">
            <div class="img-logo-wrapper">
                <img src="{{ asset('assets/images/logo_nc.gif') }}" class="img-responsive" alt="LOGO">
            </div>
        </div>
    @if(Auth::guard('webadmin')->check())
        <div class="col-sm-offset-7 col-sm-3" >
            <div class="form-inline right user-loggued">
                <div class="form-group " >
                    <label class="label label-blue " style="font-size: smaller">Administrador</label>
                </div>
                <div class="form-group ">
                    <label class="label label-success">{{ Auth::guard('webadmin')->user()->username }}</label>


                </div>
            </div>
        </div>

    @elseif(!Auth::guard('websocial')->check())
            <div class="col-sm-offset-6 col-sm-2" style="padding: 5px" >
                <div class="form-group-sm form-social-singin" style="padding-right: 0"><label class="label-blue fullWidth">Iniciar sesion con</label></div>
            </div>
            <div class="col-sm-2" style="padding: 5px 15px 5px 0px" >
                <div class="form-group-sm">


                        {!! Form::open(['url' => '#', 'class' => 'form-social-singin form-horizontal' ] ) !!}

                        <a href="{{ route('social.redirect', ['provider' => 'facebook']) }}" class="btn btn-primary btn-sm btn-block facebook" type="submit">Facebook <span class="fa fa-facebook-official"></span> </a>
                        <a href="{{ route('social.redirect', ['provider' => 'twitter']) }}" class="btn btn-primary btn-sm btn-block twitter" type="submit">Twitter <span class="fa fa-twitter"></span></a>

                        {!! Form::close() !!}

                </div>
            </div>
    @elseif(Auth::guard('websocial')->check())
        <div class="col-sm-offset-7 col-sm-3" >
            <div class="form-inline right user-loggued">
                <div class="form-group " >
                    <label class="label label-primary">{{ Auth::guard('websocial')->user()->username }}</label>
                </div>
                <div class="form-group ">
                    <div style="" class="avatar-wrapper img-circle">
                        <img src="{{ Auth::guard('websocial')->user()->avatar }}"  class="img-responsive avatar-width" alt="Avatar">
                    </div>

                </div>
            </div>
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
            <ul class="nav navbar-nav" style="width: 90%">
                <li  ><a href="/"><span class="glyphicon glyphicon-home"></span></a></li>
                <li><a href="/Obras">Presupuesto Participativo</a></li>
                <li><a href="#">Espacios Verdes</a></li>
                @can('admin-role')
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administraci&oacute;n <span class="caret"></span></a>
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
                @endcan
                @if(  Auth::guard("webadmin")->check())
                    <li style="float: right"><a href="/Logout" >Cerrar sessi&oacute;n</a></li>
                @elseif(Auth::guard("websocial")->check())
                    <li style="float: right"><a href="/LogoutSocial" >Cerrar sessi&oacute;n</a></li>
                @endif

            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>






@yield('content')

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