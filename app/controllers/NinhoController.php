<?php

class NinhoController extends BaseController 
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('nav_colegios',$data["permisos"])){
				return View::make('ninhos/home',$data);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_ninho()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_ninho',$data["permisos"])){
				$data["colegios"] = Colegio::lists('nombre','idcolegios');
				return View::make('ninhos/createNinho',$data);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_ninho()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');

			if(in_array('side_nuevo_ninho',$data["permisos"])){

				$attributes = array(
							'dni' => 'Número de documento',
							'nombres' => 'Nombre',
							'apellido_pat' => 'Apellido paterno',
							'apellido_mat' => 'Apellido materno',
							'fecha_nacimiento' => 'Fecha de nacimiento',
							'genero' => 'Género',
							'nombre_apoderado' => 'Nombre de apoderado',
							'dni_apoderado' => 'Número de documento del apoderado',
							'num_familiares' => 'Número de familiares',
							'idcolegios' => 'Colegio',
				);
				$messages = array();
				$rules = array(
							'dni' => 'required|regex:/(^[0-9])/|numeric|digits_between:8,16|unique:ninhos',
							'nombres' => 'required|alpha_spaces|min:2|max:45',
							'apellido_pat' => 'required|alpha_spaces|min:2|max:45',
							'apellido_mat' => 'required|alpha_spaces|min:2|max:45',
							'fecha_nacimiento' => 'required',
							'genero' => 'required',
							'nombre_apoderado' => 'required|alpha_spaces|min:2|max:200',
							'dni_apoderado' => 'required|regex:/(^[0-9])/|numeric|digits_between:8,16',
							'num_familiares' => 'required|numeric|min:0',
							'observaciones' => 'max:200',
							'idcolegios' => 'required',
				);

				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);

				if($validator->fails()){
					return Redirect::to('ninhos/create_ninho')->withErrors($validator)->withInput(Input::all());
				}else{
					$ninho = new Ninho;
					$ninho->dni = Input::get('dni');
					$ninho->nombres = Input::get('nombres');
					$ninho->apellido_pat = Input::get('apellido_pat');
					$ninho->apellido_mat = Input::get('apellido_mat');
					$ninho->fecha_nacimiento = date('Y-m-d H:i:s',strtotime(Input::get('fecha_nacimiento')));
					$ninho->genero = Input::get('genero');
					$ninho->nombre_apoderado = Input::get('nombre_apoderado');
					$ninho->dni_apoderado = Input::get('dni_apoderado');
					$ninho->num_familiares = Input::get('num_familiares');
					$ninho->idcolegios = Input::get('idcolegios');
					$ninho->observaciones = Input::get('observaciones');
					$ninho->save();
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se creó el niño con id {{$ninho->idninhos}}";
					Helpers::registrarLog(3,$descripcion_log);	

					Session::flash('message', 'Se registró correctamente al niño.');
					return Redirect::to('ninhos/create_ninho');
				}
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_ninhos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_ninhos',$data["permisos"])){
				$data["search"] = null;
				$data["ninhos_data"] = Ninho::getNinhosInfo()->paginate(20);
				return View::make('ninhos/listNinhos',$data);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_ninho()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_ninhos',$data["permisos"])){
				$data["search"] = Input::get('search');
				$data["ninhos_data"] = Ninho::searchNinhos($data["search"])->paginate(20);
				return View::make('ninhos/listNinhos',$data);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_ninho($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_ninho',$data["permisos"])) && $id){
				$data["ninho_info"] = Ninho::searchNinhoById($id)->get();
				if($data["ninho_info"]->isEmpty()){
					return Redirect::to('ninhos/list_ninhos');
				}
				$data["ninho_info"] = $data["ninho_info"][0];
				$data["colegios"] = Colegio::orderBy('nombre','asc')->lists('nombre','idcolegios');
				return View::make('ninhos/editNinho',$data);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_ninho()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_ninho',$data["permisos"])){
				$attributes = array(
							'dni' => 'Número de documento',
							'nombres' => 'Nombre',
							'apellido_pat' => 'Apellido paterno',
							'apellido_mat' => 'Apellido materno',
							'fecha_nacimiento' => 'Fecha de nacimiento',
							'genero' => 'Género',
							'nombre_apoderado' => 'Nombre de apoderado',
							'dni_apoderado' => 'Número de documento del apoderado',
							'num_familiares' => 'Número de familiares',
							'idcolegios' => 'Colegio',
				);
				$messages = array();
				$rules = array(
							'dni' => 'required|regex:/(^[0-9])/|numeric|digits_between:8,16',
							'nombres' => 'required|alpha_spaces|min:2|max:45',
							'apellido_pat' => 'required|alpha_spaces|min:2|max:45',
							'apellido_mat' => 'required|alpha_spaces|min:2|max:45',
							'fecha_nacimiento' => 'required',
							'genero' => 'required',
							'nombre_apoderado' => 'required|alpha_spaces|min:2|max:200',
							'dni_apoderado' => 'required|regex:/(^[0-9])/|numeric|digits_between:8,16',
							'num_familiares' => 'required|numeric|min:0',
							'observaciones' => 'max:200',
							'idcolegios' => 'required',
				);
				$ninho_id = Input::get('idninhos');
				$url = "ninhos/edit_ninho"."/".$ninho_id;
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);

				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$ninho = Ninho::find($ninho_id);
					$ninho->dni = Input::get('dni');
					$ninho->nombres = Input::get('nombres');
					$ninho->apellido_pat = Input::get('apellido_pat');
					$ninho->apellido_mat = Input::get('apellido_mat');
					$ninho->fecha_nacimiento = date('Y-m-d H:i:s',strtotime(Input::get('fecha_nacimiento')));
					$ninho->genero = Input::get('genero');
					$ninho->nombre_apoderado = Input::get('nombre_apoderado');
					$ninho->dni_apoderado = Input::get('dni_apoderado');
					$ninho->num_familiares = Input::get('num_familiares');
					$ninho->idcolegios = Input::get('idcolegios');
					$ninho->observaciones = Input::get('observaciones');
					$ninho->save();
					$descripcion_log = "Se editó el niño con id {{$ninho->idninhos}}";
					Helpers::registrarLog(4,$descripcion_log);
					Session::flash('message', 'Se editó correctamente al niño.');
					return Redirect::to($url);
				}
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_disable_ninho()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_ninho',$data["permisos"])){
				$ninho_id = Input::get('ninho_id');
				$url = "ninhos/edit_ninho/".$ninho_id;
				$ninho = Ninho::find($ninho_id);
				$ninho->delete();
				$descripcion_log = "Se eliminó el niño con id {{$ninho_id}}";
				Helpers::registrarLog(5,$descripcion_log);
				Session::flash('message', 'Se inhabilitó correctamente al niño.');
				return Redirect::to($url);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_enable_ninho()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_ninho',$data["permisos"])){
				$ninho_id = Input::get('ninho_id');
				$url = "ninhos/edit_ninho/".$ninho_id;
				$ninho = Ninho::withTrashed()->find($ninho_id);
				$ninho->restore();
				$descripcion_log = "Se habilitó el niño con id {{$ninho_id}}";
				Helpers::registrarLog(6,$descripcion_log);
				Session::flash('message', 'Se habilitó correctamente al niño.');
				return Redirect::to($url);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
	
}