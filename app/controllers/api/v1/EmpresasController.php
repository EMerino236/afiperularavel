<?php namespace api\v1;

use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class EmpresasController extends \BaseController {

	public function store()
	{
		$rules = array('nombre_representante' => 'required',
                       'razon_social' => 'required',
                       'email' => 'required',
                       'sector' => 'required',
        );
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->passes())
        {
            $empresa = new \Empresa;
            $empresa->nombre_representante = Input::get('nombre_representante');
            $empresa->razon_social = Input::get('razon_social');
            $empresa->email = Input::get('email');
            $empresa->telefono = Input::get('telefono');
            $empresa->sector = Input::get('sector');
            $empresa->intereses = Input::get('intereses');
            $empresa->save();
            return Response::json(['success' => 1], 200);
        }
        else return Response::json($validator->messages(), 200);
	}


}
