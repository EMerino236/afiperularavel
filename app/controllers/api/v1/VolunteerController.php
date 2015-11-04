<?php namespace api\v1;

use \User;
use \UsersPeriodo;
use \Asistencia;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;
use \Illuminate\Support\Facades\Request;

class VolunteerController extends \BaseController {

	public function reapply()
	{
		$auth_token = Request::header('Authorization');
    	$user = User::where('auth_token', '=', $auth_token)->first();

    	if ($user)
    	{
    		$period_id = Input::get('period_id');
            if ($period_id)
            {
                $entry = UsersPeriodo::getUsersPeriodoByUserXPeriodo($user->id, $period_id)->first();
                if (!$entry)
                {
                    $users_periodo = new UsersPeriodo;
                    $users_periodo->idusers = $user->id;
                    $users_periodo->idperiodos = $period_id;

                    $users_periodo->save();

                    $response = [ 'success' => 1 ];
                    $status_code = 200;
                    return Response::json($response, $status_code);
                }
                else
                {
                    $response = [ 'error' => 'El voluntario ya está registrado en el próximo período.' ];
                    $status_code = 200;
                    return Response::json($response, $status_code);
                }
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

    public function roll_call()
    {
        $auth_token = Request::header('Authorization');
        $user = User::where('auth_token', '=', $auth_token)->first();

        if ($user)
        {
            $data = file_get_contents('php://input');
            $rollCallInput = (array) json_decode($data);

            if ($rollCallInput)
            {
                try
                {   
                    $sessionID = $rollCallInput['session_id'];
                    $volunteersInput = $rollCallInput['volunteers'];
                }
                catch (Exception $e)
                {
                    $response = [ 'error' => 'Formato inválido: debe contener session_id, volunteers.'];
                    $status_code = 404;
                    return Response::json($response, $status_code);
                }

                foreach ($volunteersInput as $v)
                {
                    $rollCallEntry = Asistencia::validarAsistencia($v->id, $sessionID)->first();
                    if (!$rollCallEntry)
                    {
                        $rollCallEntry = new Asistencia;
                        $rollCallEntry->idusers = $v->id;
                        $rollCallEntry->ideventos = $sessionID;
                    }
                    $rollCallEntry->asistio = $v->attended;
                    $rollCallEntry->calificacion = $v->rating;
                    $rollCallEntry->comentario = $v->comment;

                    $rollCallEntry->save();
                }

                $rollCallDB = Asistencia::getUsersPorEvento($sessionID)->get();
                $responseRollCall = [];
                foreach($rollCallDB as $rollCallEntryDB)
                {
                    $responseRollCall_element['id'] = $rollCallEntryDB->id;
                    $responseRollCall_element['names'] = $rollCallEntryDB->nombres;
                    $responseRollCall_element['last_name'] = $rollCallEntryDB->apellido_pat;
                    $responseRollCall_element['attended'] = (bool)$rollCallEntryDB->asistio;
                    $responseRollCall_element['rating'] = (int)$rollCallEntryDB->calificacion;
                    $responseRollCall_element['comment'] = $rollCallEntryDB->comentario;

                    $responseRollCall[] = $responseRollCall_element;
                }

                $response = [ 'success' => 1, 'session_id' => $sessionID, 'volunteers' => $responseRollCall];
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
}
