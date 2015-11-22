<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PostulantesPeriodo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idpostulantes_periodos';

	public function scopeGetPostulantesPorPeriodoFase($query,$idperiodos,$idfases,$estado_aprobacion)
	{
		if($estado_aprobacion !== ''){
			$query->join('postulantes','postulantes.idpostulantes','=','postulantes_periodos.idpostulantes')
				  ->where('postulantes_periodos.idperiodos','=',$idperiodos)
				  ->where('postulantes_periodos.idfases','=',$idfases)
				  ->where('postulantes_periodos.aprobacion','=',$estado_aprobacion)
				  ->select('postulantes.nombres','postulantes.apellido_pat','postulantes.apellido_mat',
				  			'postulantes.fecha_nacimiento','postulantes.num_documento','postulantes.email',
				  			'postulantes_periodos.idpostulantes_periodos','postulantes_periodos.idpostulantes','postulantes_periodos.idperiodos',
				  			'postulantes_periodos.comentario','postulantes_periodos.idfases',
				  			DB::raw('(CASE WHEN postulantes_periodos.aprobacion is null THEN -1 ELSE postulantes_periodos.aprobacion END) AS aprobacion'),
				  			DB::raw('(CASE WHEN postulantes_periodos.asistencia is null THEN -1 ELSE postulantes_periodos.asistencia END) AS asistencia'));
		}
		else{
			$query->join('postulantes','postulantes.idpostulantes','=','postulantes_periodos.idpostulantes')
				  ->where('postulantes_periodos.idperiodos','=',$idperiodos)
				  ->where('postulantes_periodos.idfases','=',$idfases)
				  ->select('postulantes.nombres','postulantes.apellido_pat','postulantes.apellido_mat',
				  			'postulantes.fecha_nacimiento','postulantes.num_documento','postulantes.email',
				  			'postulantes_periodos.idpostulantes_periodos','postulantes_periodos.idpostulantes','postulantes_periodos.idperiodos',
				  			'postulantes_periodos.comentario','postulantes_periodos.idfases',
				  			DB::raw('(CASE WHEN postulantes_periodos.aprobacion is null THEN -1 ELSE postulantes_periodos.aprobacion END) AS aprobacion'),
				  			DB::raw('(CASE WHEN postulantes_periodos.asistencia is null THEN -1 ELSE postulantes_periodos.asistencia END) AS asistencia'));
		}
		return $query;
	}

	public function scopeSearchPostulantePeriodoById($query,$id)
	{
		$query->withTrashed()
			  ->where('postulantes_periodos.idpostulantes_periodos','=',$id)
			  ->select('postulantes_periodos.*');
		return $query;
	}
}