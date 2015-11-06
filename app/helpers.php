<?php
class Helpers extends BaseController{
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

	// Función que registra los logs de auditoria
	public static function manejarErrorPermisos()
	{
	    if(Auth::check()){
	    	$descripcion = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
			$log = new LogAuditoria;
			$log->idtipo_logs = 10;
			$log->descripcion = $descripcion;
			$log->users_id = Session::get('user')->id;
			$log->save();
			return Redirect::to('/logout');			
		}else{
			return Redirect::to('/logout');
		}
	}

	// Función que registra los logs de auditoria
	public static function manejarErrorAccesoAnonimo()
	{
	    return View::make('error/error',$data);
	}
}
?>