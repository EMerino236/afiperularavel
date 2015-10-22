<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Evento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'ideventos';

	public function scopeSearchEventosById($query,$ideventos)
	{
		$query->join('tipo_eventos','tipo_eventos.idtipo_eventos','=','eventos.idtipo_eventos')
			  ->where('eventos.ideventos','=',$ideventos)
			  ->select('tipo_eventos.nombre as tipo_evento','eventos.*');
		return $query;
	}

	public function scopeGetEventosInfo($query,$idperiodos)
	{
		$query->join('tipo_eventos','tipo_eventos.idtipo_eventos','=','eventos.idtipo_eventos')
			  ->where('eventos.idperiodos','=',$idperiodos)
			  ->select('tipo_eventos.nombre as tipo_evento','eventos.*');
		return $query;
	}

}