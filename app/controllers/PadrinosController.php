<?php

class PadrinosController extends BaseController
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_padrinos',$data["permisos"])){
				return Redirect::to('/padrinos/list_padrinos');
			}else if(in_array('nav_padrinos',$data["permisos"])){
				return View::make('padrinos/home',$data);
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

	public function list_padrinos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_padrinos',$data["permisos"])){
				$data["search"] = null;			
				$data["padrinos_data"] = Padrino::getPadrinosInfo()->paginate(10);
				return View::make('padrinos/listPadrinos',$data);
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

	public function search_padrino()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_padrinos',$data["permisos"])){
				$data["search"] = Input::get('search');
				$data["padrinos_data"] = Padrino::searchPadrinos($data["search"])->paginate(10);
				return View::make('padrinos/listPadrinos',$data);
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

	public function render_edit_padrino($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_listar_padrinos',$data["permisos"])) && $id){
				$data["padrino_info"] = Padrino::searchPadrinoById($id)->get();				
				if($data["padrino_info"]->isEmpty()){
					Session::flash('error', 'No se encontró al padrino.');
					return Redirect::to('padrinos/list_padrinos');
				}
				$data["padrino_info"] = $data["padrino_info"][0];
				return View::make('padrinos/editPadrino',$data);
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


	public function render_create_reporte_padrinos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_reporte_padrinos',$data["permisos"])){
				return View::make('padrinos/reportePadrinos',$data);
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

	public function submit_create_reporte_padrinos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_reporte_padrinos',$data["permisos"])){
				$anho = date("Y");
				$padrinos = Padrino::getPadrinosActivos($anho)->get();
				if($padrinos->isEmpty()){
					Session::flash('error', 'No se encontraron padrinos asociados al año actual, no se envió ningun correo.');
					return Redirect::to('padrinos/create_reporte_padrinos');
				}
				if(Input::hasFile('archivo')){
			        $archivo = Input::file('archivo');
			        $rutaDestino = 'files/reportes_padrinos/';
			        $nombreArchivo = $archivo->getClientOriginalName();
				    $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				    $peso = $archivo->getSize();
			        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
			    	/* Creo el documento */
					$documento = new Documento;
					$documento->titulo = $nombreArchivo;
					$documento->idtipo_documentos = 2; // ¡Que viva el hardcode!
					$documento->nombre_archivo = $nombreArchivoEncriptado;
					$documento->peso = $peso;
					$documento->ruta = $rutaDestino;
					$documento->save();

					$emails = array();
					foreach($padrinos as $padrino){
						/* Creo la relación del documento con el padrino */
						$documentos_padrino = new DocumentosPadrino;
						$documentos_padrino->idpadrinos = $padrino->idpadrinos;
						$documentos_padrino->iddocumentos = $documento->iddocumentos;
						$documentos_padrino->save();
						$emails[] = $padrino->email;
					}
					
					/* Envio las notificaciones via e-mail a los padrinos */
					Mail::send('emails.reportePadrinos',array('archivo'=>$archivo),function($message) use ($emails)
					{
						$message->to($emails)
								->subject('Te queremos informar la labor de AFI PERÚ.');
					});

					//Enviar las push notifications a los padrinos y madrinas
					$padrinos_push = Padrino::getActivePadrinosPushInfo()->get();
					foreach ($padrinos_push as $padrino_push)
					{
						if ($padrino_push->push_reports && $padrino_push->uuid)
						{
							$message = 'Te queremos informar la labor de AFI PERÚ.';
							Helpers::pushAPNS($padrino_push->uuid, $message, 4);
						}
					}
                    
                    //Enviar las push notifications (android) a los padrinos y madrinas
                    $gcm_tokens = Padrino::getPadrinosToNotificateReport($anho)->get()->lists('gcm_token');
                    $message = 'Te queremos informar la labor de AFI PERÚ.';
                    $type = 4;
                    $m = ['title' => $title, 'message' => $message, 'type' => $type];
				    Helpers::pushGCM($gcm_tokens, $m);
                    
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se envió el reporte con id {{$documento->iddocumentos}}";
					Helpers::registrarLog(7,$descripcion_log);
					Session::flash('message', 'Se envió el reporte correctamente por correo a los padrinos.');

					
					return Redirect::to('padrinos/create_reporte_padrinos');
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

	public function list_reporte_padrinos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_reportes_padrinos',$data["permisos"])){
				$data["search"] = null;
				$data["fecha_ini"] = null;
				$data["fecha_fin"] = null;
				$data["reportes_padrinos"] = Documento::getDocumentosPorTipo(2)->paginate(10);
				return View::make('padrinos/listReportePadrinos',$data);
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

	public function search_reporte_padrinos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_reportes_padrinos',$data["permisos"])){
				$data["search"] = Input::get("search");
				$data["fecha_ini"] = Input::get("fecha_ini");
				$data["fecha_fin"] = Input::get("fecha_fin");
				$data["reportes_padrinos"] = Documento::searchDocumentosPorTipo(2,$data["search"],$data["fecha_ini"],$data["fecha_fin"])->paginate(10);
				return View::make('padrinos/listReportePadrinos',$data);
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

	public function submit_descargar_reporte_padrino()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_reportes_padrinos',$data["permisos"]) || in_array('side_mis_reportes',$data["permisos"])){
				$iddocumentos = Input::get('iddocumentos');
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

	public function list_mis_reportes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_mis_reportes',$data["permisos"])){
				$data["search"] = null;
				$data["fecha_ini"] = null;
				$data["fecha_fin"] = null;
				$padrino_info = Padrino::getPadrinoByUserId($data["user"]->id)->get();
				if($padrino_info->isEmpty()){
					Session::flash('error', 'No se le encontró información de padrino.');
					return Redirect::to('/dashboard');
				}
				$data["reportes_padrinos"] = DocumentosPadrino::getDocumentosPorUsuarioPorTipo(2,$padrino_info[0]->idpadrinos)->paginate(10);
				return View::make('padrinos/listMisReportes',$data);
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

	public function search_mis_reportes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_mis_reportes',$data["permisos"])){
				$data["search"] = Input::get("search");
				$data["fecha_ini"] = Input::get("fecha_ini");
				$data["fecha_fin"] = Input::get("fecha_fin");
				$padrino_info = Padrino::getPadrinoByUserId($data["user"]->id)->get();
				if($padrino_info->isEmpty()){
					Session::flash('error', 'No se le encontró información de padrino.');
					return Redirect::to('/dashboard');
				}
				$data["reportes_padrinos"] = DocumentosPadrino::searchDocumentosPorUsuarioPorTipo(2,$padrino_info[0]->idpadrinos,$data["search"],$data["fecha_ini"],$data["fecha_fin"])->paginate(10);
				return View::make('padrinos/listMisReportes',$data);
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

	public function submit_disable_padrino()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_padrinos',$data["permisos"])){
				$user_id = Input::get('user_id');
				$padrino_id = Input::get('padrino_id');
				$url = "padrinos/edit_padrino/".$user_id;
				$padrino = Padrino::find($padrino_id);
				$user = User::find($user_id);
				$padrino->delete();
				$user->delete();
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se inhabilitó al padrino con id {{$padrino_id}}";
				Helpers::registrarLog(5,$descripcion_log);
				Session::flash('message', 'Se inhabilitó correctamente al padrino.');
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

	public function submit_enable_padrino()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_padrinos',$data["permisos"])){
				$user_id = Input::get('user_id');
				$padrino_id = Input::get('padrino_id');
				$url = "padrinos/edit_padrino/".$user_id;
				$padrino = Padrino::withTrashed()->find($padrino_id);
				$user = User::withTrashed()->find($user_id);
				$padrino->restore();
				$user->restore();
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se habilitó al padrino con id {{$padrino_id}}";
				Helpers::registrarLog(6,$descripcion_log);
				Session::flash('message', 'Se habilitó correctamente al padrino.');
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


	public function list_prepadrinos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_aprobar_padrinos',$data["permisos"])){
				$data["search"] = null;			
				$data["prepadrinos_data"] = Prepadrino::getPrepadrinosInfo()->paginate(10);
				return View::make('padrinos/listPrepadrinos',$data);
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

	public function render_edit_prepadrino($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_aprobar_padrinos',$data["permisos"])) && $id){
				$data["prepadrino_info"] = Prepadrino::searchPrepadrinoById($id)->get();
				if($data["prepadrino_info"]->isEmpty()){
					Session::flash('error', 'No se encontró al padrino.');
					return Redirect::to('padrinos/list_prepadrinos');
				}
				$data["prepadrino_info"] = $data["prepadrino_info"][0];
				//$data["perfiles"] = User::getPerfilesPorUsuario($data["user_info"]->id)->get();
				return View::make('padrinos/editPrepadrinos',$data);
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

	public function aprobar_prepadrino_ajax()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_aprobar_padrinos',$data["permisos"])){
				
				$selected_ids = Input::get('selected_id');

				foreach($selected_ids as $selected_id){
					$prepadrino=Prepadrino::find($selected_id);
					if($prepadrino){
						//Primero creo ala persona
						$persona = new Persona;
						$persona->nombres = $prepadrino->nombres;
						$persona->apellido_pat = $prepadrino->apellido_pat;
						$persona->apellido_mat = $prepadrino->apellido_mat;
						$persona->fecha_nacimiento = $prepadrino->fecha_nacimiento;
						$persona->direccion = $prepadrino->direccion;
						$persona->telefono = $prepadrino->telefono;
						$persona->celular = $prepadrino->celular;
						$persona->save();

						// Creo al usuario y le asigno su información de persona
						$password = Str::random(8);
						$user = new User;
						$user->num_documento = $prepadrino->dni;
						$user->password = Hash::make($password);
						$user->idtipo_identificacion = 1;
						$user->email = $prepadrino->email;
						$user->idpersona = $persona->idpersonas;
						$user->auth_token = Str::random(32);
						$user->save();

						//Registro perfil padrino
						$user_perfil = new UsersPerfil;
						$user_perfil->idperfiles = 4;
						$user_perfil->idusers = $user->id;
						$user_perfil->save();

						//Regisro al padrino
						$padrino = new Padrino;
						$padrino->como_se_entero = $prepadrino->como_se_entero;
						$padrino->idusers = $user->id;
						$padrino->idperiodo_pagos = $prepadrino->idperiodo_pagos;
						$padrino->idresponsable = $data["user"]->id;
						$padrino->save();

						$descripcion_log = "Se aprobó al padrino con id {{$padrino->idpadrinos}}";
						Helpers::registrarLog(3,$descripcion_log);

						//Generacion de Calendario de Pagos
						$periodo_pago=PeriodoPago::find($padrino->idperiodo_pagos);
						if($periodo_pago){
							$numero_pagos = $periodo_pago->numero_pagos;
							$fecha_vencimiento = date('Y-m-d',strtotime($padrino->created_at));
							$fecha_vencimiento = date('Y-m-t',strtotime($fecha_vencimiento.'+ 1 days'));
							for($indice=1; $indice<=$numero_pagos; $indice++){
								
								$calendario_pago = new CalendarioPago;
								$calendario_pago->vencimiento = $fecha_vencimiento;
								$calendario_pago->num_cuota = $indice;
								//$calendario_pago->aprobacion = 0;
								$calendario_pago->idpadrinos = $padrino->idpadrinos;
								$calendario_pago->monto = 360/$numero_pagos;
								$calendario_pago->save();

								for($offset_mes=1; $offset_mes<=(12/$numero_pagos); $offset_mes++ ){
									$fecha_vencimiento = date('Y-m-t',strtotime($fecha_vencimiento.'+ 1 days'));
								}
							}
							$descripcion_log = "Se creó el calendario de pagos para el padrino con id {{$padrino->idpadrinos}}";
							Helpers::registrarLog(3,$descripcion_log);		
						}
						//Borrado logico del prepadrino
						$prepadrino->delete();						

						Mail::send('emails.userRegistration',array('user'=> $user,'persona'=>$persona,'password'=>$password),function($message) use ($user,$persona)
						{
							$message->to($user->email, $persona->nombres)
							->subject('Registro de nuevo padrino');
						});
						
					}
				}
				return Response::json(array( 'success' => true,'prepadrino_data'=>$prepadrino),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}		
	}

	public function render_reporte_pagos_padrinos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_reporte_pagos',$data["permisos"]))){
				$data["report_rows"] = null;
				$data["nomb_padrino"] = null;
				return View::make('padrinos/pagosPadrinoReporte',$data);
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

	public function submit_reporte_pagos_padrinos() 
	{ 
		if(Auth::check()){ 
			$data["inside_url"] = Config::get('app.inside_url'); 
			$data["user"] = Session::get('user'); 
			$data["permisos"] = Session::get('permisos'); 
			if((in_array('side_reporte_pagos',$data["permisos"]))){ 

				$rules = array( 
					'num_doc' => 'required|numeric' 
				); 

				$validator = Validator::make(Input::all(), $rules); 

				if($validator->fails()){ 
					return Redirect::to('padrinos/reporte_pagos_padrinos')->withErrors($validator)->withInput(Input::all()); 
				}else{
					$data["num_doc"] = Input::get('num_doc');
					$data["rad"] = Input::get('rad');
					$padrino = Padrino::searchPadrinoByNumDoc($data["num_doc"])->first(); //buscar funcion
					if($padrino){
						$data["nomb_padrino"] = $padrino->nombres.' '.$padrino->apellido_pat.' '.$padrino->apellido_mat; //agregar apellido
						if ($data["rad"]=='todos'){
							$data["report_rows"] = CalendarioPago::getCalendarioByPadrino($padrino->idpadrinos)->get(); 
						}else if ($data["rad"]=='pendientes'){
							$data["report_rows"] = CalendarioPago::getCalendarioByPadrinoPendientes($padrino->idpadrinos)->get(); 
						}else{
							$data["report_rows"] = CalendarioPago::getCalendarioByPadrinoPagados($padrino->idpadrinos)->get(); 
						}
							
						return View::make('padrinos/pagosPadrinoReporte',$data);
					}
					else{
						Session::flash('danger','No existe un padrino asociado a dicho número de documento.'); 
						return Redirect::to('padrinos/reporte_pagos_padrinos'); 
					}
				}
			}	
			else{
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

	public function list_aprobar_pagos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_aprobar_pagos',$data["permisos"])){
				$data["search"] = null;
				$data["pagos_data"] = CalendarioPago::getPagosPendientesAprobacion()->paginate(10);
				return View::make('padrinos/listAprobarPagos',$data);
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

	public function aprobar_pago_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}

		if(Auth::check()){
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			$data["user_info"] = User::searchUserById($data["user"]->id)->get();
			if(in_array('side_aprobar_pagos',$data["permisos"])){

				$selected_ids = Input::get('selected_id');
				

				foreach($selected_ids as $selected_id){
					$pago = CalendarioPago::find($selected_id);
					$padrinoPago = CalendarioPago::SearchPadrinoByIdPago($selected_id)->get();
					$padrinoPago = $padrinoPago[0];
					if($pago){
						$pago->aprobacion = 1;
						$pago->save();
					}
					Mail::send('emails.aprobacionPago',array('padrinoPago'=> $padrinoPago),function($message) use ($padrinoPago)
									{
										$message->to($padrinoPago->email)
												->subject('Aprobación de Pago - AFI Perú.');
									});
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se aprobó el pago con id {{$pago->idcalendario_pagos}} para el padrino con id {{$padrinoPago->idpadrinos}}";
					Helpers::registrarLog(4,$descripcion_log);
				}
				return Response::json(array( 'success' => true ),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}


	public function render_view_pago($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_aprobar_pagos',$data["permisos"])) && $id){
				$data["pago_data"] = CalendarioPago::SearchPadrinoByIdPago($id)->get();
				if($data["pago_data"]->isEmpty()){
					Session::flash('error', 'No se encontró el pago.');
					return Redirect::to('padrinos/list_aprobar_pagos');
				}
				$data["pago_data"] = $data["pago_data"][0];
				//$data["perfiles"] = User::getPerfilesPorUsuario($data["user_info"]->id)->get();
				return View::make('padrinos/viewPagos',$data);
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

	public function submit_aprove_pago()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_aprobar_pagos',$data["permisos"])){
				$idcalendario_pago = Input::get('idcalendario_pagos');
				$url = "padrinos/view_pago/".$idcalendario_pago;
				$pago = CalendarioPago::withTrashed()->find($idcalendario_pago);
				$padrinoPago = CalendarioPago::SearchPadrinoByIdPago($idcalendario_pago)->get();
				$padrinoPago = $padrinoPago[0];
				//Se aprueba

				$pago->aprobacion = 1;	
				$pago->save();
				Mail::send('emails.aprobacionPago',array('padrinoPago'=> $padrinoPago),function($message) use ($padrinoPago)
									{
										$message->to($padrinoPago->email)
												->subject('Aprobación de Pago - AFI Perú.');
									});
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se aprobó el pago con id {{$pago->idcalendario_pagos}} para el padrino con id {{$padrinoPago->idpadrinos}}";
				Helpers::registrarLog(4,$descripcion_log);
				Session::flash('message', 'Se aprobó correctamente el pago.');
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


	public function submit_rechazar_pago()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_aprobar_pagos',$data["permisos"])){
				$idcalendario_pago = Input::get('idcalendario_pagos');
				$url = "padrinos/view_pago/".$idcalendario_pago;
				$pago = CalendarioPago::withTrashed()->find($idcalendario_pago);
				$padrinoPago = CalendarioPago::SearchPadrinoByIdPago($idcalendario_pago)->get();
				$padrinoPago = $padrinoPago[0];
				//Se rechaza
				//$pago->fecha_pago = null;
				$pago->aprobacion = 0;	
				$pago->save();
				Mail::send('emails.rechazoPago',array('padrinoPago'=> $padrinoPago),function($message) use ($padrinoPago)
									{
										$message->to($padrinoPago->email)
												->subject('Rechazo de Pago - AFI Perú.');
									});
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se aprobó el pago con id {{$pago->idcalendario_pagos}} para el padrino con id {{$padrinoPago->idpadrinos}}";
				Helpers::registrarLog(4,$descripcion_log);
				Session::flash('message', 'Se rechazó correctamente el pago.');
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

	public function render_view_calendario_pagos(){

		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_calendario_pagos',$data["permisos"])){
				$data["search"] = null;
				$data["error"] = true;
				$data["padrino"] = Padrino::getPadrinoByUserId($data["user"]->id)->get();
				if($data["padrino"]->isEmpty()){
					Session::flash('error', 'No se encontró calendario de pagos.');
					return View::make('padrinos/listCalendarioPagos',$data);
				}else{
					$data["error"] = false;
					$padrino = $data["padrino"][0];
					$idpadrinos = $padrino->idpadrinos;
					$data["calendario_pagos"] = CalendarioPago::getCalendarioByPadrino($idpadrinos)->paginate(12);
					return View::make('padrinos/listCalendarioPagos',$data);
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

	public function list_registrar_pagos(){

		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_calendario_pagos',$data["permisos"])){
				$data["search"] = null;
				$data["error"] = true;
				$data["padrino"] = Padrino::getPadrinoByUserId($data["user"]->id)->get();
				if($data["padrino"]->isEmpty()){
					Session::flash('error', 'No se encontró calendario de pagos.');
					return View::make('padrinos/listRegistrarPagos',$data);
				}else{
					$data["error"] = false;
					$padrino = $data["padrino"][0];
					$idpadrinos = $padrino->idpadrinos;
					$data["calendario_pagos"] = CalendarioPago::getCalendarioByPadrino($idpadrinos)->paginate(12);
					return View::make('padrinos/listRegistrarPagos',$data);
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

	public function submit_registrar_pagos(){

		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_registrar_pago',$data["permisos"])){
				
				$rules = array( 
					'comprobante' => 'required|numeric',
					'banco' => 'required|alpha_spaces|min:2|max:100'
				); 

				$validator = Validator::make(Input::all(), $rules); 
				$url = "padrinos/list_registrar_pagos";
				if($validator->fails()){ 
					return Redirect::to($url)->withErrors($validator); 
				}else{
					$data["search"] = null;													

					$idcalendario_pagos = Input::get('idcalendario_pagos');
					$num_comprobante = Input::get('comprobante');
					$banco = Input::get('banco');

					$pago=CalendarioPago::find($idcalendario_pagos);			
					$pago->fecha_pago = date("Y-m-d");
					$pago->banco = $banco;
					$pago->num_comprobante = $num_comprobante;
					$pago->aprobacion =null;
					$pago->save();

					$descripcion_log = "Se registró el pago con id {{$pago->idcalendario_pagos}}";
					Helpers::registrarLog(3,$descripcion_log);

				return Redirect::to($url);
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

}
