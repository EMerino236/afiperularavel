<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Comentario extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idcomentarios';

	public function scopeGetComentarioPorUserPorNinhos($query,$idusers,$idasistencia_ninhos)
	{
		$query->where('idasistencia_ninhos','=',$idasistencia_ninhos)
			  ->where('users_id','=',$idusers);
		return $query;
	}

}