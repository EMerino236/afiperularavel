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
				return View::make('error/error');
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
				return View::make('error/error');
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
							'titulo' => 'required',
							'resenha' => 'required'
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

					Session::flash('message', 'Se registró correctamente al concurso.');
					
					return Redirect::to('concursos/create_concurso');
				}
			}else{
				return View::make('error/error');
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
				$data["concursos_data"] = Concurso::getConcursosInfo()->paginate(10);
				return View::make('concursos/listConcursos',$data);
			}else{
				return View::make('error/error');
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
				$data["concursos_data"] = Concurso::searchConcursos($data["search"])->paginate(10);
				return View::make('concursos/listConcursos',$data);
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
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivo);
				    	/* Creo el documento */
						$documento = new Documento;
						$documento->titulo = $nombreArchivo;
						$documento->idtipo_documentos = 1; 
						$documento->nombre_archivo = $nombreArchivo;
						$documento->ruta = $rutaDestino;
						$documento->save();
						/* Creo la relación de concurso con documento */
						$documentos_concurso = new DocumentosConcurso;
						$documentos_concurso->idconcursos = $idconcursos;
						$documentos_concurso->iddocumentos = $documento->iddocumentos;
						$documentos_concurso->save();
						
				    }
					
					Session::flash('message', 'Se subió correctamente el archivo.');				
					return Redirect::to('concursos/upload_file/'.$idconcursos);
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
					$documento->delete();
					$documentos_concurso->delete();
					Session::flash('message', 'Se eliminó correctamente el archivo.');				
					return Redirect::to('concursos/upload_file/'.$idconcursos);
				}
			}else{
				return View::make('error/error');
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
		        return Response::download($rutaDestino,basename($rutaDestino),$headers);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}