<html>
<body>
	<h2>¡Hola estimado voluntario de AFI Perú!</h2>
	<p>Se modificó un evento al cual estas asignado, la información actual es:</p>
	<ul>
		<li><strong>Evento:</strong> {{ $evento->nombre }}</li>
		<li><strong>Dirección:</strong> {{ $evento->direccion }}</li>
		<li><strong>Fecha:</strong> {{ date('d/m/Y',strtotime($evento->fecha_evento)) }}</li>
		<li><strong>Hora:</strong> {{ date('H:i',strtotime($evento->fecha_evento)) }}</li>
	</ul>
	<p>Para mayor información, por favor acceda a su cuenta.</p>
</body>
</html>