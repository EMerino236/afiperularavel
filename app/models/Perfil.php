<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Perfil extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'perfiles';
	protected $primaryKey = 'idperfiles';

	public function scopeGetPerfilesCreacion($query)
	{
		$query->where('idperfiles','!=','4');
		return $query;
	}

	public function scopeSearchPerfilById($query,$search_criteria)
	{
		$query->where('idperfiles','=',$search_criteria);
		return $query;
	}

}