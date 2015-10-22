<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Asistencia extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idasistencias';

	public function scopeGetUsersPorEvento($query,$ideventos)
	{
		$query->join('users','users.id','=','asistencias.idusers')
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->where('asistencias.ideventos','=',$ideventos)
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','personas.telefono','personas.celular','users.email','users.num_documento');
		return $query;
	}

}