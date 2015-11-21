<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class FasesConcurso extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'fase_concursos';
	protected $primaryKey = 'idfase_concursos';


	public function scopeGetFasesPorConcurso($query,$idconcursos)
	{
		$query->where('fase_concursos.idconcursos','=',$idconcursos)
			  ->select('fase_concursos.*');
		return $query;
	}

	public function scopeGetFechaDisponible($query,$idconcursos,$fecha_limite)
	{
		$query->where('fase_concursos.idconcursos','=',$idconcursos)
			  ->where('fase_concursos.fecha_limite','=',$fecha_limite)
			  ->select('fase_concursos.*');
		return $query;
	}

	public function scopeGetNombreDisponible($query,$idconcursos,$titulo)
	{
		$query->where('fase_concursos.idconcursos','=',$idconcursos)
			  ->where('fase_concursos.titulo','=',$titulo)
			  ->select('fase_concursos.*');
		return $query;
	}
}