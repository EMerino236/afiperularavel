<?php
class Helpers extends BaseController{
	// Función que registra los logs de auditoria
	public static function registrarLog($idtipo_logs,$descripcion)
	{
	    if(Auth::check()){
			$log = new LogAuditoria;
			$log->idtipo_logs = $idtipo_logs;
			$log->descripcion = $descripcion;
			$log->users_id = Session::get('user')->id;
			$log->save();
		}else{
			return View::make('error/error');
		}
	}

	//Enviar una notificación a app en iOS
	public static function pushAPNS($deviceToken, $message, $type)
	{
		echo 'pushAPNS:' . $deviceToken . PHP_EOL;
		echo 'pushAPNS:' . $message . PHP_EOL;

		// Put your private key's passphrase here:
		$passphrase = 'alonso3000';

		////////////////////////////////////////////////////////////////////////////////

		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);

		echo 'Connected to APNS' . PHP_EOL;

		// Create the payload body
		$body['aps'] = array(
			'alert' => $message,
			'sound' => 'default',
			'badge' => 1
			);
		$body['id'] = $type;

		// Encode the payload as JSON
		$payload = json_encode($body);

		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));

		if (!$result)
			echo 'Message not delivered' . PHP_EOL;
		else
			echo 'Message successfully delivered' . PHP_EOL;

		// Close the connection to the server
		fclose($fp);
	}
}
?>