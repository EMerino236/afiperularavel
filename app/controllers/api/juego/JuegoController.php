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
            
            // registrar su estado para todos los niveles
            $niveles = Nivel::all();
            foreach($niveles as $n)
            {
                $estadoNivel = new EstadoNivel;
                $estadoNivel->idPlayer = $jugador->idPlayer;
                $estadoNivel->idLevel = $n->idLevel;
                $estadoNivel->unlocked = 0;
                $estadoNivel->bought = 0;
                $estadoNivel->save();
            }
            
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
    
    // Registrar un nuevo puntaje
    public function levelClear()
    {
        $rules = array('idPlayer' => 'required',
                       'idLevel' => 'required',
                       'score' => 'required',
                       'coinsWon' => 'required'
        );
        
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->fails()) return Response::json($validator->messages(), 200);
        
        $idJugador = Input::get('idPlayer');
        $idNivel = Input::get('idLevel');
        $puntaje = Input::get('score');
        $monedas = Input::get('coinsWon');
        
        // verificar si ya se registro un puntaje para el jugador en el nivel
        $registro_puntaje = Puntaje::where('idPlayer', '=', $idJugador)->where('idLevel', '=', $idNivel)->first();
        if($registro_puntaje)
        {
            // modificar puntaje
            $registro_puntaje->score = $puntaje;
            $registro_puntaje->save();
        }
        else
        {
            // desbloquear el nivel
            $estado_nivel = EstadoNivel::where('idPlayer', '=', $idJugador)->where('idLevel', '=', $idNivel)->first();
            $estado_nivel->unlocked = 1;
            $estado_nivel->save();
            
            // crear nuevo puntaje
            $nuevo_puntaje = new Puntaje;
            $nuevo_puntaje->idPlayer = $idJugador;
            $nuevo_puntaje->idLevel = $idNivel;
            $nuevo_puntaje->score = $puntaje;
            $nuevo_puntaje->defeatPosX = -1;
            $nuevo_puntaje->defeatPosY = -1;
            $nuevo_puntaje->defeated = 0;
            $nuevo_puntaje->save();
        }
        
        // agregar las monedas ganadas
        $j = Jugador::find($idJugador);
        $j->coins = $j->coins + $monedas;
        $j->save();
        
        return Response::json(['success' => 1], 200);
    }
    
    // Registrar derrota
    public function levelDefeat()
    {
        $rules = array('idPlayer' => 'required',
                       'idLevel' => 'required',
                       'defeatPosX' => 'required',
                       'defeatPosY' => 'required'
        );
        
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->fails()) return Response::json($validator->messages(), 200);
        
        $idJugador = Input::get('idPlayer');
        $idNivel = Input::get('idLevel');
        $defeatPosX = Input::get('defeatPosX');
        $defeatPosY = Input::get('defeatPosY');
        
        // verificar si ya se registro un puntaje para el jugador en el nivel
        $registro_puntaje = Puntaje::where('idPlayer', '=', $idJugador)->where('idLevel', '=', $idNivel)->first();
        if($registro_puntaje)
        {
            $registro_puntaje->defeatPosX = $defeatPosX;
            $registro_puntaje->defeatPosY = $defeatPosY;
            $registro_puntaje->defeated = 1;
            $registro_puntaje->save();
        }
        else
        {
            $nuevo_puntaje = new Puntaje;
            $nuevo_puntaje->idPlayer = $idJugador;
            $nuevo_puntaje->idLevel = $idNivel;
            $nuevo_puntaje->score = 0;
            $nuevo_puntaje->defeatPosX = $defeatPosX;
            $nuevo_puntaje->defeatPosY = $defeatPosY;
            $nuevo_puntaje->defeated = 1;
            $nuevo_puntaje->save();
        }
        
        return Response::json(['success' => 1], 200);
    }
    
    // Obtener Powerups 
    public function pu()
    {
        $pus = Powerup::all();
        return Response::json(['powerups' => $pus], 200);
    }
}
