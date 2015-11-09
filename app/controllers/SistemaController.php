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
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				Session::flash('error', 'Usted no tiene permisos para realizar dicha acción.');
				return Redirect::to('/dashboard');
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
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				Session::flash('error', 'Usted no tiene permisos para realizar dicha acción.');
				return Redirect::to('/dashboard');
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
				$attributes = array(
							'nombre' => 'Nombre del Perfil',
							'descripcion' => 'Breve Descripción',
							'permisos' => 'Permisos',
						);
				$messages = array();
				$rules = array(
							'nombre' => 'required|alpha_spaces|max:45|unique:perfiles,nombre,NULL,idperfiles,deleted_at,NULL',
							'descripcion' => 'required|alpha_spaces|max:45',
							'permisos' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
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
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se registró el perfil con id {{$perfil->idperfiles}}";
					Helpers::registrarLog(3,$descripcion_log);
					Session::flash('message', 'Se registró correctamente el perfil.');
					
					return Redirect::to('sistema/create_perfil');
				}
			}else{
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				Session::flash('error', 'Usted no tiene permisos para realizar dicha acción.');
				return Redirect::to('/dashboard');
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
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				Session::flash('error', 'Usted no tiene permisos para realizar dicha acción.');
				return Redirect::to('/dashboard');
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
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				Session::flash('error', 'Usted no tiene permisos para realizar dicha acción.');
				return Redirect::to('/dashboard');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_perfil()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_perfil',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'nombre' => 'Nombre del Perfil',
							'descripcion' => 'Breve Descripción',
							'permisos' => 'Permisos',
						);
				$messages = array();
				$rules = array(
							'nombre' => 'alpha_spaces|max:45|unique:perfiles,nombre,NULL,idperfiles,deleted_at,NULL',
							'descripcion' => 'required|alpha_spaces|max:45',
							'permisos' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$idperfiles = Input::get("idperfiles");
				if($validator->fails()){
					return Redirect::to('sistema/edit_perfil/'.$idperfiles)->withErrors($validator)->withInput(Input::all());
				}else{
					// Creo primero al perfil
					$perfil = Perfil::find($idperfiles);
					if(!empty(Input::get('nombre')))
						$perfil->nombre = Input::get('nombre');
					$perfil->descripcion = Input::get('descripcion');
					$perfil->save();
					// Elimino los permisos anteriores del perfil
					$permisos_perfil_eliminables = PermisosPerfil::getPermisosPorPerfil($idperfiles)->get();
					foreach($permisos_perfil_eliminables as $permiso_perfil_eliminable){
						$p = PermisosPerfil::find($permiso_perfil_eliminable->idpermisos_perfiles);
						$p->delete();
					}
					// Creo los permisos que tendrá el perfil
					$permisos = Input::get('permisos');
					foreach($permisos as $permiso){
						$permisos_perfil = new PermisosPerfil;
						$permisos_perfil->idperfiles = $perfil->idperfiles;
						$permisos_perfil->idpermisos = $permiso;
						$permisos_perfil->save();
					}
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se editó el perfil con id {{$perfil->idperfiles}}";
					Helpers::registrarLog(4,$descripcion_log);
					Session::flash('message', 'Se editó correctamente el perfil.');
					
					return Redirect::to('sistema/edit_perfil/'.$idperfiles);
				}
			}else{
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				Session::flash('error', 'Usted no tiene permisos para realizar dicha acción.');
				return Redirect::to('/dashboard');
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
				$users_perfil = UsersPerfil::getUsersPorPerfil($idperfiles)->get();
				if($users_perfil->isEmpty()){
					$perfil = Perfil::find($idperfiles);
					$perfil->delete();
					Session::flash('message', 'Se eliminó correctamente el perfil.');
				}else{
					Session::flash('error', 'No se pudo eliminar el perfil debido a que por lo menos un usuario pertenece a dicho perfil.');
				}
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se eliminó el perfil con id {{$perfil->idperfiles}}";
				Helpers::registrarLog(5,$descripcion_log);

				Session::flash('message', 'Se eliminó correctamente el perfil.');
				return Redirect::to($url);
			}else{
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				Session::flash('error', 'Usted no tiene permisos para realizar dicha acción.');
				return Redirect::to('/dashboard');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function list_logs()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_reporte_log',$data["permisos"])){
				$data["search"] = null;
				$data["search_tipo_log"] = null;
				$data["fecha_ini"] = null;
				$data["fecha_fin"] = null;
				$data["tipo_logs"] = TipoLog::lists('nombre','idtipo_logs');
				$data["logs"] = LogAuditoria::getLogsInfo()->paginate(30);
				return View::make('sistema/listLogs',$data);
			}else{
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				Session::flash('error', 'Usted no tiene permisos para realizar dicha acción.');
				return Redirect::to('/dashboard');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_logs()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_reporte_log',$data["permisos"])){
				$data["search"] = Input::get('search');
				$data["search_tipo_log"] = Input::get('search_tipo_log');
				$data["fecha_ini"] = Input::get('fecha_ini');
				$data["fecha_fin"] = Input::get('fecha_fin');
				$data["tipo_logs"] = TipoLog::lists('nombre','idtipo_logs');
				$data["logs"] = LogAuditoria::searchLogsInfo($data["search"],$data["search_tipo_log"],$data["fecha_ini"],$data["fecha_fin"])->paginate(30);
				return View::make('sistema/listLogs',$data);
			}else{
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				Session::flash('error', 'Usted no tiene permisos para realizar dicha acción.');
				return Redirect::to('/dashboard');
			}
		}else{
			return View::make('error/error');
		}
	}
}
