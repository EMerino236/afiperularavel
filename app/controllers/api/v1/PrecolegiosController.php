<?php namespace api\v1;

use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class PrecolegiosController extends \BaseController {

	public function store()
	{
		$rules = array('nombre' => 'required',
                       'direccion' => 'required',
                       'nombre_contacto' => 'required',
                       'e_mail_contacto' => 'required',
                       'telefono_contacto' => 'required',
                       'interes' => 'required',
                       'latitud' => 'required',
                       'longitud' => 'required',
        );
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->passes())
        {
            $precolegio = new \Precolegio;
            $precolegio->nombre = Input::get('nombre');
            $precolegio->direccion = Input::get('direccion');
            $precolegio->nombre_contacto = Input::get('nombre_contacto');
            $precolegio->email_contacto = Input::get('e_mail_contacto');
            $precolegio->telefono_contacto = Input::get('telefono_contacto');
            $precolegio->interes = Input::get('interes');
            $precolegio->latitud = Input::get('latitud');
            $precolegio->longitud = Input::get('longitud');
            $precolegio->save();
            return Response::json(['success' => 1], 200);
        }
        else return Response::json($validator->messages(), 200);
	}

}
