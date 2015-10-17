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
				$data["perfiles"] = Perfil::getAdminPerfiles()->get();
				return View::make('user/createUser',$data);
			}else{
				return View::make('error/error');
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
				$rules = array(
							'idtipo_identificacion' => 'required',
							'num_documento' => 'required|numeric|digits_between:8,16|unique:users',
							'email' => 'required|email|max:45|unique:users',
							'nombres' => 'required|alpha_spaces|min:2|max:45',
							'apellido_pat' => 'required|alpha_spaces|min:2|max:45',
							'apellido_mat' => 'required|alpha_spaces|min:2|max:45',
							'fecha_nacimiento' => 'required',
							'direccion' => 'required',
							'telefono' => 'min:7|max:20',
							'celular' => 'min:7|max:20',
							'perfiles' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
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
					$user->save();
					// Registro los perfiles seleccionados
					$perfiles = Input::get('perfiles');
					foreach($perfiles as $perfil){
						$users_perfil = new UsersPerfil;
						$users_perfil->idusers = $user->id;
						$users_perfil->idperfiles = $perfil;
						$users_perfil->save();
					}

					Mail::send('emails.userRegistration',array('user'=> $user,'persona'=>$persona,'password'=>$password),function($message) use ($persona)
					{
						$message->to($persona->email, $persona->nombres)
								->subject('Registro de nuevo usuario');
					});
					Session::flash('message', 'Se registró correctamente al usuario.');
					
					return Redirect::to('user/create_user');
				}
			}else{
				return View::make('error/error');
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
				return View::make('error/error');
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
				return View::make('error/error');
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
					return Redirect::to('user/list_user');
				}
				$data["user_info"] = $data["user_info"][0];
				$data["perfiles"] = User::getPerfilesPorUsuario($data["user_info"]->id)->get();
				return View::make('user/editUser',$data);
			}else{
				return View::make('error/error');
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
				Session::flash('message', 'Se inhabilitó correctamente al usuario.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
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
				Session::flash('message', 'Se habilitó correctamente al usuario.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
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
			$rules = array(
						'email' => 'email|max:45|unique:users',
						'nombres' => 'required|alpha_spaces|min:2|max:45',
						'apellido_pat' => 'required|alpha_spaces|min:2|max:45',
						'apellido_mat' => 'required|alpha_spaces|min:2|max:45',
						'direccion' => 'required',
						'telefono' => 'min:7|max:20',
						'celular' => 'min:7|max:20',
						'password' => 'min:8|max:30|confirmed',
						'password_confirmation' => 'min:8|max:30',
					);
			// Run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);
			// If the validator fails, redirect back to the form
			if($validator->fails()){
				return Redirect::to("user/mi_cuenta")->withErrors($validator)->withInput(Input::all());
			}else{

				$persona = Persona::find($data["user"]->idpersona);
				$persona->nombres = Input::get('nombres');
				$persona->apellido_pat = Input::get('apellido_pat');
				$persona->apellido_mat = Input::get('apellido_mat');
				$persona->fecha_nacimiento = date('Y-m-d H:i:s',strtotime(Input::get('fecha_nacimiento')));
				$persona->direccion = Input::get('direccion');
				$persona->telefono = Input::get('telefono');
				$persona->celular = Input::get('celular');
				$persona->latitud = Input::get('latitud');
				$persona->longitud = Input::get('longitud');
				$persona->save();

				$password = Input::get('password');
				$user = User::find($data["user"]->id);
				$user->email = Input::get('email');
				if(!empty($password))
					$user->password = Hash::make($password);
				$user->save();
				Session::flash('message', 'Se editó correctamente la información.');
				return Redirect::to("user/mi_cuenta");
			}
		}else{
			return View::make('error/error');
		}
	}
}