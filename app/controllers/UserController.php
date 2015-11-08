<?php

class UserController extends BaseController {

	public function render_create_user()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_usuario',$data["permisos"])){
				$data["tipos_identificacion"] = TipoIdentificacion::lists('nombre','idtipo_identificacion');
				$data["perfiles"] = Perfil::getPerfilesCreacion()->get();	
				return View::make('user/createUser',$data);
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

	public function submit_create_user()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_usuario',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'idtipo_identificacion' => 'Tipo de identificación',
							'num_documento' => 'Número de Documento',
							'email' => 'E-mail',
							'nombres' => 'Nombres',
							'apellido_pat' => 'Apellido Paterno',
							'apellido_mat' => 'Apellido Materno',
							'fecha_nacimiento' => 'Fecha de nacimiento',
							'direccion' => 'Dirección',
							'telefono' => 'Teléfono',
							'celular' => 'Celular',
							'perfiles' => 'Perfil',
						);
				$messages = array();
				$rules = array(
							'idtipo_identificacion' => 'required',
							'num_documento' => 'required|numeric|digits_between:8,16|unique:users',
							'email' => 'required|email|max:100|unique:users',
							'nombres' => 'required|alpha_spaces|min:2|max:100',
							'apellido_pat' => 'required|alpha_spaces|min:2|max:100',
							'apellido_mat' => 'required|alpha_spaces|min:2|max:100',
							'fecha_nacimiento' => 'required',
							'direccion' => 'required|max:150',
							'telefono' => 'numeric|digits_between:7,20',
							'celular' => 'numeric|digits_between:7,20',
							'perfiles' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('user/create_user')->withErrors($validator)->withInput(Input::all());
				}else{
					// Creo primero a la persona
					$persona = new Persona;
					$persona->nombres = Input::get('nombres');
					$persona->apellido_pat = Input::get('apellido_pat');
					$persona->apellido_mat = Input::get('apellido_mat');
					$persona->fecha_nacimiento = date('Y-m-d H:i:s',strtotime(Input::get('fecha_nacimiento')));
					$persona->direccion = Input::get('direccion');
					$persona->telefono = Input::get('telefono');
					$persona->celular = Input::get('celular');
					$persona->save();
					// Creo al usuario y le asigno su información de persona
					$password = Str::random(8);
					$user = new User;
					$user->num_documento = Input::get('num_documento');
					$user->password = Hash::make($password);
					$user->idtipo_identificacion = Input::get('idtipo_identificacion');
					$user->email = Input::get('email');
					$user->idpersona = $persona->idpersonas;
					$user->auth_token = Str::random(32);
					$user->save();
					// Registro los perfiles seleccionados
					$perfiles = Input::get('perfiles');
					foreach($perfiles as $perfil){
						$users_perfil = new UsersPerfil;
						$users_perfil->idusers = $user->id;
						$users_perfil->idperfiles = $perfil;
						$users_perfil->save();
					}

					Mail::send('emails.userRegistration',array('user'=> $user,'persona'=>$persona,'password'=>$password),function($message) use ($user,$persona)
					{
						$message->to($user->email, $persona->nombres)
								->subject('Registro de nuevo usuario');
					});
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se creó al usuario con id {{$user->id}}";
					Helpers::registrarLog(3,$descripcion_log);

					Session::flash('message', 'Se registró correctamente al usuario.');
					return Redirect::to('user/create_user');
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

	public function list_users()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_usuarios',$data["permisos"])){
				$data["search"] = null;
				$data["users_data"] = User::getUsersInfo()->paginate(10);
				return View::make('user/listUsers',$data);
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

	public function search_user()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_usuarios',$data["permisos"])){
				$data["search"] = Input::get('search');
				$data["users_data"] = User::searchUsers($data["search"])->paginate(10);
				return View::make('user/listUsers',$data);
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

	public function render_edit_user($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_usuario',$data["permisos"])) && $id){
				$data["user_info"] = User::searchUserById($id)->get();
				if($data["user_info"]->isEmpty()){
					Session::flash('error', 'No se encontró al usuario.');
					return Redirect::to('user/list_user');
				}
				$data["user_info"] = $data["user_info"][0];
				$data["tipos_identificacion"] = TipoIdentificacion::lists('nombre','idtipo_identificacion');
				$data["perfiles_usuario"] = User::getPerfilesPorUsuario($data["user_info"]->id)->get()->toArray();				
				$data["perfiles"] = Perfil::getPerfilesCreacion()->get();	
				return View::make('user/editUser',$data);
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

	public function submit_edit_user()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_usuario',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'idtipo_identificacion' => 'Tipo de identificación',
							'num_documento' => 'Número de Documento',
							'email' => 'E-mail',
							'nombres' => 'Nombres',
							'apellido_pat' => 'Apellido Paterno',
							'apellido_mat' => 'Apellido Materno',
							'direccion' => 'Dirección',
							'telefono' => 'Teléfono',
							'celular' => 'Celular',
						);
				$messages = array();
				$rules = array(
							'idtipo_identificacion' => 'required',
							'num_documento' => 'numeric|digits_between:8,16|unique:users',
							'email' => 'email|max:100|unique:users',
							'nombres' => 'required|alpha_spaces|min:2|max:100',
							'apellido_pat' => 'required|alpha_spaces|min:2|max:100',
							'apellido_mat' => 'required|alpha_spaces|min:2|max:100',
							'direccion' => 'required|max:150',
							'telefono' => 'numeric|digits_between:7,20',
							'celular' => 'numeric|digits_between:7,20',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$user_id = Input::get('user_id');
				if($validator->fails()){
					return Redirect::to("user/edit_user/".$user_id)->withErrors($validator)->withInput(Input::all());
				}else{
					$password = Input::get('password');
					$user = User::find($user_id);
					if(!empty(Input::get('email')))
						$user->email = Input::get('email');
					if(!empty($password))
						$user->password = Hash::make($password);
					if(!empty(Input::get('num_documento')))
						$user->num_documento = Input::get('num_documento');
					$user->idtipo_identificacion = Input::get('idtipo_identificacion');
					$user->save();

					$persona = Persona::find($user->idpersona);
					$persona->nombres = Input::get('nombres');
					$persona->apellido_pat = Input::get('apellido_pat');
					$persona->apellido_mat = Input::get('apellido_mat');
					if(!empty(Input::get('fecha_nacimiento')))
						$persona->fecha_nacimiento = date('Y-m-d H:i:s',strtotime(Input::get('fecha_nacimiento')));
					$persona->direccion = Input::get('direccion');
					$persona->telefono = Input::get('telefono');
					$persona->celular = Input::get('celular');
					$persona->latitud = Input::get('latitud');
					$persona->longitud = Input::get('longitud');
					$persona->save();

					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se editó el usuario con id {{$user->id}}";
					Helpers::registrarLog(4,$descripcion_log);
					Session::flash('message', 'Se editó correctamente la información.');
					return Redirect::to("user/edit_user/".$user_id);
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

	public function submit_disable_user()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_usuario',$data["permisos"])){
				$user_id = Input::get('user_id');
				$url = "user/edit_user/".$user_id;
				$user = User::find($user_id);
				$user->delete();
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se inhabilitó al usuario con id {{$user_id}}";
				Helpers::registrarLog(5,$descripcion_log);
				Session::flash('message', 'Se inhabilitó correctamente al usuario.');
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

	public function submit_enable_user()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_usuario',$data["permisos"])){
				$user_id = Input::get('user_id');
				$url = "user/edit_user/".$user_id;
				$user = User::withTrashed()->find($user_id);
				$user->restore();
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se habilitó al usuario con id {{$user_id}}";
				Helpers::registrarLog(6,$descripcion_log);
				Session::flash('message', 'Se habilitó correctamente al usuario.');
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

	public function render_mi_cuenta()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			$data["user_info"] = User::searchUserById($data["user"]->id)->get();
			if($data["user_info"]->isEmpty()){
				return Redirect::to('user/list_user');
			}
			$data["user_info"] = $data["user_info"][0];
			$data["tipos_identificacion"] = TipoIdentificacion::lists('nombre','idtipo_identificacion');
			$data["perfiles"] = User::getPerfilesPorUsuario($data["user_info"]->id)->get();
			return View::make('user/editMyUser',$data);
		}else{
			return View::make('error/error');
		}
	}

	public function submit_mi_cuenta()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Validate the info, create rules for the inputs
			$attributes = array(
						'idtipo_identificacion' => 'Tipo de identificación',
						'num_documento' => 'Número de Documento',
						'email' => 'E-mail',
						'nombres' => 'Nombres',
						'apellido_pat' => 'Apellido Paterno',
						'apellido_mat' => 'Apellido Materno',
						'fecha_nacimiento' => 'Fecha de nacimiento',
						'direccion' => 'Dirección',
						'telefono' => 'Teléfono',
						'celular' => 'Celular',
					);
			$messages = array();
			$rules = array(
						'idtipo_identificacion' => 'required',
						'num_documento' => 'numeric|digits_between:8,16|unique:users',
						'email' => 'required|email|max:100|unique:users',
						'nombres' => 'required|alpha_spaces|min:2|max:100',
						'apellido_pat' => 'required|alpha_spaces|min:2|max:100',
						'apellido_mat' => 'required|alpha_spaces|min:2|max:100',
						'fecha_nacimiento' => 'required',
						'direccion' => 'required|max:150',
						'telefono' => 'numeric|digits_between:7,20',
						'celular' => 'numeric|digits_between:7,20',
					);
			// Run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
			// If the validator fails, redirect back to the form
			if($validator->fails()){
				return Redirect::to("user/mi_cuenta")->withErrors($validator)->withInput(Input::all());
			}else{
				$persona = Persona::find($data["user"]->idpersona);
				$persona->nombres = Input::get('nombres');
				$persona->apellido_pat = Input::get('apellido_pat');
				$persona->apellido_mat = Input::get('apellido_mat');
				if(!empty(Input::get('fecha_nacimiento')))
					$persona->fecha_nacimiento = date('Y-m-d H:i:s',strtotime(Input::get('fecha_nacimiento')));
				$persona->direccion = Input::get('direccion');
				$persona->telefono = Input::get('telefono');
				$persona->celular = Input::get('celular');
				$persona->latitud = Input::get('latitud');
				$persona->longitud = Input::get('longitud');
				$persona->save();

				$password = Input::get('password');
				$user = User::find($data["user"]->id);
				if(!empty(Input::get('email')))
					$user->email = Input::get('email');
				if(!empty($password))
					$user->password = Hash::make($password);
				if(!empty(Input::get('num_documento')))
					$user->num_documento = Input::get('num_documento');
				$user->idtipo_identificacion = Input::get('idtipo_identificacion');
				$user->save();
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Editó su información de usuario";
				Helpers::registrarLog(4,$descripcion_log);
				Session::flash('message', 'Se editó correctamente la información.');
				return Redirect::to("user/mi_cuenta");
			}
		}else{
			return View::make('error/error');
		}
	}
}