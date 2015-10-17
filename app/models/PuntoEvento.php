<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PuntoEvento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'puntos_eventos';
	protected $primaryKey = 'idpuntos_eventos';

	public function scopeGetEventosPorPunto($query,$search_criteria)
	{
		$query->where('idpuntos_reunion','=',$search_criteria);
		return $query;
	}

}