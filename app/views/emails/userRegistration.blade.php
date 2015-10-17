<html>
<body>
	<h2>¡Hola {{$persona->nombres}} {{ $persona->apellido_pat }}! acabas de registrarte en el sistema de AFI Perú.</h2>
	<p>Su número de documento para poder iniciar sesión es: <strong>{{ $user->num_documento }}</strong></p>
	<p>Su contraseña es: <strong>{{ $password }}</strong></p>
	</br>
	<p>Gracias por ayudarnos a brindar una Feliz Infancia :)</p>
</body>
</html>