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

	public function render_create_evento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_evento',$data["permisos"])){
				$periodo = Periodo::getPeriodoActual()->get();
				$data["no_hay_periodo"] = false;
				if($periodo->isEmpty()){
					$data["no_hay_periodo"] = true;
					return View::make('eventos/createEvento',$data);
				}
				//$data["tipos_eventos"] = TipoEvento::lists('nombre','idtipo_eventos');
				$data["colegios"] = Colegio::lists('nombre','idcolegios');
				$data["puntos_reunion"] = PuntoReunion::orderBy('direccion','asc')->get();
				$data["voluntarios"] = UsersPeriodo::getUsersPorPeriodo($periodo[0]->idperiodos)->get();
				$data["periodo"] = $periodo[0]->idperiodos;
				return View::make('eventos/createEvento',$data);
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

	public function submit_create_evento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_evento',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'nombre' => 'Título del Evento',
							'fecha_evento' => 'Fecha del Evento',
							'idcolegios' => 'Colegio',
							'direccion' => 'Dirección Exacta',
							'voluntarios' => 'Voluntarios',
							'latitud' => 'Punto en el Mapa',
						);
				$messages = array();
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|max:100',
							'fecha_evento' => 'required',
							'idcolegios' => 'required',
							'direccion' => 'required|max:100',
							'voluntarios' => 'required',
							'latitud' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('eventos/create_evento')->withErrors($validator)->withInput(Input::all());
				}else{
					/* Primero creo el evento */
					$evento = new Evento;
					$evento->nombre = Input::get('nombre');
					$evento->fecha_evento = date('Y-m-d H:i:s',strtotime(Input::get('fecha_evento')));
					//$evento->idtipo_eventos = Input::get('idtipo_eventos');
					$evento->direccion = Input::get('direccion');
					$evento->latitud = Input::get('latitud');
					$evento->longitud = Input::get('longitud');
					$evento->idperiodos = Input::get('idperiodos');
					$evento->save();
					/* Creo los puntos de reunion */
					if(!empty(Input::get('puntos_reunion'))){
						foreach(Input::get('puntos_reunion') as $punto_reunion){
							$punto_reunion_evento = new PuntoEvento;
							$punto_reunion_evento->idpuntos_reunion = $punto_reunion;
							$punto_reunion_evento->ideventos = $evento->ideventos;
							$punto_reunion_evento->save();
						}
					}
					/* Creo las asistencias de los usuarios */
					foreach(Input::get('voluntarios') as $voluntario){
						$asistencia = new Asistencia;
						$asistencia->asistio = 0;
						$asistencia->idusers = $voluntario;
						$asistencia->ideventos = $evento->ideventos;
						$asistencia->save();
					}
					/* Creo las asistencias de los niños */
					$ninhos = Ninho::getNinhosPorColegio(Input::get('idcolegios'))->get();
					foreach($ninhos as $ninho){
						$asistencia_ninho = new AsistenciaNinho;
						$asistencia_ninho->idninhos = $ninho->idninhos;
						$asistencia_ninho->ideventos = $evento->ideventos;
						$asistencia_ninho->save();
					}
					/* Envio las notificaciones via e-mail a los voluntarios */
					$emails_voluntarios = Asistencia::getUsersPorEvento($evento->ideventos)->get();
					$emails = array();
					foreach($emails_voluntarios as $email_voluntario){
						$emails[] = $email_voluntario->email;
					}

					Mail::send('emails.eventRegistration',array('evento'=> $evento),function($message) use ($emails,$evento)
					{
						$message->to($emails)
								->subject('Tienes un nuevo evento de AFI Perú.');
					});

					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se creó el evento con id {{$evento->ideventos}}";
					Helpers::registrarLog(3,$descripcion_log);
					Session::flash('message', 'Se registró correctamente el evento.');
					return Redirect::to('eventos/create_evento');
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

	public function list_eventos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_eventos',$data["permisos"])){
				$data["search"] = null;
				$data["periodos"] = Periodo::lists('nombre','idperiodos');
				$periodo = Periodo::getPeriodoActual()->get();
				if($periodo->isEmpty()){
					$data["eventos_data"] = array();
					$data["no_hay_periodo"] = true;
				}else{
					$data["eventos_data"] = Evento::getEventosInfo($periodo[0]->idperiodos)->paginate(10);
					$data["no_hay_periodo"] = false;
				}
				$data["hoy"] = date("Y-m-d H:i:s");
				return View::make('eventos/listEventos',$data);
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

	public function search_evento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_eventos',$data["permisos"])){
				$data["search"] = Input::get('search');
				$data["eventos_data"] = Evento::getEventosInfo($data["search"])->paginate(10);
				$data["no_hay_periodo"] = false;
				$data["periodos"] = Periodo::lists('nombre','idperiodos');
				$data["hoy"] = date("Y-m-d H:i:s");
				return View::make('eventos/listEventos',$data);
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

	public function render_edit_evento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_evento',$data["permisos"])) && $id){
				$data["evento_info"] = Evento::searchEventosById($id)->get();
				if($data["evento_info"]->isEmpty()){
					Session::flash('error', 'No se encontró el evento.');
					return Redirect::to('eventos/list_evento');
				}
				$data["evento_info"] = $data["evento_info"][0];
				$data["voluntarios"] = Asistencia::getUsersPorEvento($data["evento_info"]->ideventos)->get();
				$data["puntos_reunion"] = PuntoReunion::orderBy('direccion','asc')->get();
				$puntos_reunion_seleccionados = PuntoEvento::getPuntosPorEvento($data["evento_info"]->ideventos)->get()->toArray();
				$data["hoy"] = date("Y-m-d H:i:s");
				$data["puntos_reunion_seleccionados"] = array();
				foreach($puntos_reunion_seleccionados as $punto_reunion_seleccionado){
					$data["puntos_reunion_seleccionados"][] = $punto_reunion_seleccionado['idpuntos_reunion'];
				}
				return View::make('eventos/editEvento',$data);
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

	public function submit_edit_evento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_evento',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'nombre' => 'Título del Evento',
							'direccion' => 'Dirección Exacta',
							'latitud' => 'Punto en el Mapa',
						);
				$messages = array();
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|max:100',
							'direccion' => 'required|max:100',
							'latitud' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$ideventos = Input::get('ideventos');
				if($validator->fails()){
					return Redirect::to('eventos/edit_evento/'.$ideventos)->withErrors($validator)->withInput(Input::all());
				}else{
					$evento = Evento::find($ideventos);
					$evento->nombre = Input::get('nombre');
					if(Input::get('fecha_evento'))
						$evento->fecha_evento = date('Y-m-d H:i:s',strtotime(Input::get('fecha_evento')));
					$evento->direccion = Input::get('direccion');
					$evento->latitud = Input::get('latitud');
					$evento->longitud = Input::get('longitud');
					$evento->save();
					/* Envio las notificaciones via e-mail a los voluntarios */
					$emails_voluntarios = Asistencia::getUsersPorEvento($evento->ideventos)->get();
					$emails = array();
					foreach($emails_voluntarios as $email_voluntario){
						$emails[] = $email_voluntario->email;
					}

					Mail::send('emails.eventEdit',array('evento'=> $evento),function($message) use ($emails,$evento)
					{
						$message->to($emails)
								->subject('Modificación de evento de AFI Perú.');
					});
					/* Elimino los puntos de reunion previos */
					DB::table('puntos_eventos')->where('ideventos', '=', $ideventos)->delete();
					/* Creo los puntos de reunion */
					foreach(Input::get('puntos_reunion') as $punto_reunion){
						$punto_reunion_evento = new PuntoEvento;
						$punto_reunion_evento->idpuntos_reunion = $punto_reunion;
						$punto_reunion_evento->ideventos = $evento->ideventos;
						$punto_reunion_evento->save();
					}
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se editó el evento con id {{$evento->ideventos}}";
					Helpers::registrarLog(4,$descripcion_log);
					Session::flash('message', 'Se editó correctamente el evento.');
					return Redirect::to('eventos/edit_evento/'.$ideventos);
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

	public function submit_delete_evento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_evento',$data["permisos"])){
				$ideventos = Input::get('ideventos');
				$evento = Evento::find($ideventos);
				$evento->delete();
				/* Envio las notificaciones via e-mail a los voluntarios */
				$emails_voluntarios = Asistencia::getUsersPorEvento($evento->ideventos)->get();
				$emails = array();
				foreach($emails_voluntarios as $email_voluntario){
					$emails[] = $email_voluntario->email;
					$asistencia = Asistencia::find($email_voluntario->idasistencias);
					$asistencia->delete();
				}
				Mail::send('emails.eventCancellation',array('evento'=> $evento),function($message) use ($emails,$evento)
				{
					$message->to($emails)
							->subject('Cancelación de evento de AFI Perú.');
				});
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se eliminó el evento con id {{$ideventos}}";
				Helpers::registrarLog(5,$descripcion_log);
				Session::flash('message', 'Se canceló correctamente el evento.');
				return Redirect::to('eventos/list_eventos');
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

	public function render_upload_file($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_evento',$data["permisos"])) && $id){
				$data["evento_info"] = Evento::searchEventosById($id)->get();
				if($data["evento_info"]->isEmpty()){
					Session::flash('error', 'No se encontró el evento.');
					return Redirect::to('eventos/list_evento');
				}
				$data["evento_info"] = $data["evento_info"][0];
				$documentos = DocumentosEvento::getDocumentosPorEvento($data["evento_info"]->ideventos)->get();
				$data["documentos"] = array();
				foreach($documentos as $documento){
					$visualizaciones = Visualizacion::getVisualizacionesPorEventoPorDocumento($data["evento_info"]->ideventos,$documento->iddocumentos)->get();
					$datos = array(
							'documento' => $documento,
							'visualizaciones' => $visualizaciones
						);
					$data["documentos"][] = $datos;
				}
				$data["hoy"] = date("Y-m-d H:i:s");
				return View::make('eventos/uploadFile',$data);
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

	public function submit_upload_file()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_evento',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'archivo' => 'Documento',
						);
				$messages = array();
				$rules = array(
							'archivo' => 'required|max:15360|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$ideventos = Input::get('ideventos');
				if($validator->fails()){
					return Redirect::to('eventos/upload_file/'.$ideventos)->withErrors($validator)->withInput(Input::all());
				}else{
				    if(Input::hasFile('archivo')){
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'files/eventos/';
				        $nombreArchivo = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $peso = $archivo->getSize();
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    	/* Creo el documento */
						$documento = new Documento;
						$documento->titulo = $nombreArchivo;
						$documento->idtipo_documentos = 1; // ¡Que viva el hardcode!
						$documento->nombre_archivo = $nombreArchivoEncriptado;
						$documento->ruta = $rutaDestino;
						$documento->peso = $peso;
						$documento->save();
						/* Creo la relación de evento con documento */
						$documentos_evento = new DocumentosEvento;
						$documentos_evento->ideventos = $ideventos;
						$documentos_evento->iddocumentos = $documento->iddocumentos;
						$documentos_evento->save();
						/* Envio las notificaciones via e-mail a los voluntarios */
						$evento = Evento::find($ideventos);
						$emails_voluntarios = Asistencia::getUsersPorEvento($evento->ideventos)->get();
						$emails = array();
						foreach($emails_voluntarios as $email_voluntario){
							$emails[] = $email_voluntario->email;
						}
						Mail::send('emails.eventDocumento',array('evento'=> $evento,'documento'=>$documento),function($message) use ($emails,$evento)
						{
							$message->to($emails)
									->subject('Se subió un nuevo documento de AFI Perú.');
						});
						// Llamo a la función para registrar el log de auditoria
						$descripcion_log = "Se subió el documento con id {{$documento->iddocumentos}}";
						Helpers::registrarLog(7,$descripcion_log);
				    }
					
					Session::flash('message', 'Se subió correctamente el archivo.');				
					return Redirect::to('eventos/upload_file/'.$ideventos);
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

	public function submit_delete_file()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_evento',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$rules = array(
							'iddocumentos_eventos' => 'required',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$ideventos = Input::get('ideventos');
				if($validator->fails()){
					return Redirect::to('eventos/upload_file/'.$ideventos)->withErrors($validator)->withInput(Input::all());
				}else{
					/* Elimino el documento y la relación con el evento */
					$documentos_evento = DocumentosEvento::find(Input::get('iddocumentos_eventos'));
					$documento = Documento::find($documentos_evento->iddocumentos);
					$documento->delete();
					$documentos_evento->delete();
					Session::flash('message', 'Se eliminó correctamente el archivo.');
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se eliminó el documento con id {{$documento->iddocumentos}}";
					Helpers::registrarLog(8,$descripcion_log);			
					return Redirect::to('eventos/upload_file/'.$ideventos);
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

	public function render_asistencia_evento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_evento',$data["permisos"])) && $id){
				$data["evento_info"] = Evento::searchEventosById($id)->get();
				if($data["evento_info"]->isEmpty()){
					Session::flash('error', 'No se encontró el evento.');
					return Redirect::to('eventos/list_evento');
				}
				$data["evento_info"] = $data["evento_info"][0];
				$data["voluntarios"] = Asistencia::getUsersPorEvento($data["evento_info"]->ideventos)->get();
				$data["hoy"] = date("Y-m-d H:i:s");
				return View::make('eventos/tomarAsistencia',$data);
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

	public function submit_asistencia_evento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_evento',$data["permisos"])){
				$idasistencias = Input::get('idasistencias');
				$calificaciones = Input::get('calificaciones');
				$comentarios = Input::get('comentarios');
				$asistencias = Input::get('asistencias');
				$count = count($idasistencias);
				for($i=0;$i<$count;$i++){
					$asistencia = Asistencia::find($idasistencias[$i]);
					$asistencia->asistio = $asistencias[$i];
					if($asistencias[$i]==0){
					$asistencia->calificacion = 0;
					$asistencia->comentario = "";
					}else{						
						$asistencia->calificacion = $calificaciones[$i];
						$asistencia->comentario = $comentarios[$i];
					}
					$asistencia->save();
				}
				$ideventos = Input::get('ideventos');
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se registró asistencia para el evento con id {{$ideventos}}";
				Helpers::registrarLog(3,$descripcion_log);	
				Session::flash('message', 'Se tomó correctamente la asistencia.');				
				return Redirect::to('eventos/asistencia_evento/'.$ideventos);
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

	public function render_mis_eventos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			$data["user_info"] = User::searchUserById($data["user"]->id)->get();
			if(in_array('side_mis_eventos',$data["permisos"])){
				return View::make('eventos/misEventos',$data);
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

	public function mis_eventos_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}

		if(Auth::check()){
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			$data["user_info"] = User::searchUserById($data["user"]->id)->get();
			if(in_array('side_mis_eventos',$data["permisos"])){
				$data['eventos'] = Asistencia::getEventosPorUser($data["user"]->id)->get()->toArray();
				$eventos = [];
				$length = sizeof($data['eventos']);
				for($i=0;$i<$length;$i++){
					$eventos[] = date("Y-m-d",strtotime($data['eventos'][$i]['fecha_evento']));
				}
				return Response::json(array( 'success' => true,'eventos'=>$eventos,'detalle_eventos' =>$data['eventos']),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_mis_eventos_fecha($fecha=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_mis_eventos',$data["permisos"])) && $fecha){
				$fecha_fin = date('Y-m-d', strtotime($fecha. ' + 1 days'));
				$data['eventos_data'] = Asistencia::getEventosPorUserPorFechas($data["user"]->id,$fecha,$fecha_fin)->get();
				$data["hoy"] = date("Y-m-d H:i:s");
				return View::make('eventos/misEventosPorFecha',$data);
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

	public function render_ver_evento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_mis_eventos',$data["permisos"])) && $id){
				$asistencia = Asistencia::validarAsistencia($data["user"]->id,$id)->get();
				if($asistencia->isEmpty()){
					Session::flash('error', 'Lo sentimos, no tiene acceso a ver el evento solicitado.');
					return Redirect::to('eventos/mis_eventos');
				}
				$data["evento_info"] = Evento::searchEventosById($id)->get();
				if($data["evento_info"]->isEmpty()){
					Session::flash('error', 'No se encontró el evento.');
					return Redirect::to('eventos/mis_eventos');
				}
				$data["evento_info"] = $data["evento_info"][0];
				$data["documentos"] = DocumentosEvento::getDocumentosPorEvento($data["evento_info"]->ideventos)->get();
				$data["voluntarios"] = Asistencia::getUsersPorEvento($data["evento_info"]->ideventos)->get();
				$data["puntos_reunion"] = PuntoReunion::all();
				$puntos_reunion_seleccionados = PuntoEvento::getPuntosPorEvento($data["evento_info"]->ideventos)->get()->toArray();
				foreach($puntos_reunion_seleccionados as $punto_reunion_seleccionado){
					$data["puntos_reunion_seleccionados"][] = $punto_reunion_seleccionado['idpuntos_reunion'];
				}
				return View::make('eventos/verEvento',$data);
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

	public function submit_descargar_documento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_mis_eventos',$data["permisos"])){
				$ideventos = Input::get('ideventos');
				$iddocumentos = Input::get('iddocumentos');
				$visualizacion = Visualizacion::getVisualizacionesPorUserPorEventoPorDocumento($data["user"]->id,$ideventos,$iddocumentos)->get();
				if($visualizacion->isEmpty()){
					$nueva_visualización = new Visualizacion;
					$nueva_visualización->idusers = $data["user"]->id;
					$nueva_visualización->ideventos = $ideventos;
					$nueva_visualización->iddocumentos = $iddocumentos;
					$nueva_visualización->save();
				}
				$documento = Documento::find($iddocumentos);
				$rutaDestino = $documento->ruta.$documento->nombre_archivo;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se descargó el documento con id {{$documento->iddocumentos}}";
				Helpers::registrarLog(9,$descripcion_log);	
		        return Response::download($rutaDestino,basename($documento->titulo),$headers);
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

	public function render_registrar_comentario($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_mis_eventos',$data["permisos"])) && $id){
				$asistencia = Asistencia::validarAsistencia($data["user"]->id,$id)->get();
				if($asistencia->isEmpty()){
					Session::flash('error', 'Lo sentimos, no tiene acceso a ver el evento solicitado.');
					return Redirect::to('eventos/mis_eventos');
				}
				$data["evento_info"] = Evento::searchEventosById($id)->get();
				if($data["evento_info"]->isEmpty()){
					Session::flash('error', 'No se encontró el evento.');
					return Redirect::to('eventos/mis_eventos');
				}
				$data["evento_info"] = $data["evento_info"][0];
				$data["hoy"] = date("Y-m-d H:i:s");
				$data["asistencia_ninhos"] = AsistenciaNinho::getNinhosPorEvento($data["evento_info"]->ideventos)->get();
				$data["comentario_ninhos"] = array();
				foreach($data["asistencia_ninhos"] as $ninho){
					$comentario = Comentario::getComentarioPorUserPorNinhos($data["user"]->id,$ninho->idasistencia_ninhos)->get();
					if($comentario->isEmpty()){
						$data["comentario_ninhos"][] = null;
					}
					else{
						$data["comentario_ninhos"][] = $comentario[0];
					}
				}
				return View::make('eventos/registrarComentario',$data);
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

	public function submit_registrar_comentario()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_mis_eventos',$data["permisos"]))){
				$ideventos = Input::get('ideventos');
				$asistencia = Asistencia::validarAsistencia($data["user"]->id,$ideventos)->get();
				if($asistencia->isEmpty()){
					Session::flash('error', 'Lo sentimos, no tiene acceso a ver el evento solicitado.');
					return Redirect::to('eventos/mis_eventos');
				}
				$data["evento_info"] = Evento::searchEventosById($ideventos)->get();
				if($data["evento_info"]->isEmpty()){
					Session::flash('error', 'No se encontró el evento.');
					return Redirect::to('eventos/mis_eventos');
				}
				$data["evento_info"] = $data["evento_info"][0];
				$data["hoy"] = date("Y-m-d H:i:s");
				$idasistencia_ninhos = Input::get('idasistencia_ninhos');
				$idcomentarios = Input::get('idcomentarios');
				$calificaciones = Input::get('calificaciones');
				$comentarios = Input::get('comentarios');
				for($i=0;$i<count($idcomentarios);$i++){
					if(empty($idcomentarios[$i])){
						$comentario = new Comentario;
						$comentario->idusers = $data["user"]->id;
						$comentario->idasistencia_ninhos = $idasistencia_ninhos[$i];
						$comentario->comentario = $comentarios[$i];
						$comentario->calificacion = $calificaciones[$i];
						$comentario->save();
					}else{
						$comentario = Comentario::find($idcomentarios[$i]);
						$comentario->comentario = $comentarios[$i];
						$comentario->calificacion = $calificaciones[$i];
						$comentario->save();
					}
				}
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se registraron comentarios sobre los niños en el evento con id {{$ideventos}}";
				Helpers::registrarLog(3,$descripcion_log);
				Session::flash('message', 'Se registraron correctamente los comentarios.');				
				return Redirect::to('eventos/registrar_comentario/'.$ideventos);
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

	public function render_create_punto_reunion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_punto_reunion',$data["permisos"])){
				return View::make('eventos/createPuntoReunion',$data);
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

	public function submit_create_punto_reunion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_punto_reunion',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'direccion' => 'Dirección Exacta',
							'latitud' => 'Punto en el Mapa',
						);
				$messages = array();
				$rules = array(
							'direccion' => 'required|direction|max:100',
							'latitud' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('eventos/create_punto_reunion')->withErrors($validator)->withInput(Input::all());
				}else{
					$punto_reunion = new PuntoReunion;
					$punto_reunion->direccion = Input::get('direccion');
					$punto_reunion->latitud = Input::get('latitud');
					$punto_reunion->longitud = Input::get('longitud');
					$punto_reunion->save();
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se registró el punto de reunión con id {{$punto_reunion->idpuntos_reunion}}";
					Helpers::registrarLog(3,$descripcion_log);
					Session::flash('message', 'Se registró correctamente el punto de reunión.');
					return Redirect::to('eventos/create_punto_reunion');
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
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se eliminó el punto de reunión con id {{$punto_reunion->idpuntos_reunion}}";
				Helpers::registrarLog(5,$descripcion_log);
				return Response::json(array( 'success' => true ),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}