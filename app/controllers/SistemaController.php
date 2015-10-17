<?php

class SistemaController extends BaseController
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('nav_sistema',$data["permisos"])){
				return View::make('sistema/home',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_perfil()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_perfil',$data["permisos"])){
				$data["permisos_data"] = Permiso::all();
				return View::make('sistema/createPerfil',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_perfil()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_perfil',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_spaces|max:45|unique:perfiles',
							'descripcion' => 'required|alpha_spaces|max:45',
							'permisos' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('sistema/create_perfil')->withErrors($validator)->withInput(Input::all());
				}else{
					// Creo primero al perfil
					$perfil = new Perfil;
					$perfil->nombre = Input::get('nombre');
					$perfil->descripcion = Input::get('descripcion');
					$perfil->save();
					// Creo los permisos que tendrá el perfil nuevo
					$permisos = Input::get('permisos');
					foreach($permisos as $permiso){
						$permisos_perfil = new PermisosPerfil;
						$permisos_perfil->idperfiles = $perfil->idperfiles;
						$permisos_perfil->idpermisos = $permiso;
						$permisos_perfil->save();
					}
					Session::flash('message', 'Se registró correctamente el perfil.');
					
					return Redirect::to('sistema/create_perfil');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_perfiles()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_perfiles',$data["permisos"])){
				$data["perfiles_data"] = Perfil::paginate(10);
				return View::make('sistema/listPerfiles',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_perfil($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_perfil',$data["permisos"])) && $id){
				$data["perfil_info"] = Perfil::searchPerfilById($id)->get();
				if($data["perfil_info"]->isEmpty()){
					return Redirect::to('sistema/list_perfiles');
				}
				$data["perfil_info"] = $data["perfil_info"][0];
				$permisos = PermisosPerfil::getPermisosPorPerfil($data["perfil_info"]->idperfiles)->get();
				$data["permisos_data"] = array();
				foreach($permisos as $permiso){
					$data["permisos_data"][] = $permiso->idpermisos;
				}
				return View::make('sistema/editPerfil',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_disable_perfil()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_usuario',$data["permisos"])){
				$idperfiles = Input::get('idperfiles');
				$url = "sistema/edit_perfil/".$idperfiles;
				$users_perfil = UsersPerfil::getUsersPorPerfil($idperfiles);
				if($users_perfil->isEmpty()){
					$perfil = Perfil::find($idperfiles);
					$perfil->delete();
					Session::flash('message', 'Se eliminó correctamente el perfil.');
				}else{
					Session::flash('error', 'No se pudo eliminar el perfil debido a que por lo menos un usuario pertenece a dicho perfil.');
				}
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}
