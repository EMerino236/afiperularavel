<?php

class VoluntariosController extends BaseController
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('nav_voluntarios',$data["permisos"])){
				return View::make('voluntarios/home',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function list_Voluntarios()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('nav_voluntarios',$data["permisos"])){
				$data["search"] = null;
				$data["voluntarios_data"] = UsersPerfil::getVoluntariosInfo();
				return View::make('voluntarios/listVoluntarios',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}
