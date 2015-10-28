<?php namespace api\v1;

use \PuntoReunion;
use \PuntoEvento;
use \User;
use \Exception;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;
use \Illuminate\Support\Facades\Request;

class MeetingPointController extends \BaseController {

	public function meeting_points()
	{
		$auth_token = Request::header('Authorization');
    	$user = User::where('auth_token', '=', $auth_token)->first();

    	if ($user)
    	{
    		$data = Input::get('points');
    		$meetingPointsInput = (array) json_decode($data);

            if ($meetingPointsInput)
            {
                try
                {   
                    $sessionID = $meetingPointsInput['session_id'];
                    $points = $meetingPointsInput['points_of_reunion'];
                    $newPoints = $meetingPointsInput['new_points_of_reunion'];
                    $deletedPoints = $meetingPointsInput['deleted_points_of_reunion'];
                }
                catch (Exception $e)
                {
                    $response = [ 'error' => 'Formato inválido: debe contener session_id, points_of_reunion, new_points_of_reunion, deleted_points_of_reunion.'];
                    $status_code = 401;
                    return Response::json($response, $status_code);
                }

                $meetingPointsOutput = [];

                foreach ($newPoints as $newPoint) {
                    $point = new PuntoReunion;
                    $point->latitud = $newPoint->latitude;
                    $point->longitud = $newPoint->longitude;
                    $point->save();

                    $point_event = new PuntoEvento;
                    $point_event->idpuntos_reunion = $point->idpuntos_reunion;
                    $point_event->ideventos = $sessionID;
                    $point_event->save();

                    $points_element['id'] = $point->idpuntos_reunion;
                    $points_element['latitude'] = $point->latitud;
                    $points_element['longitude'] = $point->longitud;

                    $points[] = $points_element;
                }

                foreach ($deletedPoints as $deletedPoint)
                {
                    $point = PuntoReunion::find($deletedPoint->id);
                    if ($point)
                    {
                        $point_event = PuntoEvento::getPuntosPorEventoXPunto($sessionID, $point->idpuntos_reunion)->first();
                        if ($point_event) $point_event->delete();
                        $point->delete();
                    } 
                }

                return Response::json([ 'success' => 1, 'session_id' => $sessionID,'points_of_reunion' => $points ], 200);
            }
            else
            {
                $response = [ 'error' => 'Parámetro points inválido (vacío/formato JSON incorrecto).'];
                $status_code = 401;
                return Response::json($response, $status_code);
            }    		
    	}
        
    	$response = [ 'error' => 'Error en la autenticación.'];
		$status_code = 401;
		return Response::json($response, $status_code);
	}


}
