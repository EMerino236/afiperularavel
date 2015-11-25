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
		$now = date("Y-m-d H:i:s");
		echo 'pushAPNS:Now: ' . $now . PHP_EOL;

		// Put your private key's passphrase here:
		$passphrase = 'alonso3000';

		$cert_path = base_path() . DIRECTORY_SEPARATOR . 'ck.pem';
		echo 'pushAPNS:' . $cert_path . PHP_EOL;

		////////////////////////////////////////////////////////////////////////////////

		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', $cert_path);
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		// Open a connection to the APNS server
		try
		{
			$fp = stream_socket_client(
				'ssl://gateway.push.apple.com:2195', $err,
				$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		}
		catch (Exception $e)
		{
			echo 'Connection caused fatal error.';
			return Response::json(['error' => 'Connection caused fatal error.'], 200);
		}

		if (!$fp)
			return Response::json(['error' => 'Could not establish connection with APNS: $err $errstr'], 200);

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
    
    //Enviar una notificación a app en Android
	public static function pushGCM($reg_ids, $m)
	{
        $GOOGLE_API_KEY = 'AIzaSyD_5fDPVn61JqNwdcMDpolwTf-1UaSh7vo';
        
		// Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
 
        $fields = array(
            'registration_ids' => $reg_ids,
            'data' => $m,
        );
 
        $headers = array(
            'Authorization: key=' . $GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        
        // Close connection
        curl_close($ch);
        
        if ($result === FALSE)
            return Response::json(['error' => 'Curl failed: ' . curl_error($ch)], 200);
 
        
        $result_json = json_decode($result);
        if($result_json == FALSE)
            return $result;
        
        return Response::json($result_json, 200);
	}

	//Enviar una notificación a mail
	public static function pushMail($user,$fee)
	{
	    Mail::send('emails.recordatorioPago',array('user'=> $user,'fee'=>$fee),function($message) use ($user,$fee)
			{
				$message->to($user->email)
						->subject('Recordatorio de Pago' . $fee->vencimiento);
			});
	}
}
?>