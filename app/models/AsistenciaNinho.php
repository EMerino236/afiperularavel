<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AsistenciaNinho extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idasistencia_ninhos';

	public function scopeGetNinhosPorEvento($query,$ideventos)
	{
		$query->join('ninhos','ninhos.idninhos','=','asistencia_ninhos.idninhos')
			  ->where('asistencia_ninhos.ideventos','=',$ideventos)
			  ->select('ninhos.*', 'asistencia_ninhos.idasistencia_ninhos');
		return $query;
	}

	public function scopeGetComentariosPorEvento($query,$ideventos)
	{
		$query->join('ninhos','ninhos.idninhos','=','asistencia_ninhos.idninhos')
			  ->join('comentarios','comentarios.idasistencia_ninhos','=','asistencia_ninhos.idasistencia_ninhos')
			  ->join('users','users.id','=','comentarios.idusers')
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->where('asistencia_ninhos.ideventos','=',$ideventos)
			  ->orderBy('comentarios.idusers','asc')
			  ->select('personas.nombres as nombres_persona','personas.apellido_pat as apellido_pat_persona','personas.apellido_mat as apellido_mat_persona','ninhos.nombres as nombres_ninho','ninhos.apellido_pat as apellido_pat_ninho','ninhos.apellido_mat as apellido_mat_ninho', 'comentarios.comentario','comentarios.calificacion','comentarios.created_at');
		return $query;
	}

}