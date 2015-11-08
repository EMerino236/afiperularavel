<?php namespace api\v1;

use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class PostulantesController extends \BaseController {

	public function store()
	{
		$rules = array('nombres' => 'required',
                       'apellido_pat' => 'required',
                       'apellido_mat' => 'required',
                       'num_documento' => 'required',
                       'fecha_nacimiento' => 'required',
                       'email' => 'required',
        );
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->passes())
        {
            $postulante = new \Postulante;
            $postulante->nombres = Input::get('nombres');
            $postulante->apellido_pat = Input::get('apellido_pat');
            $postulante->apellido_mat = Input::get('apellido_mat');
            $postulante->num_documento = Input::get('num_documento');
            $postulante->fecha_nacimiento = date('Y-m-d',strtotime(Input::get('fecha_nacimiento')));
            $postulante->email = Input::get('email');
            $postulante->direccion = Input::get('direccion');
            $postulante->telefono = Input::get('telefono');
            $postulante->celular = Input::get('celular');
            $postulante->idtipo_identificacion = 1;
            $postulante->centro_estudio_trabajo = Input::get('centro_estudio_trabajo');
            $postulante->ciclo_grado = Input::get('ciclo_grado');
            $postulante->carrera = Input::get('carrera');
            $postulante->experiencia = Input::get('experiencia');
            $postulante->aprendizaje = Input::get('aprendizaje');
            $postulante->motivacion = Input::get('motivacion');
            $postulante->aporte = Input::get('aporte');
            $postulante->expectativas = Input::get('expectativas');
            $postulante->save();
            
            $periodo_actual = \Periodo::getPeriodoActual()->first();
            $postulantexperiodo = new \PostulantesPeriodo;
            $postulantexperiodo->idpostulantes = $postulante->idpostulantes;
            $postulantexperiodo->idperiodos = $periodo_actual->idperiodos;
            $postulantexperiodo->idfases = 1;
            $postulantexperiodo->save();
            
            return Response::json(['success' => 1], 200);
        }
        else return Response::json($validator->messages(), 200);
	}

}
