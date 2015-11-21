<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DetalleProyecto extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'detalle_proyectos';
	protected $primaryKey = 'iddetalle_proyectos';


	public function scopeGetDetallePorProyecto($query,$idproyectos)
	{
		$query->where('detalle_proyectos.idproyectos','=',$idproyectos)
			  ->select('detalle_proyectos.*');
		return $query;
	}

	public function scopeGetNombreDisponible($query,$idproyectos,$titulo)
	{
		$query->where('detalle_proyectos.idproyectos','=',$idproyectos)
			  ->where('detalle_proyectos.titulo','=',$titulo)
			  ->select('detalle_proyectos.*');
		return $query;
	}

	public function scopeGetNombreDisponibleEdit($query,$iddetalle,$idproyectos,$titulo)
	{
		$query->where('detalle_proyectos.idproyectos','=',$idproyectos)
			  ->where('detalle_proyectos.iddetalle_proyectos','!=',$iddetalle)
			  ->where('detalle_proyectos.titulo','=',$titulo)			  
			  ->select('detalle_proyectos.*');
		return $query;
	}
}