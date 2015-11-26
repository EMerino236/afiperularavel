<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, follow">
	<title>Voluntarios</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
	<!-- Bootstrap Core CSS -->
    <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="{{ asset('bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/general.css') }}" rel="stylesheet">
    <link href="{{ asset('css/gmap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/star-rating.min.css') }}" rel="stylesheet">
    <script type="text/javascript">
		var inside_url = "{{$inside_url}}";
	</script>
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			@include('layouts.header', array('user'=>$user,'permisos'=>$permisos))
			<div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    @if(in_array('side_listar_voluntarios',$permisos))
                    <li><a href="{{ URL::to('voluntarios/list_voluntarios') }}"><i class="fa fa-list fa-fw"></i> Listar Voluntarios</a></li>
                    @endif
                    @if(in_array('side_reporte_asistencia',$permisos))
                    <li><a href="{{ URL::to('voluntarios/list_reporte_calificaciones') }}"><i class="fa fa-bar-chart-o fa-fw"></i> Reporte de Asistencia</a></li>
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

<!-- jQuery -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="{{ asset('bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset('dist/js/sb-admin-2.js') }}"></script>
<script  src="{{ asset('js/star-rating.min.js') }}"></script>
<script  src="{{ asset('js/voluntarios/calificacion.js') }}"></script>
</body>
</html>