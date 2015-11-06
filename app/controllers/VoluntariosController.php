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
			if(in_array('side_listar_voluntarios',$data["permisos"])){
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

	public function render_view_voluntario($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_listar_voluntarios',$data["permisos"])) && $id){
				$data["user_info"] = User::searchUserById($id)->get();
				if($data["user_info"]->isEmpty()){
					Session::flash('error', 'No se encontró al voluntario.');
					return Redirect::to('voluntario/list_voluntarios');
				}
				$data["user_info"] = $data["user_info"][0];
				$data["perfiles"] = User::getPerfilesPorUsuario($data["user_info"]->id)->get();
				return View::make('voluntarios/viewVoluntario',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_voluntario()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_voluntarios',$data["permisos"])){
				$data["search"] = Input::get('search');
				$data["voluntarios_data"] = UsersPerfil::getVoluntariosInfo($data["search"]);
				return View::make('voluntarios/listVoluntarios',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_repostulacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_mis_eventos',$data["permisos"])){
				$data["user_perfil"] = null;
				$data["periodo_actual"] = null;
				$data["usuario_ya_inscrito"] = true;
				$user_periodo = new UsersPeriodo;
				$user_periodo->idusers = Input::get('user_id');
				$user_periodo->idperiodos = Input::get('idperiodos');
				$user_periodo->save();
				Session::flash('message',"Se ha registrado correctamente su postulación al nuevo período.");
				return Redirect::to('/dashboard');
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}
