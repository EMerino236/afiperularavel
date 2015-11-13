<?php

class VoluntariosController extends BaseController
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('nav_voluntarios',$data["permisos"])){
				return View::make('voluntarios/home',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function list_Voluntarios()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_voluntarios',$data["permisos"])){
				$data["search"] = null;
				$data["voluntarios_data"] = UsersPerfil::getVoluntariosInfo();
				return View::make('voluntarios/listVoluntarios',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_view_voluntario($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if((in_array('side_listar_voluntarios',$data["permisos"])) && $id){
				$data["user_info"] = User::searchUserById($id)->get();
				if($data["user_info"]->isEmpty()){
					Session::flash('error', 'No se encontró al voluntario.');
					return Redirect::to('voluntario/list_voluntarios');
				}
				$data["user_info"] = $data["user_info"][0];
				$data["perfiles"] = User::getPerfilesPorUsuario($data["user_info"]->id)->get();
				return View::make('voluntarios/viewVoluntario',$data);
			}else{
				return View::make('error/error');
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
				$data["search"] = Input::get('search');
				$data["voluntarios_data"] = UsersPerfil::searchVoluntariosInfo($data["search"]);
				return View::make('voluntarios/listVoluntarios',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_repostulacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_mis_eventos',$data["permisos"])){
				$data["user_perfil"] = null;
				$data["periodo_actual"] = null;
				$data["usuario_ya_inscrito"] = true;
				$user_periodo = new UsersPeriodo;
				$user_periodo->idusers = Input::get('user_id');
				$user_periodo->idperiodos = Input::get('idperiodos');
				$user_periodo->save();

				// Llamo a la función para registrar el log de auditoria
				$descripcion_log = "Se creó el usuario por periodo con id {{$user_periodo->idusers_periodos}}";
				Helpers::registrarLog(3,$descripcion_log);

				Session::flash('message',"Se ha registrado correctamente su postulación al nuevo período.");
				return Redirect::to('/dashboard');
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function list_reporte_calificaciones()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_reporte_asistencia',$data["permisos"])){
				$data["search_periodo"] = 0;
				$data["search_usuario"] = null;
				$data["periodos"]=Periodo::lists('nombre','idperiodos');
				$data["eventos_asistencia"] = Asistencia::getEventosAsistencia()->get();
				$data["voluntarios_data"] = UsersPerfil::getVoluntariosReporteInfo();
				return View::make('voluntarios/reporteCalificaciones',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_reporte_calificaciones()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_reporte_asistencia',$data["permisos"])){
				$data["search_periodo"] = Input::get('search_periodo');
				$data["search_usuario"] = Input::get('search_usuario');	
				$data["periodos"]=Periodo::lists('nombre','idperiodos');
				$data["eventos_asistencia"] = Asistencia::getEventosAsistencia()->get();
				$data["voluntarios_data"] = UsersPerfil::searchVoluntariosReporteInfo($data["search_periodo"],$data["search_usuario"]);
				return View::make('voluntarios/reporteCalificaciones',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_asistencia_excel()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_reporte_asistencia',$data["permisos"])){
				$data["search_periodo"] = Input::get('search_periodo_excel');
				$data["search_usuario"] = Input::get('search_usuario_excel');	
				$data["periodos"]=Periodo::lists('nombre','idperiodos');
				$periodo = Periodo::find($data["search_periodo"]);
				$eventos_asistencia = Asistencia::getEventosAsistencia()->get();
				$voluntarios_data = UsersPerfil::searchVoluntariosReporteInfo($data["search_periodo"],$data["search_usuario"]);
				
				
				$str_table = "<table><tr><td></td><td></td><td></td><td><strong>Reporte de Asistencia</strong></td></tr></table>";
				if($periodo==null) $str_table .= "<table><tr><td><strong>Periodo</strong></td><td>Todos</td></tr><tr></tr></table>";
				else $str_table .= "<table><tr><td><strong>Periodo:</strong></td><td>".$periodo->nombre."</td></tr><tr></tr></table>";				
				$str_table .= "<table border=1><tr><th>Periodo</th><th>Doc. de Identidad</th><th>Nombre</th><th>Eventos Programados</th><th>Eventos que Asistio</th><th>% Asistencia</th><th>Promedio Calificacion</th></tr>";
				if($voluntarios_data !=null){					
					foreach($voluntarios_data as $voluntario_data){
						$eventos_total =0;
				    	$eventos_asistidos=0;
						$str_table .= "<tr><td>".htmlentities($voluntario_data->nombre_periodo)."</td><td>".htmlentities($voluntario_data->num_documento)."</td><td>".htmlentities($voluntario_data->apellido_pat.' '.$voluntario_data->apellido_mat.', '.$voluntario_data->nombre_persona)."</td><td>";
						foreach($eventos_asistencia as $asistencia){
							if($asistencia->idusers == $voluntario_data->id){
								$str_table.="-".htmlentities($asistencia->nombre)."<br>";								
								$eventos_total++;									
							}
						}
						$str_table.="</td><td>";
						foreach($eventos_asistencia as $asistencia){
							if($asistencia->idusers == $voluntario_data->id){
								if($asistencia->asistio ==1){
									$str_table.="-".htmlentities($asistencia->nombre)."<br>";																				
									$eventos_asistidos++;									
								}
							}
						}						
						$str_table.="</td><td>".htmlentities(round(($eventos_asistidos/$eventos_total)*100,2))."%</td><td>".htmlentities(round($voluntario_data->prom_calificaciones),2)."</td></tr>";
					}
				}
				$str_table .= "</table>";

				$filename = "reporte_asistencia".date('Y-m-d').".xls";
				// Show the download dialog
				header("Content-type: application/vnd.ms-excel; charset=utf-8");
				// Let's indicate to the browser we are giving it the file
				header("Content-Disposition: attachment; filename=\"$filename\"");
				// Avoid the browser to save the file into it's cache
				header("Pragma: no-cache");
				header("Expires: 0");
				// Render the table
				echo $str_table;

			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_mapa_calor()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			if(in_array('side_listar_voluntarios',$data["permisos"])){
				return View::make('voluntarios/mapaCalor',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}
