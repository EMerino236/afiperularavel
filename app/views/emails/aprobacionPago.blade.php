<html>
<body>
	<h2>¡Hola {{$padrinoPago->nombres}} {{ $padrinoPago->apellido_pat }}! hemos realizado la aprobación del pago realizado a AFI - Perú.</h2>
	<p>Detalle del pago: </p>
	</br>
	<p>Número de comprobante: {{$padrinoPago->num_comprobante}} </p>
	<p>Número de cuota: {{$padrinoPago->num_cuota}} </p>
	<p>Monto: S/.{{$padrinoPago->monto}} </p>
	<p>Fecha Pago: {{$padrinoPago->fecha_pago}} </p>
	</br>
	<p>Gracias por ayudarnos a brindar una Feliz Infancia :)</p>
</body>
</html>