<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Ninho extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idninhos';

	public function scopeGetNinhosPorColegio($query,$idcolegios)
	{
		$query->where('idcolegios','=',$idcolegios);
		return $query;
	}

	public function scopeGetNinhosInfo($query)
	{
		$query->withTrashed()
			  ->join('colegios','colegios.idcolegios','=','ninhos.idcolegios')
			  ->select('ninhos.*','colegios.nombre');
		return $query;
	}

	public function scopeSearchNinhoById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('ninhos.idninhos','=',$search_criteria)
			  ->select('ninhos.*');
		return $query;
	}

	public function scopeSearchNinhos($query,$search_criteria)
	{
		$query->withTrashed()
			  ->join('colegios','colegios.idcolegios','=','ninhos.idcolegios')	
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('ninhos.nombres','LIKE',"%$search_criteria%")
			  			  ->orWhere('ninhos.apellido_pat','LIKE',"%$search_criteria%")
			  			  ->orWhere('ninhos.apellido_mat','LIKE',"%$search_criteria%")
			  			  ->orWhere('colegios.nombre','LIKE',"%$search_criteria%");
			  })
			  ->select('ninhos.*','colegios.nombre');
		return $query;
	}
}