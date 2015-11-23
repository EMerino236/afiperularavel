<?php
class EmpresasController extends BaseController
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('nav_empresas',$data["permisos"])){
				return View::make('empresas/home',$data);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function list_empresas()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_empresas',$data["permisos"])){
				$data["search"] = null;
				$data["empresas_data"] = Empresa::getEmpresasInfo()->paginate(10);
				return View::make('empresas/listEmpresas',$data);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_empresa()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_empresas',$data["permisos"])){
				$data["search"] = Input::get('search');
			    $data["empresas_data"] = Empresa::searchEmpresas($data["search"])->paginate(10);
				return View::make('empresas/listEmpresas',$data);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_empresa($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_listar_empresas',$data["permisos"])) && $id){
				$data["empresa_info"] = Empresa::searchEmpresaById($id)->get();
				if($data["empresa_info"]->isEmpty()){
					Session::flash('error', 'No se encontró a la empresa.');
					return Redirect::to('empresas/list_empresas');
				}
				$data["empresa_info"] = $data["empresa_info"][0];
				return View::make('empresas/editEmpresa',$data);
			}else{
				$descripcion_log = "Se intentó acceder a la ruta '".Request::path()."' por el método '".Request::method()."'";
				Helpers::registrarLog(10,$descripcion_log);
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_empresa()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_empresas',$data["permisos"])){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'nombre_representante' => 'Nombre del Representante',
							'sector' => 'Sector Empresarial',
							'email' => 'Email de contacto',
							'telefono' => 'Teléfono de contacto',
							'intereses' => 'Intereses',
						);
				$messages = array();
				$rules = array(
							'nombre_representante' => 'required|min:2|max:100|alpha_spaces',
							'sector' => 'required|alpha_spaces|min:2|max:100',
							'email' => 'required|email|max:45',
							'telefono' => 'required|min:7|max:20|regex:/(^[0-9])/',
							'intereses' => 'required|max:200',
						);
				
				$empresa_id = Input::get('idempresas');
				$url = "empresas/edit_empresa"."/".$empresa_id;
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$empresa = Empresa::find($empresa_id);
					$empresa->nombre_representante = Input::get('nombre_representante');
					$empresa->intereses = Input::get('intereses');
					$empresa->email = Input::get('email');
					$empresa->telefono = Input::get('telefono');
					$empresa->sector = Input::get('sector');
					$empresa->save();
					$descripcion_log = "Se editó la empresa con id {{$empresa->idempresas}}";
					Helpers::registrarLog(4,$descripcion_log);
					
					Session::flash('message', 'Se editó correctamente la empresa.');
					
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


	public function submit_disable_empresa()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_empresas',$data["permisos"])){
				$empresa_id = Input::get('empresa_id');
				$url = "empresas/edit_empresa/".$empresa_id;
				$empresa = Empresa::find($empresa_id);
				$empresa->delete();
				$descripcion_log = "Se eliminó la empresa con id {{$empresa_id}}";
				Helpers::registrarLog(5,$descripcion_log);
				Session::flash('message', 'Se inhabilitó correctamente la empresa.');
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

	public function submit_enable_empresa()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_empresas',$data["permisos"])){
				$empresa_id = Input::get('empresa_id');
				$url = "empresas/edit_empresa/".$empresa_id;
				$empresa = Empresa::withTrashed()->find($empresa_id);
				$empresa->restore();
				$descripcion_log = "Se habilitó la empresa con id {{$empresa_id}}";
				Helpers::registrarLog(6,$descripcion_log);
				Session::flash('message', 'Se habilitó correctamente la empresa.');
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