<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Evento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'ideventos';

	public function scopeSearchEventosById($query,$ideventos)
	{
		$query->where('ideventos','=',$ideventos);
		return $query;
	}

	public function scopeGetEventosInfo($query,$idperiodos)
	{
		$query->where('idperiodos','=',$idperiodos);
		return $query;
	}

	public function scopeGetNextDayEventos($query)
	{
		$now = date("Y-m-d H:i:s");

		$query->where('fecha_evento', '<', new \DateTime('tomorrow + 1day'))
			->where('fecha_evento', '>', new \DateTime());

		return $query;
	}
}