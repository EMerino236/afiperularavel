<?php
class HelperController extends BaseController{
	// Función que registra los logs de auditoria
	public static function registrarLog($idtipo_logs,$descripcion)
	{
	    if(Auth::check()){
			$log = new LogAuditoria;
			$log->idtipo_logs = $idtipo_logs;
			$log->descripcion = $descripcion;
			$log->users_id = Session::get('user')->id;
			$log->save();
		}else{
			return View::make('error/error');
		}
	}
}
?>