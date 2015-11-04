<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, follow">
	<title>Renovación de contraseña</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/password/password-style.css') }}">
    <link href="{{ asset('css/general.css') }}" rel="stylesheet">
	<!-- Scripts -->
	<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
</head>

<body>
	<div id="main-container">
		@yield('content')
	</div>
</body>
</html>