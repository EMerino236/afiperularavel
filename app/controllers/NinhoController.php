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
							'nombres' => 'required|min:2|max:45',
							'apellido_pat' => 'required|alpha_spaces|min:2|max:45',
							'apellido_mat' => 'required|alpha_spaces|min:2|max:45',
							'fecha_nacimiento' => 'required',
							'genero' => 'required',
							'nombre_apoderado' => 'required|alpha_spaces|min:2|max:200',
							'dni_apoderado' => 'required|numeric|digits_between:8,16',
							'num_familiares' => 'numeric|min:0',
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
				$rules = array(
							'dni' => 'required|numeric|digits_between:8,16',
							'nombres' => 'required|min:2|max:45',
							'apellido_pat' => 'required|alpha_spaces|min:2|max:45',
							'apellido_mat' => 'required|alpha_spaces|min:2|max:45',
							'fecha_nacimiento' => 'required',
							'genero' => 'required',
							'nombre_apoderado' => 'required|alpha_spaces|min:2|max:200',
							'dni_apoderado' => 'required|numeric|digits_between:8,16',
							'num_familiares' => 'numeric|min:0',
							'observaciones' => 'max:200',
							'idcolegios' => 'required',
				);
				$ninho_id = Input::get('idninhos');
				$url = "ninhos/edit_ninho"."/".$ninho_id;
				$validator = Validator::make(Input::all(), $rules);

				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$ninho = Ninho::find($ninho_id);
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
					Session::flash('message', 'Se editó correctamente al niño.');
					return Redirect::to($url);
				}
			}else{
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
				Session::flash('message', 'Se inhabilitó correctamente al niño.');
				return Redirect::to($url);
			}else{
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
				Session::flash('message', 'Se habilitó correctamente al niño.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
	
}