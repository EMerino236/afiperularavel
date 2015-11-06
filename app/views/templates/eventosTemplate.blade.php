<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, follow">
	<title>Eventos</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
	<!-- Bootstrap Core CSS -->
    <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Datepicker CSS-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
    <!-- Calendar CSS-->
    <link rel="stylesheet" href="{{ asset('css/responsive-calendar.css') }}">
    <!-- MetisMenu CSS -->
    <link href="{{ asset('bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/gmap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/star-rating.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/general.css') }}" rel="stylesheet">
    <script type="text/javascript">
		var inside_url = "{{$inside_url}}";
	</script>
    <!-- jQuery -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Moment JavaScript -->
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <!-- Bootstrap Datepicker JavaScript -->
    <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Bootstrap Calendar JavaScript -->
    <script type="text/javascript" src="{{ asset('js/responsive-calendar.min.js') }}"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('dist/js/sb-admin-2.js') }}"></script>
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			@include('layouts.header', array('user'=>$user,'permisos'=>$permisos))
			<div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    @if(in_array('side_nuevo_evento',$permisos))
                    <li><a href="{{ URL::to('eventos/create_evento') }}"><i class="fa fa-plus fa-fw"></i> Nuevo Evento</a></li>
                    @endif
                    @if(in_array('side_listar_eventos',$permisos))
                    <li><a href="{{ URL::to('eventos/list_eventos') }}"><i class="fa fa-list fa-fw"></i> Listar Eventos</a></li>
                    @endif
                    @if(in_array('side_nuevo_punto_reunion',$permisos))
                    <li><a href="{{ URL::to('eventos/create_punto_reunion') }}"><i class="fa fa-map-marker fa-fw"></i> Crear Punto de Reunión</a></li>
                    @endif
                    @if(in_array('side_listar_puntos_reunion',$permisos))
                    <li><a href="{{ URL::to('eventos/list_puntos_reunion') }}"><i class="fa fa-globe fa-fw"></i> Listar Puntos de Reunión</a></li>
                    @endif
                    @if(in_array('side_mis_eventos',$permisos))
                    <li><a href="{{ URL::to('eventos/mis_eventos') }}"><i class="fa fa-bell fa-fw"></i> Mis Eventos</a></li>
                    @endif
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
		</nav>
		<div id="page-wrapper">
            @yield('content')
        </div>
	</div>
</body>
</html>