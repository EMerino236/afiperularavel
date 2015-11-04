<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class LogAuditoria extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'logs';
	protected $primaryKey = 'idlogs';

	public function scopeGetLogsInfo($query)
	{
		$query->join('users','users.id','=','logs.users_id')
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->join('tipo_logs','tipo_logs.idtipo_logs','=','logs.idtipo_logs')
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','users.num_documento','users.email','tipo_logs.nombre as tipo_log','logs.*');
		return $query;
	}

}