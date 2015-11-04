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
				$rules = array(
							'dni' => 'required|numeric|digits_between:8,16|unique:ninhos',
							'nombres' => 'required|alpha_spaces|min:2|max:45',
							'apellido_pat' => 'required|alpha_spaces|min:2|max:45',
							'apellido_mat' => 'required|alpha_spaces|min:2|max:45',
							'fecha_nacimiento' => 'required',
							'genero' => 'required',
							'nombre_apoderado' => 'required|alpha_spaces|min:2|max:200',
							'dni_apoderado' => 'required|numeric|digits_between:8,16',
							'num_familiares' => 'numeric|min:1',
							'observaciones' => 'max:200',
							'idcolegios' => 'required',
				);

				$validator = Validator::make(Input::all(), $rules);

				if($validator->fails()){
					return Redirect::to('ninhos/create_ninho')->withErrors($validator)->withInput(Input::all());
				}else{
					$ninho = new Ninho;
					$ninho->dni = Input::get('dni');
					$ninho->nombres = Input::get('nombres');
					$ninho->apellido_pat = Input::get('apellido_pat');
					$ninho->apellido_mat = Input::get('apellido_mat');
					$ninho->fecha_nacimiento = Input::get('fecha_nacimiento');
					$ninho->genero = Input::get('genero');
					$ninho->nombre_apoderado = Input::get('nombre_apoderado');
					$ninho->dni_apoderado = Input::get('dni_apoderado');
					$ninho->num_familiares = Input::get('num_familiares');
					$ninho->idcolegios = Input::get('idcolegios');
					$ninho->observaciones = Input::get('observaciones');
					$ninho->save();
					Session::flash('message', 'Se registró correctamente al niño.');
					return Redirect::to('ninhos/create_ninho');
				}
			}else{
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
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

/*	public function render_edit_ninho($id=null)
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
	}*/

	
}