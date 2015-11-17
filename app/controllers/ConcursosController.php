<?php

class ConcursosController extends BaseController
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('nav_concursos',$data["permisos"])){
				return View::make('concursos/home',$data);
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

	public function render_create_concurso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_concurso',$data["permisos"])){
				
				return View::make('concursos/createConcursos',$data);
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

	public function submit_create_concurso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_concurso',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$rules = array(
							'titulo' => 'required|min:2|max:100|unique:concursos'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('concursos/create_concurso')->withErrors($validator)->withInput(Input::all());
				}else{
					// Creo primero a la persona
					$concurso = new Concurso;
					$concurso->titulo = Input::get('titulo');
					$concurso->resenha = Input::get('resenha');
					
					$concurso->save();
					// Creo al usuario y le asigno su información de persona

					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se creó el concurso con id {{$concurso->idconcursos}}";
					Helpers::registrarLog(3,$descripcion_log);
					Session::flash('message', 'Se registró correctamente al concurso.');
					
					return Redirect::to('concursos/create_concurso');
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

	public function list_concursos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_concursos',$data["permisos"])){
				$data["search"] = null;
				//$data["concursos_data"] = Concurso::getConcursosInfo()->paginate(10);

				$sortby = Input::get('sortby');
			    $order = Input::get('order');
			    $data["sortby"] = $sortby;
			    $data["order"] = $order;
			    if ($sortby && $order) {
			        $data["concursos_data"] =Concurso::getConcursosInfo()->orderBy($sortby, $order)->paginate(10);
			    } else {
			        $data["concursos_data"] = Concurso::getConcursosInfo()->paginate(10);
			    }

				return View::make('concursos/listConcursos',$data);
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

	public function search_concurso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_concursos',$data["permisos"])){
				$data["search"] = Input::get('search');
				//$data["concursos_data"] = Concurso::searchConcursos($data["search"])->paginate(10);
				$sortby = Input::get('sortby');
			    $order = Input::get('order');
			    $data["sortby"] = $sortby;
			    $data["order"] = $order;
			    if ($sortby && $order) {
			        $data["concursos_data"] = Concurso::searchConcursos($data["search"])->orderBy($sortby, $order)->paginate(10);
			    } else {
			       $data["concursos_data"] = Concurso::searchConcursos($data["search"])->paginate(10);
			    }
				return View::make('concursos/listConcursos',$data);
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
			if((in_array('side_nuevo_concurso',$data["permisos"])) && $id){
				$data["concurso_info"] = Concurso::searchConcursosById($id)->get();
				if($data["concurso_info"]->isEmpty()){
					Session::flash('error', 'No se encontró el concurso.');
					return Redirect::to('concursos/list_concursos');
				}
				$data["concurso_info"] = $data["concurso_info"][0];
				$data["documentos"] = DocumentosConcurso::getDocumentosPorConcurso($data["concurso_info"]->idconcursos)->get();
				
				$data["hoy"] = date("Y-m-d H:i:s");
				return View::make('concursos/uploadFile',$data);
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
			if(in_array('side_nuevo_concurso',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$rules = array(
							'archivo' => 'required|max:15360|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$idconcursos = Input::get('idconcursos');
				if($validator->fails()){
					return Redirect::to('concursos/upload_file/'.$idconcursos)->withErrors($validator)->withInput(Input::all());
				}else{
				    if(Input::hasFile('archivo')){
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'files/concursos/';
				        $nombreArchivo = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $peso = $archivo->getSize();
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    	/* Creo el documento */
						$documento = new Documento;
						$documento->titulo = $nombreArchivo;
						$documento->idtipo_documentos = 4; 
						$documento->nombre_archivo = $nombreArchivoEncriptado;
						$documento->peso = $peso;
						$documento->ruta = $rutaDestino;
						$documento->save();
						/* Creo la relación de concurso con documento */
						$documentos_concurso = new DocumentosConcurso;
						$documentos_concurso->idconcursos = $idconcursos;
						$documentos_concurso->iddocumentos = $documento->iddocumentos;
						$documentos_concurso->save();
						
				    }
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se subió el archivo con id {{$documento->iddocumentos}} para el concurso con id {{$documentos_concurso->idconcursos}}";
					Helpers::registrarLog(7,$descripcion_log);
					Session::flash('message', 'Se subió correctamente el archivo.');				
					return Redirect::to('concursos/upload_file/'.$idconcursos);
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
			if(in_array('side_nuevo_concurso',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$rules = array(
							'iddocumentos_concursos' => 'required',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$idconcursos = Input::get('idconcursos');
				if($validator->fails()){
					return Redirect::to('concursos/upload_file/'.$idconcursos)->withErrors($validator)->withInput(Input::all());
				}else{
					/* Elimino el documento y la relación con el concurso */
					$documentos_concurso = DocumentosConcurso::find(Input::get('iddocumentos_concursos'));
					$documento = Documento::find($documentos_concurso->iddocumentos);
					$documentos_concurso->delete();
					$documento->delete();					
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se eliminó el archivo con id {{$documento->iddocumentos}} para el concurso con id {{$documentos_concurso->idconcursos}}";
					Helpers::registrarLog(8,$descripcion_log);
					Session::flash('message', 'Se eliminó correctamente el archivo.');				
					return Redirect::to('concursos/upload_file/'.$idconcursos);
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

	public function submit_descargar_documento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_concurso',$data["permisos"])){
				$idconcursos = Input::get('idconcursos');
				$iddocumentos = Input::get('iddocumentos');
				
				$documento = Documento::find($iddocumentos);
				$rutaDestino = $documento->ruta.$documento->nombre_archivo;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        // Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se descargó el archivo con id {{$documento->iddocumentos}} para el concurso con id {{$idconcursos}}";
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



	public function render_fases_concurso($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_concurso',$data["permisos"])) && $id){
				$data["concurso_info"] = Concurso::searchConcursosById($id)->get();
				if($data["concurso_info"]->isEmpty()){
					Session::flash('error', 'No se encontró el concurso.');
					return Redirect::to('concursos/list_concursos');
				}
				$data["concurso_info"] = $data["concurso_info"][0];
				$data["faseconcursos_data"] = FasesConcurso::getFasesPorConcurso($data["concurso_info"]->idconcursos)->orderBy('fecha_limite','asc')->paginate(10);
				
				$data["hoy"] = date("Y-m-d H:i:s");
				return View::make('concursos/fasesConcurso',$data);
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

	public function fase_register_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}

		if(Auth::check()){
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			$data["user_info"] = User::searchUserById($data["user"]->id)->get();
			if(in_array('side_nuevo_concurso',$data["permisos"])){
				$fecha_limite = date('Y-m-d H:i:s',strtotime(Input::get('fecha_limite')));
				$idconcursos = Input::get('idconcursos');
				$fecha_disponible = FasesConcurso::getFechaDisponible($idconcursos,$fecha_limite)->get();
				if($fecha_disponible->isEmpty()){
					$fecha_disponible =null;
					$fase_concursos = new FasesConcurso;
					$fase_concursos->titulo = Input::get('titulo');
					$fase_concursos->descripcion = Input::get('descripcion');
					$fase_concursos->fecha_limite = $fecha_limite;
					$fase_concursos->idconcursos = Input::get('idconcursos');
					$fase_concursos->save();
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se creó la fase con id {{$fase_concursos->idfase_concursos}} para el concurso con id {{$fase_concursos->idconcursos}}";
					Helpers::registrarLog(3,$descripcion_log);
				}
				return Response::json(array( 'success' => true,'fecha_disponible'=>$fecha_disponible),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function fase_delete_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}

		if(Auth::check()){
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			$data["user_info"] = User::searchUserById($data["user"]->id)->get();
			if(in_array('side_nuevo_concurso',$data["permisos"])){
				
				$idfase_concursos = Input::get('idfase');
				$fase_concursos = FasesConcurso::find($idfase_concursos);

				$fase_concursos->delete(); 
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se eliminó la fase con id {{$fase_concursos->idfase_concursos}} para el concurso con id {{$fase_concursos->idconcursos}}";
				Helpers::registrarLog(5,$descripcion_log);
				return Response::json(array( 'success' => true,'faseconcursos_data'=>$fase_concursos),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}


	public function render_edit_concurso($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_concurso',$data["permisos"])) && $id){
				$data["concurso_info"] = Concurso::searchConcursosById($id)->get();
				if($data["concurso_info"]->isEmpty()){
					Session::flash('error', 'No se encontró al concurso.');
					return Redirect::to('concursos/list_concursos');
				}
				
				$data["concurso_info"] = $data["concurso_info"][0];
				return View::make('concursos/editConcurso',$data);
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

	public function submit_edit_concurso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_concurso',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$concurso_id = Input::get('concurso_id');
				$rules = array(
							'titulo' => 'required|min:2|max:100|unique:concursos,titulo,'.$concurso_id.',idconcursos'							
						);
				// Run the validation rules on the inputs from the form
				
				$url = "concursos/edit_concurso"."/".$concurso_id;
				$validator = Validator::make(Input::all(), $rules);
				
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$concurso = Concurso::find($concurso_id);
					$concurso->titulo = Input::get('titulo');
					$concurso->resenha = Input::get('resenha');
					
					$concurso->save();
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se editó el concurso con id {{$concurso->idconcursos}}";
					Helpers::registrarLog(4,$descripcion_log);
					Session::flash('message', 'Se editó correctamente el concurso.');
					
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

	public function submit_disable_concurso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_concurso',$data["permisos"])){
				$concurso_id = Input::get('idconcursos');
				$url = "concursos/list_concursos";
				$concurso = Concurso::find($concurso_id);
				$concurso->delete();
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se eliminó el concurso con id {{$concurso->idconcursos}}";
				Helpers::registrarLog(5,$descripcion_log);
				Session::flash('message', 'Se eliminó correctamente al concurso.');
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


	public function render_create_proyecto()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_proyecto',$data["permisos"])){
				$data["concursos_data"] = Concurso::getLatestConcursos()->get();//->lists('titulo','idconcursos');
				
				$indice =0;
				foreach ($data["concursos_data"] as $concurso) {
					$minfecha = FasesConcurso::getFasesPorConcurso($concurso->idconcursos)->orderBy('fecha_limite','asc')->take(1)->get();
					$minfecha = $minfecha[0];
					if($minfecha->fecha_limite<date('Y-m-d') || $concurso->aprobacion !=0){
						unset($data["concursos_data"][$indice]);						
					}					
					$indice++;
				}
				//if($data["concursos_data"]){
				//	$data["concursos_data"] = array_values($data["concursos_data"]);
				//}
				$data["concursos_data"] = $data["concursos_data"]->lists('titulo','idconcursos');
				return View::make('concursos/createProyectos',$data);
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

	public function submit_create_proyecto()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_proyecto',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|min:2|max:100|unique:proyectos',
							'jefe_proyecto' => 'required|min:2|max:100',
							'concursos' => 'required'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('concursos/create_proyecto')->withErrors($validator)->withInput(Input::all());
				}else{
					// Creo primero a la persona
					$proyecto = new Proyecto;
					$proyecto->nombre = Input::get('nombre');
					$proyecto->resenha = Input::get('resenha');
					$proyecto->idconcursos = Input::get('concursos');
					$proyecto->jefe_proyecto = Input::get('jefe_proyecto');
					$proyecto->aprobacion = 0;

					$proyecto->save();
					// Creo al usuario y le asigno su información de persona

					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se creó el proyecto con id {{$proyecto->idproyectos}}";
					Helpers::registrarLog(3,$descripcion_log);
					Session::flash('message', 'Se registró correctamente el proyecto.');
					
					return Redirect::to('concursos/create_proyecto');
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

	public function list_proyectos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_proyectos',$data["permisos"])){
				$data["search"] = null;
				$data["concursos_data"] = null;//Concurso::getConcursosInfo()->paginate(10);
				$data["aprobacion"]=null;
				$data["aprobar"] = 0;
				$sortby = Input::get('sortby');
			    $order = Input::get('order');
			    $data["sortby"] = $sortby;
			    $data["order"] = $order;
			    if ($sortby && $order) {
			        $data["proyectos_data"] =Proyecto::getProyectosInfo()->orderBy($sortby, $order)->paginate(10);
			    } else {
			        $data["proyectos_data"] = Proyecto::getProyectosInfo()->paginate(10);
			    }

				return View::make('concursos/listProyectos',$data);
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

	public function search_proyecto()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_proyectos',$data["permisos"])){
				$data["search"] = Input::get('search');
				$data["aprobar"] = Input::get('aprobar');
				
				if($data["aprobar"] ==1){
					$id = Input::get('idconcursos');
					$data["aprobacion"] = Proyecto::getAprobacion($id)->get();
					if(!$data["aprobacion"]->isEmpty()){
						$data["aprobacion"] = $data["aprobacion"][0];
					}
					else{
						$data["aprobacion"] = null;
					}
					$data["concursos_data"] = Concurso::find($id);
				}
				else{
					$id=0;
					$data["concursos_data"] = null;//Concurso::getConcursosInfo()->paginate(10);
					$data["aprobacion"]=null;
				}
				//$data["concursos_data"] = Concurso::searchConcursos($data["search"])->paginate(10);
				$sortby = Input::get('sortby');
			    $order = Input::get('order');
			    $data["sortby"] = $sortby;
			    $data["order"] = $order;
			    if ($sortby && $order) {
			        $data["proyectos_data"] = Proyecto::searchProyectos($data["search"],$id)->orderBy($sortby, $order)->paginate(10);
			    } else {
			       $data["proyectos_data"] = Proyecto::searchProyectos($data["search"],$id)->paginate(10);
			    }
				return View::make('concursos/listProyectos',$data);
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

	public function render_edit_proyecto($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_proyecto',$data["permisos"])) && $id){
				$data["proyecto_info"] = Proyecto::searchProyectosById($id)->get();
				if($data["proyecto_info"]->isEmpty()){
					Session::flash('error', 'No se encontró el proyecto.');
					return Redirect::to('concursos/list_proyectos');
				}
				$data["concursos_data"] = Concurso::getLatestConcursos()->get();//->lists('titulo','idconcursos');
				$data["proyecto_info"] = $data["proyecto_info"][0];
				$indice =0;
				foreach ($data["concursos_data"] as $concurso) {
					$minfecha = FasesConcurso::getFasesPorConcurso($concurso->idconcursos)->orderBy('fecha_limite','asc')->take(1)->get();
					$minfecha = $minfecha[0];
					if(($minfecha->fecha_limite<date('Y-m-d') || $concurso->aprobacion !=0) && ($data["proyecto_info"]->idconcursos!=$concurso->idconcursos )){
						unset($data["concursos_data"][$indice]);						
					}					
					$indice++;
				}
				//if($data["concursos_data"]){
				//	$data["concursos_data"] = array_values($data["concursos_data"]);
				//}
				$data["concursos_data"] = $data["concursos_data"]->lists('titulo','idconcursos');
				
				return View::make('concursos/editProyecto',$data);
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

	public function submit_edit_proyecto()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_proyecto',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'nombre' => 'Nombre Proyecto',
							'jefe_proyecto' => 'Nombre Jefe Proyecto',
							'concursos' => 'Concurso'							
						);
				$messages = array();
				$proyecto_id = Input::get('proyecto_id');
				$rules = array(
							'nombre' => 'required|min:2|max:100|unique:proyectos,nombre,'.$proyecto_id.',idproyectos',
							'jefe_proyecto' => 'required|min:2|max:100',
							'concurso' => 'required'						
						);
				// Run the validation rules on the inputs from the form
				
				$url = "concursos/edit_proyecto"."/".$proyecto_id;
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{	
					$proyecto = Proyecto::find($proyecto_id);
					$proyecto->nombre = Input::get('nombre');
					$proyecto->jefe_proyecto = Input::get('jefe_proyecto');
					$proyecto->idconcursos = Input::get('concursos');
					$proyecto->resenha = Input::get('resenha');
					
					$proyecto->save();
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se editó el proyecto con id {{$proyecto->idproyectos}}";
					Helpers::registrarLog(4,$descripcion_log);
					Session::flash('message', 'Se editó correctamente el proyecto.');
					
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

	public function submit_disable_proyecto()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_proyecto',$data["permisos"])){
				$proyecto_id = Input::get('proyecto_id');
				$url = "concursos/list_proyectos";
				$proyecto = Proyecto::find($proyecto_id);
				$proyecto->delete();
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se eliminó el proyecto con id {{$proyecto->idproyectos}}";
				Helpers::registrarLog(5,$descripcion_log);
				Session::flash('message', 'Se eliminó correctamente el proyecto.');
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

	public function render_upload_file_proyecto($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_proyecto',$data["permisos"])) && $id){
				$data["proyecto_info"] = Proyecto::find($id)->get();
				if($data["proyecto_info"]->isEmpty()){
					Session::flash('error', 'No se encontró el proyecto.');
					return Redirect::to('concursos/list_proyectos');
				}
				$data["proyecto_info"] = $data["proyecto_info"][0];
				$data["documentos"] = DocumentosProyecto::getDocumentosPorProyecto($data["proyecto_info"]->idproyectos)->get();
				
				$data["hoy"] = date("Y-m-d H:i:s");
				return View::make('concursos/uploadFileProyecto',$data);
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

	public function submit_upload_file_proyecto()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_proyecto',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$rules = array(
							'archivo' => 'required|max:15360|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$idproyectos = Input::get('idproyectos');
				if($validator->fails()){
					return Redirect::to('concursos/upload_file_proyecto/'.$idproyectos)->withErrors($validator)->withInput(Input::all());
				}else{
				    if(Input::hasFile('archivo')){
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'files/proyectos/';
				        $nombreArchivo = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $peso = $archivo->getSize();
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    	/* Creo el documento */
						$documento = new Documento;
						$documento->titulo = $nombreArchivo;
						$documento->idtipo_documentos = 5; 
						$documento->nombre_archivo = $nombreArchivoEncriptado;
						$documento->peso = $peso;
						$documento->ruta = $rutaDestino;
						$documento->save();
						/* Creo la relación de concurso con documento */
						$documentos_proyecto = new DocumentosProyecto;
						$documentos_proyecto->idproyectos = $idproyectos;
						$documentos_proyecto->iddocumentos = $documento->iddocumentos;
						$documentos_proyecto->save();
						
				    }
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se subió el archivo con id {{$documento->iddocumentos}} para el proyecto con id {{$documentos_proyecto->idproyectos}}";
					Helpers::registrarLog(7,$descripcion_log);
					Session::flash('message', 'Se subió correctamente el archivo.');				
					return Redirect::to('concursos/upload_file_proyecto/'.$idproyectos);
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

	public function submit_delete_file_proyecto()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_proyecto',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$rules = array(
							'iddocumentos_proyectos' => 'required',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$idproyectos = Input::get('idproyectos');
				if($validator->fails()){
					return Redirect::to('concursos/upload_file_proyecto/'.$idproyectos)->withErrors($validator)->withInput(Input::all());
				}else{
					/* Elimino el documento y la relación con el concurso */
					$documentos_proyecto = DocumentosProyecto::find(Input::get('iddocumentos_proyectos'));
					$documento = Documento::find($documentos_proyecto->iddocumentos);
					$documentos_proyecto->delete();
					$documento->delete();					
					// Llamo a la función para registrar el log de auditoria
					$descripcion_log = "Se eliminó el archivo con id {{$documento->iddocumentos}} para el proyecto con id {{$documentos_proyecto->idproyectos}}";
					Helpers::registrarLog(8,$descripcion_log);
					Session::flash('message', 'Se eliminó correctamente el archivo.');				
					return Redirect::to('concursos/upload_file_proyecto/'.$idproyectos);
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

	public function render_detalle_proyecto($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_proyecto',$data["permisos"])) && $id){
				$data["proyecto_info"] = Proyecto::find($id);
				
				$data["detalles_proyecto"] = DetalleProyecto::getDetallePorProyecto($data["proyecto_info"]->idproyectos)->paginate(10);
				
				$data["hoy"] = date("Y-m-d H:i:s");
				return View::make('concursos/detalleProyecto',$data);
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

	public function detalle_register_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}

		if(Auth::check()){
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			$data["user_info"] = User::searchUserById($data["user"]->id)->get();
			if(in_array('side_nuevo_proyecto',$data["permisos"])){
				

				$detalle_proyecto = new DetalleProyecto;
				$detalle_proyecto->titulo = Input::get('titulo');
				$detalle_proyecto->presupuesto = Input::get('presupuesto');				
				$detalle_proyecto->gasto_real = Input::get('gasto_real');
				$detalle_proyecto->idproyectos = Input::get('idproyectos');
				$detalle_proyecto->save();
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se creó el detalle con id {{$detalle_proyecto->iddetalle_proyectos}} para el proyecto con id {{$detalle_proyecto->idproyectos}}";
				Helpers::registrarLog(3,$descripcion_log);
				return Response::json(array( 'success' => true,'detalleproyecto_data'=>$detalle_proyecto),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function detalle_delete_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}

		if(Auth::check()){
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			$data["user_info"] = User::searchUserById($data["user"]->id)->get();
			if(in_array('side_nuevo_proyecto',$data["permisos"])){
				
				$iddetalle_proyectos = Input::get('iddetalle');
				$detalle_proyecto = DetalleProyecto::find($iddetalle_proyectos);

				$detalle_proyecto->delete(); 
				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se eliminó el detalle con id {{$detalle_proyecto->iddetalle_proyectos}} para el proyecto con id {{$detalle_proyecto->idproyectos}}";
				Helpers::registrarLog(5,$descripcion_log);
				return Response::json(array( 'success' => true,'detalleproyecto_data'=>$detalle_proyecto),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function edit_detalle_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}

		if(Auth::check()){
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			$data["user_info"] = User::searchUserById($data["user"]->id)->get();
			if(in_array('side_nuevo_proyecto',$data["permisos"])){
				
				$iddetalle_proyectos = Input::get('iddetalle');
				$detalle_proyecto = DetalleProyecto::find($iddetalle_proyectos);
				$detalle_proyecto->titulo = Input::get('titulo_detalle');
				$detalle_proyecto->presupuesto = Input::get('presupuesto_detalle');				
				$detalle_proyecto->gasto_real = Input::get('gasto_real_detalle');								 
				$detalle_proyecto->save();

				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se editó el detalle con id {{$detalle_proyecto->iddetalle_proyectos}} para el proyecto con id {{$detalle_proyecto->idproyectos}}";
				Helpers::registrarLog(4,$descripcion_log);
				return Response::json(array( 'success' => true,'detalleproyecto_data'=>$detalle_proyecto),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_list_proyectos_asociados($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_nuevo_proyecto',$data["permisos"])) && $id){
				$data["search"] = null;
				$data["aprobacion"] = Proyecto::getAprobacion($id)->get();
				if(!$data["aprobacion"]->isEmpty()){
					$data["aprobacion"] = $data["aprobacion"][0];
				}
				else{
					$data["aprobacion"] = null;
				}
				$data["concursos_data"] = Concurso::find($id);//getConcursosInfo()->paginate(10);searchProyectosByIdConcurso($id)
				$sortby = Input::get('sortby');
			    $order = Input::get('order');
			    $data["sortby"] = $sortby;
			    $data["order"] = $order;
			    if ($sortby && $order) {
			        $data["proyectos_data"] = Proyecto::searchProyectosByIdConcurso($id)->orderBy($sortby, $order)->paginate(10);
			    } else {
			        $data["proyectos_data"] = Proyecto::searchProyectosByIdConcurso($id)->paginate(10);
			    }	
				$data["aprobar"] = 1;
				return View::make('concursos/listProyectos',$data);
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

	public function submit_aprove_proyecto()
	{

		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_nuevo_proyecto',$data["permisos"])){
				
				$selected_ids = Input::get('selected_id');
				$idconcursos = Input::get('idconcursos');
				$selected_ids = $selected_ids[0];
				$proyectos = Proyecto::SearchProyectosByIdConcurso($idconcursos)->get();
				foreach($proyectos as $proyecto){
					if($proyecto->idproyectos == $selected_ids){
						$proyecto->aprobacion = 1;
						$proyecto->save();
						// Llamo a la función para registrar el log de auditoria
						$descripcion_log = "Se aprobó el proyecto con id {{$proyecto->idproyectos}}";
						Helpers::registrarLog(4,$descripcion_log);
					}
					else{
						$proyecto->aprobacion = 2;
						$proyecto->save();
					}
				}

				return Response::json(array( 'success' => true,'proyecto'=>$proyecto),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}	
	}

} 