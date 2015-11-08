<?php

class PadrinosController extends BaseController
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('nav_padrinos',$data["permisos"])){
				return View::make('padrinos/home',$data);
			}else{
				return View::make('error/error');
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
				return View::make('error/error');
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
				return View::make('error/error');
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
				return View::make('error/error');
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
				return View::make('error/error');
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
					$documento->nombre_archivo = $nombreArchivo;
					$documento->ruta = $rutaDestino;
					$documento->save();
					/* Envio las notificaciones via e-mail a los padrinos */
					$emails = array();
					foreach($padrinos as $padrino){
						$emails[] = $padrino->email;
					}
					Mail::send('emails.reportePadrinos',array('archivo'=>$archivo),function($message) use ($emails,$rutaDestino,$nombreArchivo)
					{
						$message->to($emails)
								->subject('Te queremos informar la labor de AFI PERÚ.')
								->attach(asset($rutaDestino).'/'.$nombreArchivo);
					});
					Session::flash('message', 'Se envió el reporte correctamente por correo a los padrinos.');
					return Redirect::to('padrinos/create_reporte_padrinos');
				}
			}else{
				return View::make('error/error');
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
				$data["reportes_padrinos"] = Documento::getDocumentosPorTipo(2)->paginate(10);
				return View::make('padrinos/listReportePadrinos',$data);
			}else{
				return View::make('error/error');
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
			if(in_array('side_listar_reportes_padrinos',$data["permisos"])){
				$iddocumentos = Input::get('iddocumentos');
				$documento = Documento::find($iddocumentos);
				$rutaDestino = $documento->ruta.$documento->nombre_archivo;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        return Response::download($rutaDestino,basename($rutaDestino),$headers);
			}else{
				return View::make('error/error');
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
				Session::flash('message', 'Se inhabilitó correctamente al padrino.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
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
				Session::flash('message', 'Se habilitó correctamente al padrino.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
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
				return View::make('error/error');
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
				return View::make('error/error');
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

						//Generacion de Calendario de Pagos
						$periodo_pago=PeriodoPago::find($padrino->idperiodo_pagos);
						if($periodo_pago){
							$numero_pagos=$periodo_pago->numero_pagos;
							
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
				return View::make('padrinos/pagosPadrinoReporte',$data);
			}else{
				return View::make('error/error');
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
				$padrino = Padrino::searchPadrinoByNumDoc($data["num_doc"])->first(); //buscar funcion
				if($padrino){
					$data["report_rows"] = CalendarioPago::getCalendarioByPadrino($padrino->idpadrinos)->get(); 
					return View::make('padrinos/pagoPadrinoReporte',$data);
				}
				else{
					Session::flash('danger','No existe un padrino asociado a dicho número de documento.'); 
					return Redirect::to('padrinos/reporte_pagos_padrinos'); 
				}
			}
		}	
		else{
			return View::make('error/error');
		}
	}	
	}

}
