<?php

class ColegiosController extends BaseController
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('nav_colegios',$data["permisos"])){
				return View::make('colegios/home',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_colegio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_colegio',$data["permisos"])){
				return View::make('colegios/createColegio',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_colegio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_colegio',$data["permisos"])){
				// Validate the info, create rules for the inputs

				$rules = array(
							'latitud' => 'required',
							'longitud' => 'required',
							'nombre' => 'required|alpha_spaces|min:2|max:100',
							'direccion' => 'required',
							'nombre_contacto' => 'required|alpha_spaces|min:2|max:100',
							'email_contacto' => 'email|max:45|unique:colegios',
							'telefono_contacto' => 'min:7|max:20',
							'interes' => 'max:100',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('colegios/create_colegio')->withErrors($validator)->withInput(Input::all());
				}else{
					$colegio = new Colegio;
					$colegio->nombre = Input::get('nombre');
					$colegio->direccion = Input::get('direccion');
					$colegio->nombre_contacto = Input::get('nombre_contacto');
					$colegio->email_contacto = Input::get('email_contacto');
					$colegio->telefono_contacto = Input::get('telefono_contacto');
					$colegio->interes = Input::get('interes');
					$colegio->latitud = Input::get('latitud');
					$colegio->longitud = Input::get('longitud');
					$colegio->save();
					$emails = array();
					$emails[] = $colegio->email_contacto;
					Mail::send('emails.colegioRegistration',array('colegio'=> $colegio),function($message) use ($emails,$colegio)
						{
							$message->to($emails)
									->subject('Aprobación de colegio en AFI Perú.');
						});
					Session::flash('message', 'Se registró correctamente al colegio.');
					
					return Redirect::to('colegios/create_colegio');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_colegios()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_colegios',$data["permisos"])){
				$data["search"] = null;
				$data["colegios_data"] = Colegio::getColegiosInfo()->paginate(10);
				return View::make('colegios/listColegios',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_colegio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_colegios',$data["permisos"])){
				$data["search"] = Input::get('search');
				$data["colegios_data"] = Colegio::searchColegios($data["search"])->paginate(10);
				return View::make('colegios/listColegios',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_colegio($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_colegio',$data["permisos"])) && $id){
				$data["colegio_info"] = Colegio::searchColegioById($id)->get();
				if($data["colegio_info"]->isEmpty()){
					Session::flash('error', 'No se encontró al colegio.');
					return Redirect::to('colegios/list_colegios');
				}
				
				$data["colegio_info"] = $data["colegio_info"][0];
				return View::make('colegios/editColegio',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_colegio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_colegio',$data["permisos"])){
				// Validate the info, create rules for the inputs

				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|max:100',
							'direccion' => 'required',
							'nombre_contacto' => 'required|alpha_spaces|min:2|max:100',
							'email_contacto' => 'email|max:45',
							'telefono_contacto' => 'min:7|max:20',
							'interes' => 'max:100',
						);
				// Run the validation rules on the inputs from the form
				
				$colegio_id = Input::get('idcolegios');
				$url = "colegios/edit_colegio"."/".$colegio_id;
				$validator = Validator::make(Input::all(), $rules);
				
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$colegio = Colegio::find($colegio_id);
					$colegio->nombre = Input::get('nombre');
					$colegio->direccion = Input::get('direccion');
					$colegio->nombre_contacto = Input::get('nombre_contacto');
					$colegio->email_contacto = Input::get('email_contacto');
					$colegio->telefono_contacto = Input::get('telefono_contacto');
					$colegio->interes = Input::get('interes');
					$colegio->latitud = Input::get('latitud');
					$colegio->longitud = Input::get('longitud');
					$colegio->save();
					
					Session::flash('message', 'Se editó correctamente al colegio.');
					
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_disable_colegio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_colegio',$data["permisos"])){
				$colegio_id = Input::get('colegio_id');
				$url = "colegios/edit_colegio/".$colegio_id;
				$colegio = Colegio::find($colegio_id);
				$colegio->delete();
				Session::flash('message', 'Se inhabilitó correctamente al colegio.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_enable_colegio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_colegio',$data["permisos"])){
				$colegio_id = Input::get('colegio_id');
				$url = "colegios/edit_colegio/".$colegio_id;
				$colegio = Colegio::withTrashed()->find($colegio_id);
				$colegio->restore();
				Session::flash('message', 'Se habilitó correctamente al colegio.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}


	//Precolegios

	public function list_precolegios()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_aprobar_colegios',$data["permisos"])){
				$data["search"] = null;
				$data["precolegios_data"] = Precolegio::getPreColegiosInfo()->paginate(10);
				return View::make('colegios/listPreColegios',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_precolegio($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_colegio',$data["permisos"])) && $id){
				$data["precolegio_info"] = Precolegio::searchPreColegioById($id)->get();
				if($data["precolegio_info"]->isEmpty()){
					Session::flash('error', 'No se encontró al colegio.');
					return Redirect::to('colegios/list_precolegios');
				}
				$data["precolegio_info"] = $data["precolegio_info"][0];
				//$data["perfiles"] = User::getPerfilesPorUsuario($data["user_info"]->id)->get();
				return View::make('colegios/editPreColegios',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_aprove_precolegio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_colegio',$data["permisos"])){
				$precolegio_id = Input::get('precolegio_id');
				$url = "colegios/edit_precolegio/".$precolegio_id;
				$precolegio = Precolegio::withTrashed()->find($precolegio_id);

				//Se inserta el colegio

				$colegio = new Colegio;
				$colegio->nombre = $precolegio->nombre;
				$colegio->direccion = $precolegio->direccion;
				$colegio->nombre_contacto = $precolegio->nombre_contacto;
				$colegio->email_contacto = $precolegio->email_contacto;
				$colegio->telefono_contacto = $precolegio->telefono_contacto;
				$colegio->interes = $precolegio->interes;
				$colegio->save();
				//Se borra el precolegio				
				$precolegio->delete();
				$emails = array();
				$emails[] = $colegio->email_contacto;
				Mail::send('emails.colegioRegistration',array('colegio'=> $colegio),function($message) use ($emails,$colegio)
					{
						$message->to($emails)
								->subject('Aprobación de colegio en AFI Perú.');
					});

				Session::flash('message', 'Se aprobó correctamente al colegio.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

}