<?php

class EventosController extends BaseController
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('nav_eventos',$data["permisos"])){
				return View::make('eventos/home',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_punto_reunion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_punto_reunion',$data["permisos"])){
				return View::make('eventos/createPuntoReunion',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_punto_reunion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_punto_reunion',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$rules = array(
							'direccion' => 'required|max:100',
							'latitud' => 'required',
							'longitud' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('eventos/create_punto_reunion')->withErrors($validator)->withInput(Input::all());
				}else{
					$punto_reunion = new PuntoReunion;
					$punto_reunion->direccion = Input::get('direccion');
					$punto_reunion->latitud = Input::get('latitud');
					$punto_reunion->longitud = Input::get('longitud');
					$punto_reunion->save();
					Session::flash('message', 'Se registró correctamente el punto de reunión.');
					return Redirect::to('eventos/create_punto_reunion');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_puntos_reunion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_puntos_reunion',$data["permisos"])){
				//$data["puntos_reunion_data"] = PuntoReunion::all();
				return View::make('eventos/listPuntosReunion',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_puntos_reunion_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		$data["permisos"] = Session::get('permisos');
		if(in_array('side_listar_puntos_reunion',$data["permisos"])){
			$puntos_reunion_data = PuntoReunion::all();
			return Response::json(array( 'success' => true,'puntos_reunion'=>$puntos_reunion_data),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_disable_puntos_reunion_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		$data["permisos"] = Session::get('permisos');
		if(in_array('side_nuevo_punto_reunion',$data["permisos"])){
			$eventos_relacionados = PuntoEvento::getEventosPorPunto(Input::get('idpuntos_reunion'))->get();
			if($eventos_relacionados->isEmpty()){
				$punto_reunion = PuntoReunion::find(Input::get('idpuntos_reunion'));
				$punto_reunion->delete();
				return Response::json(array( 'success' => true ),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}