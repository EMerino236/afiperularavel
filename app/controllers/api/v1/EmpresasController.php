<?php namespace api\v1;

use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class EmpresasController extends \BaseController {

	public function store()
	{
		$rules = array('nombre_del_representante' => 'required',
                       //'razon_social' => 'required',
                       'e_mail' => 'required',
                       'sector_empresarial' => 'required',
        );
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->passes())
        {
            $empresa = new \Empresa;
            $empresa->nombre_representante = Input::get('nombre_del_representante');
            //$empresa->razon_social = Input::get('razon_social');
            $empresa->email = Input::get('e_mail');
            $empresa->telefono = Input::get('telefono');
            $empresa->sector = Input::get('sector_empresarial');
            $empresa->intereses = Input::get('intereses');
            $empresa->save();
            return Response::json(['success' => 1], 200);
        }
        else return Response::json($validator->messages(), 200);
	}


}
