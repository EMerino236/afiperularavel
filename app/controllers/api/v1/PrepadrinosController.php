<?php namespace api\v1;

use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class PrepadrinosController extends \BaseController {


	public function store()
	{
		$rules = array('nombre' => 'required',
                       'apellido_paterno' => 'required',
                       'apellido_materno' => 'required',
                       'dni' => 'required',
                       'fecha_de_nacimiento' => 'required',
                       'e_mail' => 'required',
                       'idperiodo_pagos' => 'required',
        );
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->passes())
        {
            $prepadrino = new \Prepadrino;
            $prepadrino->nombres = Input::get('nombre');
            $prepadrino->apellido_pat = Input::get('apellido_paterno');
            $prepadrino->apellido_mat = Input::get('apellido_materno');
            $prepadrino->dni = Input::get('dni');
            $prepadrino->fecha_nacimiento = date('Y-m-d',strtotime(Input::get('fecha_de_nacimiento')));
            $prepadrino->email = Input::get('e_mail');
            $prepadrino->como_se_entero = Input::get('como_se_entero_del_programa');
            $prepadrino->idperiodo_pagos = Input::get('idperiodo_pagos');
            $prepadrino->save();
            return Response::json(['success' => 1], 200);
        }
        else return Response::json($validator->messages(), 200);
	}

}
