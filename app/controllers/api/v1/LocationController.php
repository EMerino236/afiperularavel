<?php namespace api\v1;

use \User;
use \Colegio;
use \Illuminate\Support\Facades\Request;
use \Illuminate\Support\Facades\Response;

class LocationController extends \BaseController {

	public function locations()
	{
		$auth_token = Request::header('Authorization');
    	$user = User::where('auth_token', '=', $auth_token)->first();

    	if ($user)
    	{
    		$colegios = Colegio::getActiveColegiosInfo()->get();

    		$colegios_array = [];
    		foreach ($colegios as $c)
    		{
    			$colegios_element['id'] = $c->idcolegios;
    			$colegios_element['latitude'] = (double)$c->latitud;
    			$colegios_element['longitude'] = (double)$c->longitud;
    			$colegios_array[] = $colegios_element;
    		}

    		$voluntarios = User::getVoluntarios()->get();

    		$voluntarios_array = [];
    		foreach ($voluntarios as $v)
    		{
    			$voluntarios_element['id'] = $v->id;
                $voluntarios_element['names'] = $v->nombres;
                $voluntarios_element['last_name'] = $v->apellido_pat;
                $voluntarios_element['username'] = $v->num_documento;
                $voluntarios_element['email'] = $v->email;

                $perfiles = User::getPerfilesPorUsuario2($v->id)->get();
                $perfiles_array = array();
                foreach ($perfiles as $perfil)
                {
                    $perfiles_array[] = [
                        'id' => $perfil->idperfiles,
                        'name' => $perfil->nombre
                    ];
                }

                $voluntarios_array['profiles'] = $perfiles_array;
    			$voluntarios_element['latitude'] = (double)$v->latitud;
    			$voluntarios_element['longitude'] = (double)$v->longitud;
    			$voluntarios_array[] = $voluntarios_element;
    		}

    		return Response::json([
    			'schools' => $colegios_array,
    			'volunteers' => $voluntarios_array,
    			], 200);
    	}

    	$response = [ 'error' => 'Error en la autenticación.'];
		$status_code = 401;
		return Response::json($response, $status_code);
	}
}
