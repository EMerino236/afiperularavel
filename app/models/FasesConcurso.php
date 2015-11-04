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

}