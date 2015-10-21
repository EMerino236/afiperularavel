<?php namespace api\juego;

use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class JuegoController extends \BaseController {

	public function player()
	{
		$jugador = Jugador::where('idFacebook', '=', Input::get('idFacebook'))->first();
        if ($jugador)
        {
            $status_code = 200;
            return Response::json($jugador, $status_code);
        }
        else
        {
            $status_code = 404;
            return Response::json(['error' => 1], $status_code);
        }
	}

	public function friendsScore()
	{
        $facebookIDs = Input::get('idPlayers');
        $idNivel = Input::get('idLevel');
        $numJugadores = Input::get('numPlayers');
        
        $jugadores = Jugador::whereIn('idFacebook', $facebookIDs)->get();
        $idJugadores = $jugadores->lists('idPlayer');
        
        $scores = Puntaje::where('idLevel', '=', $idNivel)
            ->whereIn('idPlayer', $idJugadores)
            ->orderBy('score','DESC')
            ->get()->take($numJugadores);
        
        $response = [ 'scores' => [] ];
        
        foreach($scores as $score)
        {
            $response['scores'][] = [
                'idFacebook' => Jugador::find($score->idPlayer)->idFacebook,
                'score' => $score->score
            ];
        }
        
		return Response::json($response, 200);
	}

}
