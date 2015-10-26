<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	use SoftDeletingTrait;	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	protected $softDelete = true;

	public function scopeGetPermisosPorUsuario($query,$id)
	{
		$null = null;
		$query->join('users_perfiles','users_perfiles.idusers','=','users.id')
			  ->join('perfiles','perfiles.idperfiles','=','users_perfiles.idperfiles')
			  ->join('permisos_perfiles','permisos_perfiles.idperfiles','=','perfiles.idperfiles')
			  ->join('permisos','permisos.idpermisos','=','permisos_perfiles.idpermisos')
			  ->where('users.id','=',$id)
			  ->where('permisos_perfiles.deleted_at','=',$null)
			  ->select('permisos.nombre');
		return $query;
	}

	public function scopeGetPermisosPorUsuarioId($query,$id)
	{
		$null = null;
		$query->join('users_perfiles','users_perfiles.idusers','=','users.id')
			  ->join('perfiles','perfiles.idperfiles','=','users_perfiles.idperfiles')
			  ->join('permisos_perfiles','permisos_perfiles.idperfiles','=','perfiles.idperfiles')
			  ->join('permisos','permisos.idpermisos','=','permisos_perfiles.idpermisos')
			  ->where('users.id','=',$id)
			  ->where('permisos_perfiles.deleted_at','=',$null)
			  ->select('permisos.idpermisos');
		return $query;
	}

	public function scopeGetUsersInfo($query)
	{
		$query->withTrashed()
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','users.*');
		return $query;
	}

	public function scopeSearchUsers($query,$search_criteria)
	{
		$query->withTrashed()
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('users.num_documento','LIKE',"%$search_criteria%")
			  			  ->orWhere('users.email','LIKE',"%$search_criteria%")
			  			  ->orWhere('personas.nombres','LIKE',"%$search_criteria%")
			  			  ->orWhere('personas.apellido_pat','LIKE',"%$search_criteria%")
			  			  ->orWhere('personas.apellido_mat','LIKE',"%$search_criteria%");
			  })
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','users.*');
		return $query;
	}

	public function scopeSearchUserById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->join('tipo_identificacion','tipo_identificacion.idtipo_identificacion','=','users.idtipo_identificacion')
			  ->where('users.id','=',$search_criteria)
			  ->select('tipo_identificacion.nombre as nombre_tipo_identificacion','personas.*','users.*');
		return $query;
	}

	public function scopeGetPerfilesPorUsuario($query,$id)
	{
		$null = null;
		$query->join('users_perfiles','users_perfiles.idusers','=','users.id')
			  ->join('perfiles','perfiles.idperfiles','=','users_perfiles.idperfiles')
			  ->where('users.id','=',$id)
			  ->where('users_perfiles.deleted_at','=',$null)
			  ->select('perfiles.nombre');
		return $query;
	}
    
    public function scopeGetPerfilesPorUsuario2($query,$id)
	{
		$null = null;
		$query->join('users_perfiles','users_perfiles.idusers','=','users.id')
			  ->join('perfiles','perfiles.idperfiles','=','users_perfiles.idperfiles')
			  ->where('users.id','=',$id)
			  ->where('users_perfiles.deleted_at','=',$null)
			  ->select('perfiles.idperfiles','perfiles.nombre');
		return $query;
	}

	public function scopeSearchUserByDocumentNumber($query,$search_criteria)
	{
		$query->withTrashed()
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->join('tipo_identificacion','tipo_identificacion.idtipo_identificacion','=','users.idtipo_identificacion')
			  ->where('users.num_documento','=',$search_criteria)
			  ->select('tipo_identificacion.nombre as nombre_tipo_identificacion','personas.*','users.*');
		return $query;
	}

}
