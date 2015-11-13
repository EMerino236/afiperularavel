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

	public function scopeGetVoluntariosInfo($query)
	{
		$sql = 'select users.*, periodos.nombre as nombre_periodo, personas.nombres as nombre_persona, personas.apellido_pat,
				  personas.apellido_mat, personas.direccion, personas.telefono, personas.celular
				  from users join users_perfiles on users_perfiles.idusers = users.id
				  			 join users_periodos on users_periodos.idusers = users.id
				  			 join periodos on users_periodos.idperiodos = periodos.idperiodos
				  			 join personas on personas.idpersonas = users.idpersona
				  where users_perfiles.idperfiles = 3
				  		and users_perfiles.deleted_at is NULL';
		$query = DB::select(DB::raw($sql));
		return $query;
	}

	public function scopeGetVoluntariosByIdPeriodo($query,$idperiodo)
	{
		$sql = 'select users.*, periodos.nombre as nombre_periodo, personas.nombres as nombre_persona, personas.apellido_pat,
				  personas.apellido_mat, personas.direccion, personas.telefono, personas.celular
				  from users join users_perfiles on users_perfiles.idusers = users.id
				  			 join users_periodos on users_periodos.idusers = users.id
				  			 join periodos on users_periodos.idperiodos = periodos.idperiodos
				  			 join personas on personas.idpersonas = users.idpersona
				  where users_perfiles.idperfiles = 3
				  		and users_perfiles.deleted_at is NULL
				  		and users_periodos.deleted_at is NULL
				  		and users_periodos.idperiodos = '.$idperiodo;
		$query = DB::select(DB::raw($sql));
		return $query;
	}

	public function scopeSearchVoluntariosInfo($query,$search)
	{
		$sql = 'select users.*, periodos.nombre as nombre_periodo, personas.nombres as nombre_persona, personas.apellido_pat,
				  personas.apellido_mat, personas.direccion, personas.telefono, personas.celular
				  from users join users_perfiles on users_perfiles.idusers = users.id
				  			 join users_periodos on users_periodos.idusers = users.id
				  			 join periodos on users_periodos.idperiodos = periodos.idperiodos
				  			 join personas on personas.idpersonas = users.idpersona
				  where users_perfiles.idperfiles = 3
				  		and users_perfiles.deleted_at is NULL
				  		and (users.num_documento LIKE \'%'.$search.'%\'
				  			 or periodos.nombre LIKE \'%'.$search.'%\'
				  			 or personas.nombres LIKE \'%'.$search.'%\'
				  			 or personas.apellido_pat LIKE \'%'.$search.'%\'
				  			 or personas.apellido_mat LIKE \'%'.$search.'%\'
				  			 )
				  		';
		$query = DB::select(DB::raw($sql));
		return $query;
	}

	public function scopeGetUsersPerfilByIdUserByIdPerfil($query,$iduser,$idperfil)
	{
		$query->where('idusers','=',$iduser)
			  ->where('idperfiles','=',$idperfil);
		return $query;
	}

	public function scopeSearchVoluntariosInfoByIdPeriodo($query,$idperiodo,$search)
	{
		$sql = 'select users.*, periodos.nombre as nombre_periodo, personas.nombres as nombre_persona, personas.apellido_pat,
				  personas.apellido_mat, personas.direccion, personas.telefono, personas.celular
				  from users join users_perfiles on users_perfiles.idusers = users.id
				  			 join users_periodos on users_periodos.idusers = users.id
				  			 join periodos on users_periodos.idperiodos = periodos.idperiodos
				  			 join personas on personas.idpersonas = users.idpersona
				  where users_perfiles.idperfiles = 3
				  		and users_periodos.idperiodos = '.$idperiodo. '
				  		and users_perfiles.deleted_at is NULL
				  		and (users.num_documento LIKE \'%'.$search.'%\'
				  			 or personas.nombres LIKE \'%'.$search.'%\'
				  			 or personas.apellido_pat LIKE \'%'.$search.'%\'
				  			 or personas.apellido_mat LIKE \'%'.$search.'%\'
				  			 )
				  		';
		$query = DB::select(DB::raw($sql));
		return $query;
	}

	public function scopeGetVoluntariosReporteInfo($query)
	{
		$sql = 'select users.id, users.num_documento, users.email,users.deleted_at,periodos.nombre as nombre_periodo, personas.nombres as nombre_persona, personas.apellido_pat,
				  personas.apellido_mat, personas.direccion, personas.telefono, personas.celular, avg(asistencias.calificacion) as prom_calificaciones
				  from users join users_perfiles on users_perfiles.idusers = users.id
				  			 join users_periodos on users_periodos.idusers = users.id
				  			 join periodos on users_periodos.idperiodos = periodos.idperiodos
				  			 join personas on personas.idpersonas = users.idpersona
				  			 join asistencias on asistencias.idusers = users.id
				  where users_perfiles.idperfiles = 3
				  		and users_perfiles.deleted_at is NULL
				  group by  users.id, users.num_documento, users.email,users.deleted_at, periodos.nombre, personas.nombres, personas.apellido_pat,
				  			personas.apellido_mat, personas.direccion, personas.telefono, personas.celular';
		$query = DB::select(DB::raw($sql));
		return $query;
	}

	public function scopeSearchVoluntariosReporteInfo($query,$search_periodo,$search_usuario)
	{
		$sql = 'select users.id, users.num_documento, users.email,users.deleted_at,periodos.nombre as nombre_periodo, personas.nombres as nombre_persona, personas.apellido_pat,
				  personas.apellido_mat, personas.direccion, personas.telefono, personas.celular, avg(asistencias.calificacion) as prom_calificaciones
				  from users join users_perfiles on users_perfiles.idusers = users.id
				  			 join users_periodos on users_periodos.idusers = users.id
				  			 join periodos on users_periodos.idperiodos = periodos.idperiodos
				  			 join personas on personas.idpersonas = users.idpersona
				  			 join asistencias on asistencias.idusers = users.id
				  where users_perfiles.idperfiles = 3
				  		and users_perfiles.deleted_at is NULL
				  		and (periodos.idperiodos = '.$search_periodo.' or '.$search_periodo.' = 0)
				  		and (users.num_documento LIKE \'%'.$search_usuario.'%\'
				  			 or personas.nombres LIKE \'%'.$search_usuario.'%\'
				  			 or personas.apellido_pat LIKE \'%'.$search_usuario.'%\'
				  			 or personas.apellido_mat LIKE \'%'.$search_usuario.'%\'
				  			 )
				  group by  users.id, users.num_documento, users.email,users.deleted_at, periodos.nombre, personas.nombres, personas.apellido_pat,
				  			personas.apellido_mat, personas.direccion, personas.telefono, personas.celular';
		$query = DB::select(DB::raw($sql));
		return $query;
	}


}