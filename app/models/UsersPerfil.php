<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UsersPerfil extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'users_perfiles';
	protected $primaryKey = 'idusers_perfiles';

	public function scopeGetUsersPorPerfil($query,$search_criteria)
	{
		$query->where('idperfiles','=',$search_criteria);
		return $query;
	}

}