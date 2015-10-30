<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, follow">
	<title>Colegios</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
	<!-- Bootstrap Core CSS -->
    <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="{{ asset('bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <script type="text/javascript">
		var inside_url = "{{$inside_url}}";
	</script>
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			@include('layouts.header', array('user'=>$user,'permisos'=>$permisos))
			<div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    @if(in_array('side_nuevo_colegio',$permisos))
                    <li><a href="{{ URL::to('colegios/create_colegio') }}"><i class="fa fa-plus fa-fw"></i> Registrar Colegio</a></li>
                    @endif
                    @if(in_array('side_listar_colegios',$permisos))
                    <li><a href="{{ URL::to('colegios/list_colegios') }}"><i class="fa fa-list fa-fw"></i> Listar Colegios</a></li>
                    @endif
                    @if(in_array('side_aprobar_colegios',$permisos))
                    <li><a href="{{ URL::to('#') }}"><i class="fa fa-check fa-fw"></i> Aprobar Colegios</a></li>
                    @endif
                    @if(in_array('side_nuevo_ninho',$permisos))
                    <li><a href="{{ URL::to('ninhos/create_ninho') }}"><i class="fa fa-check fa-send"></i> Registrar Niño</a></li>
                    @endif
                    @if(in_array('side_listar_ninhos',$permisos))
                    <li><a href="{{ URL::to('ninhos/list_ninhos') }}"><i class="fa fa-list fa-child"></i><i class="fa fa-check fa-child"></i> Listar Niños</a></li>
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
</body>
</html>