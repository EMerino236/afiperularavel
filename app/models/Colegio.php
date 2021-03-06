<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Colegio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'colegios';  
	protected $primaryKey = 'idcolegios';

	public function scopeGetColegiosInfo($query)
	{
		$query->withTrashed()
			  ->select('colegios.*');
		return $query;
	}

	public function scopeGetActiveColegiosInfo($query)
	{
		$query->select('*');
		return $query;
	}

	public function scopeSearchColegioById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('colegios.idcolegios','=',$search_criteria)
			  ->select('colegios.*');
		return $query;
	}

	public function scopeSearchColegios($query,$search_criteria)
	{
		$query->withTrashed()
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('colegios.nombre','LIKE',"%$search_criteria%")
			  			  ->orWhere('colegios.direccion','LIKE',"%$search_criteria%");
			  })
			  ->select('colegios.*');
		return $query;
	}

}