<?php

use \Asistencia;
use \Evento;
use \Padrino;
use \CalendarioPago;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PushMail extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mail:push';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Execute the Mail notifications job.';

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

		//Coger todos los padrinos activos
		$sponsors = Padrino::getActivePadrinosPushMailInfo()->get();

		foreach ($sponsors as $s)
		{
			//Si el padrino tiene registrado un correo
			if ($s->email)
			{
				//Buscar si hay una deuda pendiente para el día siguiente
				$fee = CalendarioPago::getCalendarioPagoPendienteNextDayByPadrino($s->idpadrinos)->first();
				if ($fee)
				{
					//$message = 'Recordatorio de pago: ' . $fee->vencimiento;
					Helpers::pushMail($s, $fee);
				}
			}
		}
	}
}
