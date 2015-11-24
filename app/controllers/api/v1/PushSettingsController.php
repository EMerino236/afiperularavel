<?php namespace api\v1;

use \User;
use \Illuminate\Support\Facades\Response;
use \Illuminate\Support\Facades\Request;

class PushSettingsController extends \BaseController {

	public function push_settings()
	{
		$auth_token = Request::header('Authorization');
        $user = User::where('auth_token', '=', $auth_token)->first();

        if ($user)
        {
            $data = file_get_contents('php://input');
    		$settingsInput = (array) json_decode($data);

            if ($settingsInput)
            {
                $user->push_eventos = $settingsInput['push_events'];
                $user->push_pagos = $settingsInput['push_fees'];
                $user->push_documents = $settingsInput['push_documents'];
                $user->push_reports = $settingsInput['push_reports'];

                $user->save();

                $response = [ 'success' => 1 ];
                $status_code = 200;
                return Response::json($response, $status_code);
            }
            else
            {
                $response = [ 'error' => 'Parámetro settings inválido (vacío/formato JSON incorrecto).'];
                $status_code = 400;
                return Response::json($response, $status_code);
            }
        }

        $response = [ 'error' => 'Error en la autenticación.'];
        $status_code = 401;
        return Response::json($response, $status_code);
	}


}
