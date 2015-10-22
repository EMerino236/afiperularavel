<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Visualizacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'visualizaciones';
	protected $primaryKey = 'idvisualizaciones';

	public function scopeGetVisualizacionesPorEventoPorDocumento($query,$ideventos,$iddocumentos)
	{
		$query->join('users','users.id','=','visualizaciones.idusers')
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->where('visualizaciones.ideventos','=',$ideventos)
			  ->where('visualizaciones.iddocumentos','=',$iddocumentos)
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','users.email','personas.telefono','personas.celular','visualizaciones.created_at');
		return $query;
	}

}