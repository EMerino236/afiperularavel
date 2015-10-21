<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Ninho extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idninhos';

	public function scopeGetNinhosPorColegio($query,$idcolegios)
	{
		$query->where('idcolegios','=',$idcolegios);
		return $query;
	}

}