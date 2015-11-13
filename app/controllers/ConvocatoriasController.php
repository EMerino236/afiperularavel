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

	public function render_create_convocatoria()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nueva_convocatoria',$data["permisos"])){
				return View::make('convocatorias/createConvocatoria',$data);
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

	public function submit_create_convocatoria()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nueva_convocatoria',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'nombre' => 'Nombre de Convocatoria',
							'fecha_inicio' => 'Fecha de Inicio',
							'fecha_fin' => 'Fecha de Fin',
						);
				$messages = array();

				$rules = array(
							'nombre' => 'required|alpha_num_dash|min:2|max:100|unique:periodos',
							'fecha_inicio' => 'required',
							'fecha_fin' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('convocatorias/create_convocatoria')->withErrors($validator)->withInput(Input::all());
				}else{
					// Creo primero a la persona
					$fecha_inicio = date('Y-m-d',strtotime(Input::get('fecha_inicio')));
					$fecha_fin = date('Y-m-d',strtotime(Input::get('fecha_fin')));
					$interseccion_fecha_inicio = Periodo::getPeriodosIntersectionWithDatesNewPeriod($fecha_inicio)->get();
					$interseccion_fecha_fin = Periodo::getPeriodosIntersectionWithDatesNewPeriod($fecha_fin)->get();

					if($fecha_inicio < $fecha_fin){
						if($interseccion_fecha_inicio->isEmpty() && $interseccion_fecha_fin->isEmpty()){
							$convocatoria = new Periodo;
							$convocatoria->nombre = Input::get('nombre');
							$convocatoria->fecha_inicio = $fecha_inicio;
							$convocatoria->fecha_fin = $fecha_fin;
							$convocatoria->save();
							Session::flash('message', 'Se registró correctamente la convocatoria.');

							// Llamo a la función para registrar el log de auditoria
							$descripcion_log = "Se creó el periodo con id {{$convocatoria->idperiodos}}";
							Helpers::registrarLog(3,$descripcion_log);

							
							return Redirect::to('convocatorias/create_convocatoria');
						}
						else{
							Session::flash('error', 'Las fechas de inicio o fin se intersectan con las fechas de otra convocatoria.');
							return Redirect::to('convocatorias/create_convocatoria')->withInput(Input::all());
						}
					}
					else{
						Session::flash('error', 'La Fecha de Inicio debe ser menor a la Fecha Fin.');
						return Redirect::to('convocatorias/create_convocatoria')->withInput(Input::all());
					}
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

	public function submit_edit_convocatoria()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nueva_convocatoria',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'nombre' => 'Nombre de Convocatoria',
							'fecha_inicio' => 'Fecha de Inicio',
							'fecha_fin' => 'Fecha Fin',
						);
				$messages = array();

				$convocatoria_id = Input::get('convocatoria_id');
				$rules = array(
							'nombre' => 'required|alpha_num_dash|min:2|max:100|unique:periodos,nombre,'.$convocatoria_id.',idperiodos',
							'fecha_inicio' => 'required',
							'fecha_fin' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$convocatoria_id = Input::get('convocatoria_id');
				$url = "convocatorias/edit_convocatoria"."/".$convocatoria_id;
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$fecha_inicio = date('Y-m-d H:i:s',strtotime(Input::get('fecha_inicio')));
					$fecha_fin = date('Y-m-d H:i:s',strtotime(Input::get('fecha_fin')));
					$interseccion_fecha_inicio = Periodo::getPeriodosIntersectionWithDatesNewPeriodEdit($fecha_inicio,$convocatoria_id)->get();
					$interseccion_fecha_fin = Periodo::getPeriodosIntersectionWithDatesNewPeriodEdit($fecha_fin,$convocatoria_id)->get();
					if($fecha_inicio < $fecha_fin){
						if($interseccion_fecha_inicio->isEmpty() && $interseccion_fecha_fin->isEmpty()){
							$convocatoria = Periodo::find($convocatoria_id);
							$convocatoria->nombre = Input::get('nombre');
							$convocatoria->fecha_inicio = $fecha_inicio;
							$convocatoria->fecha_fin = $fecha_fin;
							$convocatoria->save();
							Session::flash('message', 'Se editó correctamente la convocatoria.');

							// Llamo a la función para registrar el log de auditoria
							$descripcion_log = "Se editó el periodo con id {{$convocatoria->idperiodos}}";
							Helpers::registrarLog(4,$descripcion_log);
							
							return Redirect::to($url);
						}
						else{
							Session::flash('error', 'Las fechas de inicio o fin se intersectan con las fechas de otra convocatoria.');
							return Redirect::to('convocatorias/create_convocatoria')->withInput(Input::all());
						}
					}
					else{
						Session::flash('error', 'La Fecha de Inicio debe ser menor a la Fecha Fin.');
						return Redirect::to($url)->withInput(Input::all());
					}
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
				$data["idfase"] = 1;
				$data["estado_aprobacion"] = -1;
				if($data["estado_aprobacion"] == -1){
					$data["estado_aprobacion"] = null;
				}				
				$data["postulantes_info"] = PostulantesPeriodo::getPostulantesPorPeriodoFase($id,$data["idfase"],$data["estado_aprobacion"])->paginate(10);													
				return View::make('convocatorias/listPostulantes',$data);
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
				$data["estado_aprobacion"] = Input::get('select_aprobacion');
				if($data["estado_aprobacion"] == -1){
					$data["estado_aprobacion"] = null;
				}
				$data["postulantes_info"] = PostulantesPeriodo::getPostulantesPorPeriodoFase(Input::get('idperiodos'),Input::get('idfases'),$data["estado_aprobacion"])->paginate(10);	
				return View::make('convocatorias/listPostulantes',$data);
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
						if($aprobaciones[$i] != -1){
							$postulante_periodo = PostulantesPeriodo::find($idpostulantes_periodos[$i]);
							$estado_aprobacion_anterior = $postulante_periodo->aprobacion;
							$postulante_periodo->asistencia = $asistencias[$i];
							$postulante_periodo->comentario = $comentarios[$i];
							$postulante_periodo->aprobacion = $aprobaciones[$i];
							$postulante_periodo->save();

							// Llamo a la función para registrar el log de auditoria
							$descripcion_log = "Se aprobó / desaprobó al postulante por periodo con id {{$postulante_periodo->idpostulantes_periodos}}";
							Helpers::registrarLog(4,$descripcion_log);

							$postulante = Postulante::searchPostulanteById($postulante_periodo->idpostulantes)->get();
							$postulante = $postulante[0];
							if($aprobaciones[$i] == 1 && $estado_aprobacion_anterior != 1){
								$postulante_periodo_nuevo = new PostulantesPeriodo;
								$postulante_periodo_nuevo->idpostulantes = $postulante_periodo->idpostulantes;
								$postulante_periodo_nuevo->idperiodos = $postulante_periodo->idperiodos;
								$postulante_periodo_nuevo->idfases = $idfase + 1;
								$postulante_periodo_nuevo->save();								

								Mail::send('emails.aprobacionFasePostulacion',array('postulante'=> $postulante),function($message) use ($postulante)
									{
										$message->to($postulante->email)
												->subject('Primera Fase de Postulación - AFI Perú.');
									});

								// Llamo a la función para registrar el log de auditoria
								// Llamo a la función para registrar el log de auditoria
							$descripcion_log = "Se creó al postulante por periodo con id {{$postulante_periodo_nuevo->idpostulantes_periodos}}";
							Helpers::registrarLog(3,$descripcion_log);
							}
							else{
								/*
								Mail::send('emails.desaprobacionFasePostulacion',array('postulante'=> $postulante),function($message) use ($postulante)
									{
										$message->to($postulante->email)
												->subject('Primera Fase de Postulación - AFI Perú.');
									});
									*/
							}
						}
					}
				}

				if($idfase==2){
					for($i=0;$i<$count;$i++){
						if($aprobaciones[$i] != -1){
							$postulante_periodo = PostulantesPeriodo::find($idpostulantes_periodos[$i]);
							$postulante_periodo->asistencia = $asistencias[$i];
							$postulante_periodo->comentario = $comentarios[$i];
							$postulante_periodo->aprobacion = $aprobaciones[$i];
							$postulante_periodo->save();

							// Llamo a la función para registrar el log de auditoria
							$descripcion_log = "Se aprobó / desaprobó al postulante por periodo con id {{$postulante_periodo->idpostulantes_periodos}}";
							Helpers::registrarLog(4,$descripcion_log);

							$postulante = Postulante::searchPostulanteById($postulante_periodo->idpostulantes)->get();
							$postulante = $postulante[0];
							if($aprobaciones[$i] == 1){
								$postulante_periodo_nuevo = new PostulantesPeriodo;
								$postulante_periodo_nuevo->idpostulantes = $postulante_periodo->idpostulantes;
								$postulante_periodo_nuevo->idperiodos = $postulante_periodo->idperiodos;
								$postulante_periodo_nuevo->idfases = $idfase + 1;
								$postulante_periodo_nuevo->save();

								Mail::send('emails.aprobacionFasePostulacion',array('postulante'=> $postulante),function($message) use ($postulante)
									{
										$message->to($postulante->email)
												->subject('Segunda Fase de Postulación - AFI Perú.');
									});

								// Llamo a la función para registrar el log de auditoria
								$descripcion_log = "Se creó al postulante por periodo con id {{$postulante_periodo_nuevo->idpostulantes_periodos}}";
								Helpers::registrarLog(3,$descripcion_log);
							}
							else{
								Mail::send('emails.desaprobacionFasePostulacion',array('postulante'=> $postulante),function($message) use ($postulante)
									{
										$message->to($postulante->email)
												->subject('Segunda Fase de Postulación - AFI Perú.');
									});
							}
						}
					}
				}

				if($idfase==3){
					for($i=0;$i<$count;$i++){
						if($aprobaciones[$i] != -1){
							$postulante_periodo = PostulantesPeriodo::find($idpostulantes_periodos[$i]);
							$postulante_periodo->asistencia = $asistencias[$i];
							$postulante_periodo->comentario = $comentarios[$i];
							$postulante_periodo->aprobacion = $aprobaciones[$i];
							$postulante_periodo->save();

							// Llamo a la función para registrar el log de auditoria
							$descripcion_log = "Se aprobó / desaprobó al postulante por periodo con id {{$postulante_periodo->idpostulantes_periodos}}";
							Helpers::registrarLog(4,$descripcion_log);
						
							$postulante = Postulante::searchPostulanteById($postulante_periodo->idpostulantes)->get();
							$postulante = $postulante[0];
							if($aprobaciones[$i] == 1){
								$persona = new Persona;
								$persona->nombres = $postulante->nombres;
								$persona->apellido_pat = $postulante->apellido_pat;
								$persona->apellido_mat = $postulante->apellido_mat;
								$persona->fecha_nacimiento = date('Y-m-d H:i:s',strtotime($postulante->fecha_nacimiento));
								$persona->direccion = $postulante->direccion;
								$persona->telefono = $postulante->telefono;
								$persona->celular = $postulante->celular;
								$persona->save();

								// Llamo a la función para registrar el log de auditoria
								$descripcion_log = "Se creó la persdona  con id {{$persona->idpersonas}}";
								Helpers::registrarLog(3,$descripcion_log);

								// Creo al usuario y le asigno su información de persona
								$password = Str::random(8);
								$user = new User;
								$user->num_documento = $postulante->num_documento;
								$user->password = Hash::make($password);
								$user->idtipo_identificacion = 1;
								$user->email = $postulante->email;
								$user->idpersona = $persona->idpersonas;
								$user->auth_token = Str::random(32);
								$user->save();

								// Llamo a la función para registrar el log de auditoria
								$descripcion_log = "Se creó el usuario con id {{$user->id}}";
								Helpers::registrarLog(3,$descripcion_log);
								// Registro los perfiles seleccionados
								$perfil = 3;
								$users_perfil = new UsersPerfil;
								$users_perfil->idusers = $user->id;
								$users_perfil->idperfiles = $perfil;
								$users_perfil->save();

								// Llamo a la función para registrar el log de auditoria
								$descripcion_log = "Se creó el usuario por perfil con id {{$users_perfil->idusers_perfiles}}";
								Helpers::registrarLog(3,$descripcion_log);

								// Registro el usuario en el periodo correspondiente
								$users_periodo = new UsersPeriodo;
								$users_periodo->idusers = $user->id;
								$users_periodo->idperiodos = $postulante_periodo->idperiodos;
								$users_periodo->save();

								// Llamo a la función para registrar el log de auditoria
								$descripcion_log = "Se creó el usuario por periodo con id {{$users_periodo->idusers_periodos}}";
								Helpers::registrarLog(3,$descripcion_log);

								Mail::send('emails.aprobacionFinalPostulacion',array('user'=> $user,'persona'=>$persona,'password'=>$password),function($message) use ($user,$persona)
								{
									$message->to($user->email, $persona->nombres)
											->subject('Registro de nuevo usuario');
								});
							}
							else{
								Mail::send('emails.desaprobacionFasePostulacion',array('postulante'=> $postulante),function($message) use ($postulante)
											{
												$message->to($postulante->email)
														->subject('Tercera Fase de Postulación - AFI Perú.');
											});
							}
						}
					}
				}

				Session::flash('message', 'Se registró correctamente la aprobación de postulantes..');				
				return Redirect::to('convocatorias/list_postulantes/'.$idperiodos);
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

	public function render_view_postulante($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nueva_convocatoria',$data["permisos"])) && $id){
				$postulante_periodo = PostulantesPeriodo::searchPostulantePeriodoById($id)->get();
				$postulante_periodo = $postulante_periodo[0];
				$data["idperiodo"] = $postulante_periodo->idperiodos;
				$data["postulante_info"] = Postulante::searchPostulanteById($postulante_periodo->idpostulantes)->get();
				if($data["postulante_info"]->isEmpty()){
					Session::flash('error', 'No se encontró la convocatoria.');
					return Redirect::to('convocatorias/list_convocatoria');
				}
				$data["postulante_info"]  = $data["postulante_info"] [0];
				return View::make('convocatorias/viewPostulante',$data);
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

	public function list_voluntarios($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nueva_convocatoria',$data["permisos"])){
				$data["voluntarios_data"] = UsersPerfil::getVoluntariosByIdPeriodo($id);
				$data["convocatoria_info"] = Periodo::searchPeriodoById($id)->get()[0];
				$data["search"] = '';
				return View::make('convocatorias/listVoluntariosConvocatoria',$data);
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

	public function search_voluntarios()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_voluntarios',$data["permisos"])){
				$data["convocatoria_info"] = Periodo::searchPeriodoById(Input::get('idperiodos'))->get()[0];
				$data["search"] = Input::get('search');
				$data["voluntarios_data"] = UsersPerfil::searchVoluntariosInfoByIdPeriodo(Input::get('idperiodos'),$data["search"]);
				return View::make('convocatorias/listVoluntariosConvocatoria',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_view_voluntario_convocatoria($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nueva_convocatoria',$data["permisos"])) && $id){
				$data["user_info"] = User::searchUserById($id)->get();
				if($data["user_info"]->isEmpty()){
					Session::flash('error', 'No se encontró al voluntario.');
					return Redirect::to('convocatorias/listVoluntarios');
				}
				$data["user_info"] = $data["user_info"][0];
				$data["perfiles"] = User::getPerfilesPorUsuario($data["user_info"]->id)->get();
				return View::make('convocatorias/viewVoluntarioConvocatoria',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_disable_convocatoria()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_usuario',$data["permisos"])){
				$idperiodo = Input::get('idperiodo');
				$exist_evento = Evento::where('idperiodos','=',$idperiodo)->get();
				$exist_postulante = PostulantesPeriodo::where('idperiodos','=',$idperiodo)->get();
				$exist_user = UsersPeriodo::where('idperiodos','=',$idperiodo)->get();
				$url = "convocatorias/edit_convocatoria/".$idperiodo;
				if($exist_evento->isEmpty() && $exist_postulante->isEmpty() && $exist_user->isEmpty()){
					$periodo = Periodo::find($idperiodo);
					$periodo->delete();

					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se inhabilitó el periodo con id {{$periodo->idperiodos}}";
					Helpers::registrarLog(5,$descripcion_log);

					Session::flash('message', 'Se inhabilitó correctamente la convocatoria.');
				}
				else{
					Session::flash('error', 'Existe al menos un evento, postulante o usuario asociado a esta convocatoria. No es posible inhabilitar.');
				}
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

	public function submit_enable_convocatoria()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_usuario',$data["permisos"])){
				$idperiodo = Input::get('idperiodo');
				$url = "convocatorias/edit_convocatoria/".$idperiodo;
				$periodo = Periodo::withTrashed()->find($idperiodo);
				$periodo->restore();

				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se habilitó el periodo con id {{$periodo->idperiodos}}";
				Helpers::registrarLog(6,$descripcion_log);

				Session::flash('message', 'Se habilitó correctamente la convocatoria.');
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

}
