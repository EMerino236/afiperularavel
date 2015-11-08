<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Precolegio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'precolegios';  
	protected $primaryKey = 'idprecolegios';



	public function scopeGetPreColegiosInfo($query)
	{
		$query->select('precolegios.*');
		return $query;
	}

	public function scopeGetActivePreColegiosInfo($query)
	{
		$query->select('precolegios.*');
		return $query;
	}

	public function scopeSearchPreColegioById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('precolegios.idprecolegios','=',$search_criteria)
			  ->select('precolegios.*');
		return $query;
	}

}