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
            $data = file_get_contents('php://input');
    		$meetingPointsInput = (array) json_decode($data);

            if ($meetingPointsInput)
            {
                try
                {   
                    $sessionID = $meetingPointsInput['session_id'];
                    $points = $meetingPointsInput['meeting_points'];
                    $newPoints = $meetingPointsInput['new_meeting_points'];
                }
                catch (Exception $e)
                {
                    $response = [ 'error' => 'Formato inválido: debe contener session_id, meeting_points, new_meeting_points.'];
                    $status_code = 401;
                    return Response::json($response, $status_code);
                }

                foreach ($points as $p)
                {
                    $dbpoint = PuntoReunion::find($p->id);
                    if ($dbpoint)
                    {
                        $point_event = PuntoEvento::getPuntosPorEventoXPunto($sessionID, $dbpoint->idpuntos_reunion)->first();
                        if ($point_event && !$p->selected) $point_event->delete();
                        else if (!$point_event && $p->selected)
                        {
                            $point_event = PuntoEvento::getPuntosPorEventoXPuntoTrashed($sessionID, $dbpoint->idpuntos_reunion)->first();
                            if ($point_event) $point_event->restore();
                            else
                            {
                                $point_event = new PuntoEvento;
                                $point_event->idpuntos_reunion = $dbpoint->idpuntos_reunion;
                                $point_event->ideventos = $sessionID;
                                $point_event->save();
                            }
                        }
                    }
                }

                foreach ($newPoints as $newPoint) {
                    $point = new PuntoReunion;
                    $point->direccion = $newPoint->address;
                    $point->latitud = $newPoint->latitude;
                    $point->longitud = $newPoint->longitude;
                    $point->save();

                    $point_event = new PuntoEvento;
                    $point_event->idpuntos_reunion = $point->idpuntos_reunion;
                    $point_event->ideventos = $sessionID;
                    $point_event->save();
                }

                $dbpoints = PuntoReunion::all();
                $responsepoints = [];
                foreach ($dbpoints as $dbp)
                {
                    $points_element['id'] = $dbp->idpuntos_reunion;
                    $points_element['address'] = $dbp->direccion;
                    $points_element['latitude'] = (double)$dbp->latitud;
                    $points_element['longitude'] = (double)$dbp->longitud;
                    $point_event = PuntoEvento::getPuntosPorEventoXPunto($sessionID, $dbp->idpuntos_reunion)->first();
                    if ($point_event)
                        $points_element['selected'] = true;
                    else
                        $points_element['selected'] = false;

                    $responsepoints[] = $points_element;
                }

                return Response::json([ 'success' => 1, 'session_id' => $sessionID,'meeting_points' => $responsepoints ], 200);
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
