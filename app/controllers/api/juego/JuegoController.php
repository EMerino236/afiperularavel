<?php namespace api\juego;

use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class JuegoController extends \BaseController {

	public function player()
	{
		$jugador = Jugador::where('idFacebook', '=', Input::get('idFacebook'))->first();
        if ($jugador)
        {
            return Response::json($jugador, 200);
        }
        else
        {
            return Response::json(['error' => 'No se encontró el jugador.'], 200);
        }
	}
    
    public function create_player()
    {
        $rules = array('childName' => 'required',
                       'idFacebook' => 'required',
                       'coins' => 'required',
                       'hairVariation' => 'required',
                       'clothesVariation' => 'required',
                       'continues' => 'required'
        );
        
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->passes())
        {
            $jugador = new Jugador;
            $jugador->childName = Input::get('childName');
            $jugador->idFacebook = Input::get('idFacebook');
            $jugador->coins = Input::get('coins');
            $jugador->hairVariation = Input::get('hairVariation');
            $jugador->clothesVariation = Input::get('clothesVariation');
            $jugador->continues = Input::get('continues');
            $jugador->save();
            return Response::json(['success' => 1], 200);
        }
        else return Response::json($validator->messages(), 200);
        
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
