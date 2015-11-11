<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Proyecto extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idproyectos';


	public function scopeGetProyectosInfo($query)
	{
		$query->join('concursos','concursos.idconcursos','=','proyectos.idconcursos')
			  ->select('proyectos.*','concursos.titulo');
		return $query;
	}

	public function scopeSearchProyectos($query,$search_criteria)
	{
		$query->join('concursos','concursos.idconcursos','=','proyectos.idconcursos')			  			 
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('proyectos.nombre','LIKE',"%$search_criteria%")
			  			  ->orWhere('proyectos.resenha','LIKE',"%$search_criteria%")
			  			  ->orWhere('proyectos.jefe_proyecto','LIKE',"%$search_criteria%")	
			  			  ->orWhere('concursos.titulo','LIKE',"%$search_criteria%");			 	
		 		 })
			  ->select('concursos.titulo','proyectos.*');
		return $query;
	}

	public function scopeSearchProyectosById($query,$idproyectos)
	{
		$query->join('concursos','concursos.idconcursos','=','proyectos.idconcursos')	
			  ->where('proyectos.idproyectos','=',$idproyectos)
			  ->select('concursos.titulo','proyectos.*');
		return $query;
	}

}