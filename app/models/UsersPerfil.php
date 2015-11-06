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
				  where users_perfiles.idperfiles = 3';
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
				  		and (periodos.nombre LIKE \'%'.$search.'%\'
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

}