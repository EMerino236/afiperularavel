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
				$data["tipos_eventos"] = TipoEvento::lists('nombre','idtipo_eventos');
				$data["colegios"] = Colegio::lists('nombre','idcolegios');
				$data["puntos_reunion"] = PuntoReunion::all();
				$data["voluntarios"] = UsersPeriodo::getUsersPorPeriodo($periodo[0]->idperiodos)->get();
				$data["periodo"] = $periodo[0]->idperiodos;
				return View::make('eventos/createEvento',$data);
			}else{
				return View::make('error/error');
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
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|max:100',
							'idtipo_eventos' => 'required',
							'fecha_evento' => 'required',
							'idcolegios' => 'required',
							'direccion' => 'required',
							'voluntarios' => 'required',
							'latitud' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('eventos/create_evento')->withErrors($validator)->withInput(Input::all());
				}else{
					/* Primero creo el evento */
					$evento = new Evento;
					$evento->nombre = Input::get('nombre');
					$evento->fecha_evento = date('Y-m-d H:i:s',strtotime(Input::get('fecha_evento')));
					$evento->idtipo_eventos = Input::get('idtipo_eventos');
					$evento->direccion = Input::get('direccion');
					$evento->latitud = Input::get('latitud');
					$evento->longitud = Input::get('longitud');
					$evento->idperiodos = Input::get('idperiodos');
					$evento->save();
					/* Creo los puntos de reunion */
					foreach(Input::get('puntos_reunion') as $punto_reunion){
						$punto_reunion_evento = new PuntoEvento;
						$punto_reunion_evento->idpuntos_reunion = $punto_reunion;
						$punto_reunion_evento->ideventos = $evento->ideventos;
						$punto_reunion_evento->save();
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

					Session::flash('message', 'Se registró correctamente el evento.');
					return Redirect::to('eventos/create_evento');
				}
			}else{
				return View::make('error/error');
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
				return View::make('error/error');
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
				return View::make('error/error');
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
				$data["puntos_reunion"] = PuntoReunion::all();
				$puntos_reunion_seleccionados = PuntoEvento::getPuntosPorEvento($data["evento_info"]->ideventos)->get()->toArray();
				$data["hoy"] = date("Y-m-d H:i:s");
				foreach($puntos_reunion_seleccionados as $punto_reunion_seleccionado){
					$data["puntos_reunion_seleccionados"][] = $punto_reunion_seleccionado['idpuntos_reunion'];
				}
				return View::make('eventos/editEvento',$data);
			}else{
				return View::make('error/error');
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
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|max:100',
							'direccion' => 'required',
							'latitud' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
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
					Session::flash('message', 'Se editó correctamente el evento.');
					return Redirect::to('eventos/edit_evento/'.$ideventos);
				}
			}else{
				return View::make('error/error');
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
				}

				Mail::send('emails.eventCancellation',array('evento'=> $evento),function($message) use ($emails,$evento)
				{
					$message->to($emails)
							->subject('Cancelación de evento de AFI Perú.');
				});
				/* Elimino los registros de asistencia */
				DB::table('asistencias')->where('ideventos', '=', $ideventos)->delete();
				/* Elimino los registros de asistencia de niños */
				DB::table('asistencia_ninhos')->where('ideventos', '=', $ideventos)->delete();
				/* Elimino los puntos de reunion */
				DB::table('puntos_eventos')->where('ideventos', '=', $ideventos)->delete();
				/* Elimino las visualizaciones */
				DB::table('visualizaciones')->where('ideventos', '=', $ideventos)->delete();
				Session::flash('message', 'Se canceló correctamente el evento.');
				return Redirect::to('eventos/list_eventos');
			}else{
				return View::make('error/error');
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
				return View::make('error/error');
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
				$rules = array(
							'archivo' => 'required|max:15360|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$ideventos = Input::get('ideventos');
				if($validator->fails()){
					return Redirect::to('eventos/upload_file/'.$ideventos)->withErrors($validator)->withInput(Input::all());
				}else{
				    if(Input::hasFile('archivo')){
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'files/eventos/';
				        $nombreArchivo = $archivo->getClientOriginalName();
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivo);
				    	/* Creo el documento */
						$documento = new Documento;
						$documento->titulo = $nombreArchivo;
						$documento->idtipo_documentos = 1; // ¡Que viva el hardcode!
						$documento->nombre_archivo = $nombreArchivo;
						$documento->ruta = $rutaDestino;
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
				    }
					
					Session::flash('message', 'Se subió correctamente el archivo.');				
					return Redirect::to('eventos/upload_file/'.$ideventos);
				}
			}else{
				return View::make('error/error');
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
					return Redirect::to('eventos/upload_file/'.$ideventos);
				}
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