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
					Helpers::pushAPNS($v->uuid, $message, 1);
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
					Helpers::pushAPNS($v->uuid, $message, 2);
				}
			}
		}
	}
}
