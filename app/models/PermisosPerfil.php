<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PermisosPerfil extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'permisos_perfiles';
	protected $primaryKey = 'idpermisos_perfiles';

	public function scopeGetPermisosPorPerfil($query,$search_criteria)
	{
		$query->where('idperfiles','=',$search_criteria);
		return $query;
	}

}