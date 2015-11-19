<?php

/*use \Asistencia;
use \Evento;
use \Padrino;
use \CalendarioPago;*/
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PushGCM extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'gcm:push';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Execute the GCM notifications job.';

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
			//Coger los gcm_regids de los voluntarios asignados al evento que pueden recibir notificaciones
			$registration_ids = Asistencia::getUsersToNotificate($e->ideventos)->get()->lists('gcm_token');
            
            $message = 'Recordatorio de evento: ' . $e->nombre . ' - ' . $e->fecha_evento;
            $response = Helpers::pushGCM($registration_ids, $message);
            //$this->info(var_dump($response));
		}

		///Coger todos los padrinos
		$sponsors = Padrino::getActivePadrinosPushInfo()->get();
        
		foreach ($sponsors as $s)
		{
			//Si el padrino tiene activado el push de pagos y tiene registadro su gcm_token
			if ($s->push_pagos && $s->gcm_token)
			{
				//Buscar si hay una deuda pendiente para el día siguiente
				$fee = CalendarioPago::getCalendarioPagoPendienteNextDayByPadrino($s->idpadrinos)->first();
				if ($fee)
				{
                    //$this->info(var_dump($s->gcm_regid));
					$message = 'Recordatorio de pago: ' . $fee->vencimiento;
					$response = Helpers::pushGCM(array($s->gcm_token), $message);
                    //$this->info(var_dump($response));
				}
			}
		}
	}

}
