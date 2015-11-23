<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Empresa extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idempresas';

	public function scopeGetEmpresasInfo($query)
	{
		$query->select('empresas.*');
		return $query;
	}

	public function scopeSearchEmpresaById($query,$id)
	{
		$query->withTrashed()
			  ->where('idempresas','=',$id)
			  ->select('empresas.*');
		return $query;
	}

	public function scopeSearchEmpresas($query,$search_criteria)
	{
		$query->whereNested(function($query) use($search_criteria){
			  		$query->where('empresas.razon_social','LIKE',"%$search_criteria%")
			  			  ->orWhere('empresas.nombre_representante','LIKE',"%$search_criteria%")
			  			  ->orWhere('empresas.sector','LIKE',"%$search_criteria%")
			  			  ->orWhere('empresas.email','LIKE',"%$search_criteria%");
			  })
			  ->select('empresas.*');
		return $query;
	}

}