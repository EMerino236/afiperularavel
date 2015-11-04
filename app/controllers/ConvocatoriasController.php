<?php

class ConvocatoriasController extends BaseController
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('nav_convocatorias',$data["permisos"])){
				return View::make('convocatorias/home',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_convocatoria()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nueva_convocatoria',$data["permisos"])){
				return View::make('convocatorias/createConvocatoria',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_convocatoria()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nueva_convocatoria',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|min:2|max:45|unique:periodos',
							'fecha_inicio' => 'required',
							'fecha_fin' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('convocatorias/create_convocatoria')->withErrors($validator)->withInput(Input::all());
				}else{
					// Creo primero a la persona
					$fecha_inicio = date('Y-m-d H:i:s',strtotime(Input::get('fecha_inicio')));
					$fecha_fin = date('Y-m-d H:i:s',strtotime(Input::get('fecha_fin')));
					if($fecha_inicio < $fecha_fin){
						$convocatoria = new Periodo;
						$convocatoria->nombre = Input::get('nombre');
						$convocatoria->fecha_inicio = $fecha_inicio;
						$convocatoria->fecha_fin = $fecha_fin;
						$convocatoria->save();
						Session::flash('message', 'Se registró correctamente la convocatoria.');
						
						return Redirect::to('convocatorias/create_convocatoria');
					}
					else{
						Session::flash('error', 'La Fecha de Inicio debe ser menor a la Fecha Fin.');
						return Redirect::to('convocatorias/create_convocatoria')->withInput(Input::all());
					}
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_convocatorias()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_convocatorias',$data["permisos"])){
				$data["search"] = null;
				$data["convocatorias_data"] = Periodo::getPeriodosInfo()->paginate(10);
				return View::make('convocatorias/listConvocatorias',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_convocatorias()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_convocatorias',$data["permisos"])){
				$data["search"] = Input::get('search');
				$data["convocatorias_data"] = Periodo::searchPeriodos($data["search"])->paginate(10);
				return View::make('convocatorias/listConvocatorias',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_convocatoria($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nueva_convocatoria',$data["permisos"])) && $id){
				$data["convocatoria_info"] = Periodo::searchPeriodoById($id)->get();
				if($data["convocatoria_info"]->isEmpty()){
					Session::flash('error', 'No se encontró la convocatoria.');
					return Redirect::to('convocatorias/list_convocatoria');
				}
				$data["convocatoria_info"] = $data["convocatoria_info"][0];
				return View::make('convocatorias/editConvocatoria',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_convocatoria()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nueva_convocatoria',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_dash|min:2|max:45',
							'fecha_inicio' => 'required',
							'fecha_fin' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$convocatoria_id = Input::get('convocatoria_id');
				$url = "convocatorias/edit_convocatoria"."/".$convocatoria_id;
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$fecha_inicio = date('Y-m-d H:i:s',strtotime(Input::get('fecha_inicio')));
					$fecha_fin = date('Y-m-d H:i:s',strtotime(Input::get('fecha_fin')));
					if($fecha_inicio < $fecha_fin){
						$convocatoria = Periodo::find($convocatoria_id);
						$convocatoria->nombre = Input::get('nombre');
						$convocatoria->fecha_inicio = $fecha_inicio;
						$convocatoria->fecha_fin = $fecha_fin;
						$convocatoria->save();
						Session::flash('message', 'Se editó correctamente la convocatoria.');
						
						return Redirect::to($url);
					}
					else{
						Session::flash('error', 'La Fecha de Inicio debe ser menor a la Fecha Fin.');
						return Redirect::to($url)->withInput(Input::all());
					}
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_postulantes($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nueva_convocatoria',$data["permisos"])){
				$data["fases_postulacion"] = Fase::lists('nombre','idfases');
				$data["convocatoria_info"] = Periodo::searchPeriodoById($id)->get();
				$data["convocatoria_info"] = $data["convocatoria_info"][0];	
				$data["idfase"] = null;			
				$data["postulantes_info"] = array();
				return View::make('convocatorias/listPostulantes',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_postulantes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nueva_convocatoria',$data["permisos"])){
				$data["fases_postulacion"] = Fase::lists('nombre','idfases');
				$data["convocatoria_info"] = Periodo::searchPeriodoById(Input::get('idperiodos'))->get();
				$data["convocatoria_info"] = $data["convocatoria_info"][0];
				$data["idfase"] = Input::get('idfases');
				$data["postulantes_info"] = PostulantesPeriodo::getPostulantesPorPeriodoFase(Input::get('idperiodos'),Input::get('idfases'))->paginate(10);				
				return View::make('convocatorias/listPostulantes',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_aprobacion_postulantes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nueva_convocatoria',$data["permisos"])){
				$idpostulantes_periodos = Input::get('idpostulantes_periodos');
				$idperiodos = Input::get('idperiodos');
				$idfase = Input::get('idfase');
				$comentarios = Input::get('comentarios');
				$asistencias = Input::get('asistencias');
				$aprobaciones = Input::get('aprobaciones');
				$count = count($idpostulantes_periodos);
				if($idfase==1){
					for($i=0;$i<$count;$i++){
						if($aprobaciones[$i] !== null){
							$postulante_periodo = PostulantesPeriodo::find($idpostulantes_periodos[$i]);
							$estado_aprobacion_anterior = $postulante_periodo->aprobacion;
							$postulante_periodo->asistencia = $asistencias[$i];
							$postulante_periodo->comentario = $comentarios[$i];
							$postulante_periodo->aprobacion = $aprobaciones[$i];
							$postulante_periodo->save();

							if($aprobaciones[$i] == 1 && $estado_aprobacion_anterior != 1){
								$postulante_periodo_nuevo = new PostulantesPeriodo;
								$postulante_periodo_nuevo->idpostulantes = $postulante_periodo->idpostulantes;
								$postulante_periodo_nuevo->idperiodos = $postulante_periodo->idperiodos;
								$postulante_periodo_nuevo->idfases = $idfase + 1;
								$postulante_periodo_nuevo->save();
							}
						}
					}
				}

				if($idfase==2){
					for($i=0;$i<$count;$i++){
						$postulante_periodo = PostulantesPeriodo::find($idpostulantes_periodos[$i]);
						$postulante_periodo->asistencia = $asistencias[$i];
						$postulante_periodo->comentario = $comentarios[$i];
						$postulante_periodo->aprobacion = $aprobaciones[$i];
						$postulante_periodo->save();

						if($aprobaciones[$i] == 1){
							$postulante_periodo_nuevo = new PostulantesPeriodo;
							$postulante_periodo_nuevo->idpostulantes = $postulante_periodo->idpostulantes;
							$postulante_periodo_nuevo->idperiodos = $postulante_periodo->idperiodos;
							$postulante_periodo_nuevo->idfases = $idfase + 1;
							$postulante_periodo_nuevo->save();
						}
					}
				}

				if($idfase==3){
					for($i=0;$i<$count;$i++){
						$postulante_periodo = PostulantesPeriodo::find($idpostulantes_periodos[$i]);
						$postulante_periodo->asistencia = $asistencias[$i];
						$postulante_periodo->comentario = $comentarios[$i];
						$postulante_periodo->aprobacion = $aprobaciones[$i];
						$postulante_periodo->save();
					}
				}

				Session::flash('message', 'Se registró correctamente la aprobación de postulantes..');				
				return Redirect::to('convocatorias/list_postulantes/'.$idperiodos)->withInput(Input::all());
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	/*

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
	*/

}