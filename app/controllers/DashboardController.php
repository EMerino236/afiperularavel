<?php

class DashboardController extends BaseController
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			$data["periodo_actual"] = Periodo::getPeriodoActual()->get();
			$data["usuario_ya_inscrito"] = true;
			if(!$data["periodo_actual"]->isEmpty()){
				$data["periodo_actual"] = $data["periodo_actual"][0];
				$usuario_ya_existe = UsersPeriodo::getUsersPeriodoByUserXPeriodo($data["user"]->id,$data["periodo_actual"]->idperiodos)->get();				
				if($usuario_ya_existe->isEmpty()){
					$data["usuario_ya_inscrito"] = false;
				}
			}
			else{
				$data["periodo_actual"] = array();
			}
			return View::make('dashboard/dashboard',$data);
		}else{
			return View::make('error/error');
		}
	}
}