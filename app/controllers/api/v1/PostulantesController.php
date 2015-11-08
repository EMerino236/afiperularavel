<?php namespace api\v1;

use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class PostulantesController extends \BaseController {

	public function store()
	{
		$rules = array('nombre' => 'required',
                       'apellido_paterno' => 'required',
                       'apellido_materno' => 'required',
                       'dni' => 'required',
                       'fecha_de_nacimiento' => 'required',
                       'e_mail' => 'required',
        );
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->passes())
        {
            $postulante = new \Postulante;
            $postulante->nombres = Input::get('nombre');
            $postulante->apellido_pat = Input::get('apellido_paterno');
            $postulante->apellido_mat = Input::get('apellido_materno');
            $postulante->num_documento = Input::get('dni');
            $postulante->fecha_nacimiento = date('Y-m-d',strtotime(Input::get('fecha_de_nacimiento')));
            $postulante->email = Input::get('e_mail');
            $postulante->direccion = Input::get('direccion');
            $postulante->telefono = Input::get('telefono');
            $postulante->celular = Input::get('celular');
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
