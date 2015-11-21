<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Voluntario extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idvoluntarios';

	public function scopeGetVoluntarioPorUser($query,$iduser)
	{
		$query->where('idusers','=',$iduser);
		return $query;
	}

	public function scopeGetVoluntarioPorUserTrashed($query,$iduser)
	{
		$query->withTrashed()
			  ->where('idusers','=',$iduser);
		return $query;
	}

	public function scopeGetVoluntarios($query)
	{
		$query->join('users','users.id','=','voluntarios.idusers')
			  ->join('personas','personas.idpersonas','=','users.idpersona');
		return $query;
	}

}