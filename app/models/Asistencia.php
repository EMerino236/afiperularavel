<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Asistencia extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idasistencias';

	public function scopeValidarAsistencia($query,$idusers,$ideventos)
	{
		$query->where('ideventos','=',$ideventos)
			  ->where('idusers','=',$idusers);
		return $query;
	}

	public function scopeGetUsersPorEvento($query,$ideventos)
	{
		$query->join('users','users.id','=','asistencias.idusers')
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->where('asistencias.ideventos','=',$ideventos)
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','personas.telefono','personas.celular','users.id','users.email','users.num_documento','asistencias.idasistencias','asistencias.asistio','asistencias.calificacion','asistencias.comentario');
		return $query;
	}

	public function scopeGetUserPushInfoByEvento($query, $ideventos)
	{
		$query->join('users','users.id', '=', 'asistencias.idusers')
			  ->where('asistencias.ideventos','=', $ideventos)
			  ->select('users.uuid', 'users.push_eventos', 'users.push_documents');
		
		return $query;
	}
    
    public function scopeGetUsersToNotificate($query, $ideventos)
	{
		$query->join('users','users.id', '=', 'asistencias.idusers')
			  ->where('asistencias.ideventos','=', $ideventos)
              ->where('users.push_eventos', '=', 1)
              ->whereNotNull('users.gcm_token')
			  ->select('users.gcm_token');
		
		return $query;
	}
    
    public function scopeGetUsersToNotificateDocumentUploaded($query, $ideventos)
	{
		$query->join('users','users.id', '=', 'asistencias.idusers')
			  ->where('asistencias.ideventos','=', $ideventos)
              ->where('users.push_documents', '=', 1)
              ->whereNotNull('users.gcm_token')
			  ->select('users.gcm_token');
		
		return $query;
	}

	public function scopeGetEventosPorUser($query,$idusers)
	{
		$query->join('eventos','eventos.ideventos','=','asistencias.ideventos')
			  ->where('asistencias.idusers','=',$idusers)
			  ->select('eventos.*');
		return $query;
	}

	public function scopeGetEventosPorUserPorFechas($query,$idusers,$fecha_ini,$fecha_fin)
	{
		$query->join('eventos','eventos.ideventos','=','asistencias.ideventos')
			  ->where('asistencias.idusers','=',$idusers)
			  ->where('eventos.fecha_evento','>=',$fecha_ini)
			  ->where('eventos.fecha_evento','<=',$fecha_fin)
			  ->select('eventos.*');
		return $query;
	}


	public function scopeGetEventosAsistencia($query){
		$query->join('users','users.id','=','asistencias.idusers')
			  ->join('users_perfiles','users_perfiles.idusers','=','asistencias.idusers')
			  ->join('eventos','asistencias.ideventos','=','eventos.ideventos')
			  ->where('users_perfiles.idperfiles','=',3)
			  ->select('eventos.nombre','asistencias.asistio','asistencias.idusers');
		return $query;
	}

}