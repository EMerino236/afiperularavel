<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Periodo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idperiodos';

	public function scopeGetPeriodoActual($query)
	{
		$hoy = date('Y-m-d');
		$query->where('fecha_inicio','<=',$hoy)
			  ->where('fecha_fin','>=',$hoy);
		return $query;
	}

}