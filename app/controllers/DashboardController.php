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
			if(in_array('side_aprobar_padrinos',$data["permisos"])){
				$data["prepadrinos"] = Prepadrino::all()->count();
			}
			if(in_array('side_listar_convocatorias',$data["permisos"])){
				$periodo_actual = Periodo::getPeriodoActual()->get();
				if($periodo_actual->isEmpty()){
					$data["postulantes"] = 0;
					$data["idperiodos"] = null;
				}else{
					$aprobacion = null;
					$periodo_actual = $periodo_actual[0];
					$data["postulantes"] = PostulantesPeriodo::getPostulantesPorPeriodoFase($periodo_actual->idperiodos,1,$aprobacion)->get()->count();
					$data["idperiodos"] = $periodo_actual->idperiodos;
				}
			}
			if(in_array('side_aprobar_colegios',$data["permisos"])){
				$data["precolegios"] = Precolegio::all()->count();
			}
			if(in_array('side_listar_usuarios',$data["permisos"])){
				$data["usuarios"] = USer::all()->count();
			}

			return View::make('dashboard/dashboard',$data);
		}else{
			return View::make('error/error');
		}
	}
}