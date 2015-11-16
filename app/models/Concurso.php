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

		//$matchProyecto = ['proyectos.aprobacion' => 0, 'proyectos.idproyectos' => null];

		$query->join('fase_concursos','concursos.idconcursos','=','fase_concursos.idconcursos')
			  ->leftjoin('proyectos','concursos.idconcursos','=','proyectos.idconcursos')			  
			  //->where('proyectos.aprobacion','=',0)
			  //->orwhere('proyectos.idproyectos','=',null)			  		  
			  ->select('concursos.titulo','concursos.idconcursos','fase_concursos.fecha_limite','proyectos.aprobacion');
		return $query;
	}
}