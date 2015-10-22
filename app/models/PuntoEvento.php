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
	
	public function scopeGetPuntosPorEvento($query,$ideventos)
	{
		$query->join('puntos_reunion','puntos_reunion.idpuntos_reunion','=','puntos_eventos.idpuntos_reunion')
			  ->where('puntos_eventos.ideventos','=',$ideventos)
			  ->select('puntos_eventos.idpuntos_reunion','puntos_reunion.latitud','puntos_reunion.longitud','puntos_reunion.direccion');
		return $query;
	}

}