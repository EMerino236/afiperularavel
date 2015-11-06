<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, follow">
	<title>Error</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
	<!-- jQuery -->
	<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript">
	</script>
</head>

<body id="error-background" style="margin:0;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background: url('{{ asset('img/error-background.jpg')}}') no-repeat center center fixed;
	background-size: cover;">
	<div style="width:100%;text-align:center;">
		<h1 style="color:#FF8000;">Ups... Ocurrió un error</h1>
		<h1 style="color:#04B404;">Pero lo estamos solucionando...</h1>
		<a style="color:#DF0101;" href="{{ URL::to('/') }}">¡Regresemos al inicio!</a>
	</div>
</body>
</html>