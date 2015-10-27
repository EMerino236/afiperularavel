<?php namespace api\juego;

use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class JuegoController extends \BaseController {

    // Obtener datos de jugador
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
    
    // Registrar datos de jugador
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

    // Obtener puntajes de amigos
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
    
    // Obtener grafo de niveles
    public function levelGraph()
    {
        $idJugador = Input::get('idPlayer');
        
        $niveles = Nivel::all();
        $levels = [];
        foreach($niveles as $n)
        {
            // obtener estado del nivel para el jugador
            $estado = EstadoNivel::where('idLevel', '=', $n->idLevel)->where('idPlayer', '=', $idJugador)->first();
            
            // obtener niveles predecesores
            $preds = Nivel::where('idPredLevel', '=', $n->idLevel)->select('idLevel')->get();
            
            // obtener puntaje del jugador en el nivel
            $puntaje = Puntaje::where('idLevel', '=', $n->idLevel)->where('idPlayer', '=', $idJugador)->first();
            
            // obtener powerups del nivel
            $powerups = PowerupxNivel::where('idLevel', '=', $n->idLevel)->select('idPowerup','cost')->get();
            
            // obtener colectables del nivel
            $colectables = PesoColectable::where('idLevel', '=', $n->idLevel)->select('idCurrency', 'weight')->get();
            
            $levels[] = [
                'idLevel' => $n->idLevel,
                'numOrder' => $n->numOrder,
                'bought' => ($estado) ? $estado->bought : null,
                'unlocked' => ($estado) ? $estado->unlocked : null,
                'cost' => $n->cost,
                'childLevel' => $preds,
                'score' => ($puntaje) ? $puntaje->score : null,
                'defeated' => ($puntaje) ? $puntaje->defeated : null,
                'defeatPosX' => ($puntaje) ? $puntaje->defeatPosX : null,
                'defeatPosY' => ($puntaje) ? $puntaje->defeatPosY : null,
                'powerupsAvailable' => $powerups,
                'currencyWeight' => $colectables
            ];
        }
        
        return Response::json(['levels' => $levels], 200);
    }

}
