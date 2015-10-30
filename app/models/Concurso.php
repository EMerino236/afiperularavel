<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Concurso extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'concursos';
	protected $primaryKey = 'idconcursos';



	public function scopeGetConcursosInfo($query)
	{
		$query->withTrashed()			  
			  ->select('concursos.titulo','concursos.resenha','concursos.*');
		return $query;
	}

	public function scopeSearchConcursos($query,$search_criteria)
	{
		$query->withTrashed()
			  ->whereNested(function($query) use($search_criteria){
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
}