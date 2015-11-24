<?php namespace api\v1;

use \User;
use \Periodo;
use \UsersPeriodo;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;
use \Illuminate\Support\Facades\Request;

class SessionController extends \BaseController {

	public function sign_in()
	{
		$num_documento = Input::get('username');
		$password = Input::get('password');
		$user = User::getUserByDocumentNumber($num_documento)->first();
    	if ($user)
    	{
    		if (\Hash::check($password, $user->password))
    		{
                $perfiles = User::getPerfilesPorUsuario2($user->id)->get();
                $perfiles_array = array();
                $can_reapply = 0;
                $period = null;
                foreach ($perfiles as $perfil)
                {
                    $perfiles_array[] = [
                        'id' => $perfil->idperfiles,
                        'name' => $perfil->nombre
                    ];
                    if ($perfil->idperfiles == 3)
                    {
                        $sgtePeriodo = Periodo::getFuturePeriodos()->first();
                        if ($sgtePeriodo)
                        {
                            $userPeriodo = UsersPeriodo::getUsersPeriodoByUserXPeriodo($sgtePeriodo->idperiodos, $user->id)->first();
                            if (!$userPeriodo)
                            {
                                $can_reapply = 1;
                                $period_element['id'] = $sgtePeriodo->idperiodos;
                                $period_element['name'] = $sgtePeriodo->nombre;
                                $period = $period_element;
                            }
                            else
                                $can_reapply = 0;
                        }
                    }
                }
    			$permisos = User::getPermisosPorUsuarioId($user->id)->get();
				$permisos_array = array();
				foreach ($permisos as $p)
				{
					$permisos_array[] = ['id' => $p->idpermisos];
				}
                

        		$response = [
            			'id' => $user->id,
            			'names' => $user->nombres,
            			'last_name' => $user->apellido_pat,
            			'username' => $user->num_documento,
                        'email' => $user->email,
                        'profiles' => $perfiles_array,
            			'actions' => $permisos_array,
                        'can_reapply' => $can_reapply,
                        'period' => $period,
                        'push_events' => (int)$user->push_eventos,
                        'push_fees' => (int)$user->push_pagos,
                        'push_documents' => (int)$user->push_documents,
                        'push_reports' => (int)$user->push_reports,
            			'auth_token' => $user->auth_token
        		];

        		return Response::json($response, 200);
    		}
            else
            {
                $response = array('error' => 'El usuario y la contraseña no coinciden.');
                return Response::json($response, 200);
            }
    	}
        
    	$response = array('error' => 'El nombre de usuario no existe.');
    	return Response::json($response, 200);
	}

    public function set_uuid()
    {
        $auth_token = Request::header('Authorization');
        $user = User::where('auth_token', '=', $auth_token)->first();

        if ($user)
        {
            $uuid = Input::get('uuid');

            if ($uuid)
            {
                $user->uuid = $uuid;
                $user->save();

                $response = [ 'success' => 1 ];
                $status_code = 200;
                return Response::json($response, $status_code);
            }
            else
            {
                $response = [ 'error' => 'Error en parámetros.'];
                $status_code = 404;
                return Response::json($response, $status_code);
            }
        }

        $response = [ 'error' => 'Error en la autenticación.'];
        $status_code = 401;
        return Response::json($response, $status_code);
    }

    public function clear_uuid()
    {
        $auth_token = Request::header('Authorization');
        $user = User::where('auth_token', '=', $auth_token)->first();

        if ($user)
        {
            $user->uuid = null;
            $user->save();

            $response = [ 'success' => 1 ];
            $status_code = 200;
            return Response::json($response, $status_code);
        }

        $response = [ 'error' => 'Error en la autenticación.'];
        $status_code = 401;
        return Response::json($response, $status_code);
    }
    
    public function set_gcm_token()
    {
        $auth_token = Request::header('Authorization');
        $user = User::where('auth_token', '=', $auth_token)->first();

        if ($user)
        {
            $gcm_token = Input::get('gcm_token');

            if ($gcm_token)
            {
                $user->gcm_token = $gcm_token;
                $user->save();

                $response = [ 'success' => 1 ];
                $status_code = 200;
                return Response::json($response, $status_code);
            }
            else
            {
                $response = [ 'error' => 'Error en parámetros.'];
                $status_code = 404;
                return Response::json($response, $status_code);
            }
        }

        $response = [ 'error' => 'Error en la autenticación.'];
        $status_code = 401;
        return Response::json($response, $status_code);
    }

    public function clear_gcm_token()
    {
        $auth_token = Request::header('Authorization');
        $user = User::where('auth_token', '=', $auth_token)->first();

        if ($user)
        {
            $user->gcm_token = null;
            $user->save();

            $response = [ 'success' => 1 ];
            $status_code = 200;
            return Response::json($response, $status_code);
        }

        $response = [ 'error' => 'Error en la autenticación.'];
        $status_code = 401;
        return Response::json($response, $status_code);
    }
}
