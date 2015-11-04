<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PostulantesPeriodo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idpostulantes_periodos';

	public function scopeGetPostulantesPorPeriodoFase($query,$idperiodos,$idfases)
	{
		$query->join('postulantes','postulantes.idpostulantes','=','postulantes_periodos.idpostulantes')
			  ->where('postulantes_periodos.idperiodos','=',$idperiodos)
			  ->where('postulantes_periodos.idfases','=',$idfases)
			  ->select('postulantes.nombres','postulantes.apellido_pat','postulantes.apellido_mat',
			  			'postulantes.fecha_nacimiento','postulantes.num_documento','postulantes.email','postulantes_periodos.*');
		return $query;
	}
}