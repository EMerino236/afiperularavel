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

}