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
			  ->orderBy('idlogs','desc')
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','users.num_documento','users.email','tipo_logs.nombre as tipo_log','logs.*');
		return $query;
	}

	public function scopeSearchLogsInfo($query,$search,$search_tipo_log,$fecha_ini,$fecha_fin)
	{
		$query->join('users','users.id','=','logs.users_id')
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->join('tipo_logs','tipo_logs.idtipo_logs','=','logs.idtipo_logs')
			  ->whereNested(function($query) use($search){
			  		$query->where('users.num_documento','LIKE',"%$search%")
			  			  ->orWhere('users.email','LIKE',"%$search%")
			  			  ->orWhere('personas.nombres','LIKE',"%$search%")
			  			  ->orWhere('personas.apellido_pat','LIKE',"%$search%")
			  			  ->orWhere('personas.apellido_mat','LIKE',"%$search%")
			  			  ->orWhere('logs.descripcion','LIKE',"%$search%");
			  });
		if($search_tipo_log != "0")
			$query->where('logs.idtipo_logs','=',$search_tipo_log);
		if($fecha_ini != "")
			$query->where('logs.created_at','>=',date('Y-m-d H:i:s',strtotime($fecha_ini)));
		if($fecha_fin != "")
			$query->where('logs.created_at','<=',date('Y-m-d H:i:s',strtotime($fecha_fin)));
		$query->orderBy('idlogs','desc')
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','users.num_documento','users.email','tipo_logs.nombre as tipo_log','logs.*');
		return $query;
	}

}