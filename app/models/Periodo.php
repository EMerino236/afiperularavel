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

	public function scopeGetPeriodosInfo($query)
	{
		$query->withTrashed()
			  ->select('periodos.*');
		return $query;
	}

	public function scopeSearchPeriodos($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('periodos.nombre','LIKE',"%$search_criteria%")
			  ->select('periodos.*');
		return $query;
	}

	public function scopeSearchPeriodoById($query,$id)
	{
		$query->withTrashed()
			  ->where('periodos.idperiodos','=',$id)
			  ->select('periodos.*');
		return $query;
	}

	public function scopeGetFuturePeriodos($query)
	{
		$hoy = date('Y-m-d');
		$query->where('fecha_inicio','>=',$hoy)
			  ->orderBy('fecha_inicio')
			  ->select('*');
		return $query;
	}

	public function scopeGetPeriodosIntersectionWithDatesNewPeriod($query,$fecha)
	{
		$query->where('fecha_inicio','<=',$fecha)
			  ->where('fecha_fin','>=',$fecha);
		return $query;
	}

	public function scopeGetPeriodosIntersectionWithDatesNewPeriodEdit($query,$fecha,$idperiodo)
	{
		$query->where('fecha_inicio','<=',$fecha)
			  ->where('fecha_fin','>=',$fecha)
			  ->where('idperiodos','<>',$idperiodo);
		return $query;
	}
}