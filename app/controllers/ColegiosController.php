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
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
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
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
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
				$attributes = array(
							'nombre' => 'Nombre',
							'direccion' => 'Dirección',
							'nombre_contacto' => 'Nombre de contacto',
							'email_contacto' => 'Email de contacto',
							'telefono_contacto' => 'Teléfono de contacto',
							'interes' => 'interés',
						);
				$messages = array();
				$rules = array(
							'latitud' => 'required|',
							'longitud' => 'required',
							'nombre' => 'required|min:2|max:100|alpha_num_dash',	
							'direccion' => 'required|direction|max:200',
							'nombre_contacto' => 'required|alpha_spaces|min:2|max:100',
							'email_contacto' => 'required|email|max:45',
							'telefono_contacto' => 'required|numeric|digits_between:7,20',
							'interes' => 'required|max:100',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
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
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se creó el colegio con id {{$colegio->idcolegios}}";
					Helpers::registrarLog(3,$descripcion_log);
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
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
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
				$sortby = Input::get('sortby');
			    $order = Input::get('order');
			    $data["sortby"] = $sortby;
			    $data["order"] = $order;

			    if ($sortby && $order){
			    	$data["colegios_data"] = Colegio::getColegiosInfo()->orderBy($sortby, $order)->paginate(10);
			    }else{
			    	$data["colegios_data"] = Colegio::getColegiosInfo()->paginate(10);
			    }
			    
				return View::make('colegios/listColegios',$data);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
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
				$sortby = Input::get('sortby');
			    $order = Input::get('order');
			    $data["sortby"] = $sortby;
			    $data["order"] = $order;
			    if ($sortby && $order) {
			    	$data["colegios_data"] = Colegio::searchColegios($data["search"])->orderBy($sortby, $order)->paginate(10);
			    }else{
			    	$data["colegios_data"] = Colegio::searchColegios($data["search"])->paginate(10);
			    }
				return View::make('colegios/listColegios',$data);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
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
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
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
				$attributes = array(
							'nombre' => 'Nombre',
							'direccion' => 'Dirección',
							'nombre_contacto' => 'Nombre de contacto',
							'email_contacto' => 'Email de contacto',
							'telefono_contacto' => 'Teléfono de contacto',
							'interes' => 'interés',
						);
				$messages = array();
				$rules = array(
							'latitud' => 'required',
							'longitud' => 'required',
							'nombre' => 'required|min:2|max:100|alpha_num_dash',
							'direccion' => 'required|max:200',
							'nombre_contacto' => 'required|alpha_spaces|min:2|max:100',
							'email_contacto' => 'required|email|max:45',
							'telefono_contacto' => 'required|numeric|digits_between:7,20',
							'interes' => 'required|max:100',
						);
				
				$colegio_id = Input::get('idcolegios');
				$url = "colegios/edit_colegio"."/".$colegio_id;
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				
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
					$descripcion_log = "Se editó el colegio con id {{$colegio->idcolegios}}";
					Helpers::registrarLog(4,$descripcion_log);
					
					Session::flash('message', 'Se editó correctamente al colegio.');
					
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
				$descripcion_log = "Se eliminó el colegio con id {{$colegio_id}}";
				Helpers::registrarLog(5,$descripcion_log);
				Session::flash('message', 'Se inhabilitó correctamente al colegio.');
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
				$descripcion_log = "Se habilitó el colegio con id {{$colegio_id}}";
				Helpers::registrarLog(6,$descripcion_log);
				Session::flash('message', 'Se habilitó correctamente al colegio.');
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
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
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
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
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
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

}