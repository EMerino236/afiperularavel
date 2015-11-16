<?php

use \Asistencia;
use \Evento;
use \Padrino;
use \CalendarioPago;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PushAPNS extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'apns:push';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Execute the APNS notifications job.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//Coger eventos del día siguiente
		$events = Evento::getNextDayEventos()->get();

		foreach ($events as $e)
		{
			//Coger los voluntarios asignados al evento
			$volunteers = Asistencia::getUserPushInfoByEvento($e->ideventos)->get();

			foreach ($volunteers as $v)
			{
				//Si el usuario tiene activado el push sobre eventos y tiene registrado su UUID
				if ($v->push_eventos && $v->uuid)
				{
					$message = 'Recordatorio de evento: ' . $e->nombre . ' - ' . $e->fecha_evento;
					$this->push($v->uuid, $message);
				}
			}
		}

		//Coger todos los padrinos
		$sponsors = Padrino::getActivePadrinosPushInfo()->get();

		foreach ($sponsors as $s)
		{
			//Si el padrino tiene activado el push de pagos y tiene registadro su UUID
			if ($s->push_pagos && $s->uuid)
			{
				//Buscar si hay una deuda pendiente para el día siguiente
				$fee = CalendarioPago::getCalendarioPagoPendienteNextDayByPadrino($s->idpadrinos)->first();
				if ($fee)
				{
					$message = 'Recordatorio de pago: ' . $fee->vencimiento;
					$this->push($s->uuid, $message);
				}
			}
		}
	}

	private function push($deviceToken, $message)
	{
		echo 'push:' . $deviceToken . PHP_EOL;
		echo 'push:' . $message . PHP_EOL;

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
