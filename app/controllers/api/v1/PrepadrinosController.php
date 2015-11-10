<?php namespace api\v1;

use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class PrepadrinosController extends \BaseController {


	public function store()
	{
		$rules = array('nombres' => 'required',
                       'apellido_pat' => 'required',
                       'apellido_mat' => 'required',
                       'dni' => 'required',
                       'fecha_nacimiento' => 'required',
                       'email' => 'required',
                       'idperiodo_pagos' => 'required',
        );
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->passes())
        {
            $prepadrino = new \Prepadrino;
            $prepadrino->nombres = Input::get('nombres');
            $prepadrino->apellido_pat = Input::get('apellido_pat');
            $prepadrino->apellido_mat = Input::get('apellido_mat');
            $prepadrino->dni = Input::get('dni');
            $prepadrino->fecha_nacimiento = date('Y-m-d',strtotime(Input::get('fecha_nacimiento')));
            $prepadrino->email = Input::get('email');
            $prepadrino->como_se_entero = Input::get('como_se_entero_del_programa');
            $prepadrino->idperiodo_pagos = Input::get('idperiodo_pagos');
            $prepadrino->telefono = Input::get('telefono');
            $prepadrino->celular = Input::get('celular');
            $prepadrino->direccion = Input::get('direccion');
            $prepadrino->save();
            return Response::json(['success' => 1], 200);
        }
        else{
          $log = new LogAuditoria;
          $log->idtipo_logs = 1;
          $log->descripcion = $validator->messages();
          $log->users_id = 1;
          $log->save(); 
          return Response::json($validator->messages(), 200);
        } 
	}

}
