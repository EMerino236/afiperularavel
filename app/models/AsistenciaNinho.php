<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AsistenciaNinho extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idasistencia_ninhos';

	public function scopeGetNinhosPorEvento($query,$ideventos)
	{
		$query->join('ninhos','ninhos.idninhos','=','asistencia_ninhos.idninhos')
			  ->where('asistencia_ninhos.ideventos','=',$ideventos)
			  ->select('ninhos.*', 'asistencia_ninhos.idasistencia_ninhos');
		return $query;
	}

}