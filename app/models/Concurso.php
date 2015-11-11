<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Concurso extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'concursos';
	protected $primaryKey = 'idconcursos';



	public function scopeGetConcursosInfo($query)
	{
		$query->select('concursos.titulo','concursos.resenha','concursos.*');
		return $query;
	}

	public function scopeSearchConcursos($query,$search_criteria)
	{
		$query->whereNested(function($query) use($search_criteria){
			  		$query->where('concursos.titulo','LIKE',"%$search_criteria%")
			  			  ->orWhere('concursos.resenha','LIKE',"%$search_criteria%");			 	
		 		 })
			  ->select('concursos.titulo','concursos.resenha','concursos.*');
		return $query;
	}

	public function scopeSearchConcursosById($query,$idconcursos)
	{
		$query->where('concursos.idconcursos','=',$idconcursos)
			  ->select('concursos.titulo','concursos.resenha','concursos.*');
		return $query;
	}

	public function scopeGetLatestConcursos($query)
	{
		$hoy = date('Y-m-d');
		$query->join('fase_concursos','concursos.idconcursos','=','fase_concursos.idconcursos')
			  ->where('fase_concursos.fecha_limite','>=',$hoy)			  
			  ->select('concursos.titulo','concursos.idconcursos')
			  ->distinct();
		return $query;
	}
}