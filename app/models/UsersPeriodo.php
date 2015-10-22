<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UsersPeriodo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idusers_periodos';

	public function scopeGetUsersPorPeriodo($query,$idperiodos)
	{
		$query->join('users','users.id','=','users_periodos.idusers')
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->where('users_periodos.idperiodos','<=',$idperiodos)
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','personas.telefono','personas.celular','users_periodos.idusers','users.email','users.num_documento');
		return $query;
	}

}