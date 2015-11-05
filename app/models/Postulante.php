<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Postulante extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idpostulantes';

	public function scopeSearchPostulanteById($query,$id)
	{
		$query->withTrashed()
			  ->where('postulantes.idpostulantes','=',$id)
			  ->select('postulantes.*');
		return $query;
	}
}