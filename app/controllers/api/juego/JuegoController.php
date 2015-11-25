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
                $estadoNivel->unlocked = ($n->idPredLevel) ? 0 : 1;
                $estadoNivel->bought = 0;
                $estadoNivel->save();
            }
            
            return Response::json(['success' => 1, 'idPlayer' => $jugador->idPlayer], 200);
        }
        else return Response::json($validator->messages(), 200);
        
    }

    // Obtener puntajes de amigos
	public function friendsScore()
	{
        $input = Input::json();
        $facebookIDs = $input->get('idPlayers');
        $idNivel = $input->get('idLevel');
        $numJugadores = $input->get('numPlayers');
        
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
                'milestone' => $n->milestone,
                'title' => $n->title,
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
            if($puntaje > $registro_puntaje->score)
            {
                // si ya existe un puntaje y es menor al nuevo puntaje, se modifica
                $registro_puntaje->score = $puntaje;
            }
            $registro_puntaje->defeatPosX = -1;
            $registro_puntaje->defeatPosY = -1;
            $registro_puntaje->defeated = 0;
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
        
        // desbloquear los niveles siguientes
        $niveles = Nivel::where('idPredLevel', '=', $idNivel)->get();
        foreach($niveles as $n)
        {
            $estado = EstadoNivel::where('idPlayer', '=', $idJugador)->where('idLevel', '=', $n->idLevel)->first();
            $estado->unlocked = 1;
            $estado->save();
        }
        
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
    
    // Registrar un gasto de continue
    public function levelContinue()
    {
        $rules = array('idPlayer' => 'required',
                       'idLevel' => 'required'
        );
        
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->fails()) return Response::json($validator->messages(), 200);
        
        $idJugador = Input::get('idPlayer');
        $jugador = Jugador::find($idJugador);
        if(!$jugador) return Response::json(['error' => 'No existe el jugador con id = ' . $idJugador], 200);
        
        $idNivel = Input::get('idLevel');
        $nivel = Nivel::find($idNivel);
        if(!$nivel) return Response::json(['error' => 'No existe el nivel con id = ' . $idNivel], 200);
        
        $score = Puntaje::where('idPlayer', '=', $idJugador)->where('idLevel', '=', $idNivel)->first();
        if(!$score) return Response::json(['error' => 'No se econtró el registro de score con idPlayer = ' . $idJugador . ' y idLevel = ' . $idNivel], 200);
        
        $jugador->continues = $jugador->continues - 1;
        $jugador->save();
        
        // resetear score
        $score->defeatPosX = -1;
        $score->defeatPosY = -1;
        $score->defeated = 0;
        $score->save();
        
        return Response::json(['success' => 1], 200);
    }
    
    // Registrar compra de nivel
    public function levelPurchase()
    {
        $rules = array('idPlayer' => 'required',
                       'idLevel' => 'required'
        );
        
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->fails()) return Response::json($validator->messages(), 200);
        
        $idJugador = Input::get('idPlayer');
        $jugador = Jugador::find($idJugador);
        if(!$jugador) return Response::json(['error' => 'No existe el jugador con id = ' . $idJugador], 200);
        
        $idNivel = Input::get('idLevel');
        $nivel = Nivel::find($idNivel);
        if(!$nivel) return Response::json(['error' => 'No existe el nivel con id = ' . $idNivel], 200);
        
        // disminuir monedas del jugador
        $jugador->coins = $jugador->coins - $nivel->cost;
        if($jugador->coins < 0) return Response::json(['error' => 'El jugador no posee suficientes monedas para comprar el nivel'], 200);
        
        $estadoNivel = EstadoNivel::where('idPlayer', '=', $idJugador)->where('idLevel', '=', $idNivel)->first();
        $estadoNivel->bought = 1;
        $estadoNivel->save();
        
        $jugador->save();
        
        return Response::json(['success' => 1], 200);
    }
    
    // Compra de powerup
    public function puPurchase()
    {
        $rules = array('idPlayer' => 'required',
                       'idLevel' => 'required',
                       'idPowerup' => 'required'
        );
        
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->fails()) return Response::json($validator->messages(), 200);
        
        $idJugador = Input::get('idPlayer');
        $jugador = Jugador::find($idJugador);
        if(!$jugador) return Response::json(['error' => 'No existe el jugador con id = ' . $idJugador], 200);
        
        $idNivel = Input::get('idLevel');
        $nivel = Nivel::find($idNivel);
        if(!$nivel) return Response::json(['error' => 'No existe el nivel con id = ' . $idNivel], 200);
        
        $idPowerup = Input::get('idPowerup');
        $pu = Powerup::find($idPowerup);
        if(!$pu) return Response::json(['error' => 'No existe el powerup con id = ' . $idPowerup], 200);
        
        $puxnivel = PowerupxNivel::where('idPowerup', '=', $idPowerup)->where('idLevel', '=', $idNivel)->first();
        if(!$puxnivel) return Response::json(['error' => 'No existe un registro del powerup en el nivel.'], 200);
        
        $jugador->coins = $jugador->coins - $puxnivel->cost;
        if($jugador->coins < 0) return Response::json(['error' => 'El jugador no posee suficientes monedas para comprar el powerup'], 200);
        
        $jugador->save();
        
        return Response::json(['success' => 1], 200);
    }
    
    // Obtener amigos en necesidad de continues
    public function friendsHelpNeeded()
    {
        $input = Input::json();
        $facebookIDs = $input->get('idPlayers');
        
        $response = [ 'friends' => [] ];
        
        foreach($facebookIDs as $fid)
        {
            $jugador = Jugador::where('idFacebook', '=', $fid)->first();
            if($jugador)
            {
                $cantidadDerrotas = Puntaje::where('idPlayer', '=', $jugador->idPlayer)
                                            ->where('defeated', '=', 1)->count();
                if($cantidadDerrotas > $jugador->continues)
                {
                    $response['friends'][] = ['idPlayer' => $jugador->idPlayer, 'idFacebook' => $jugador->idFacebook];   
                }
            }
        }
        
        return Response::json($response, 200);
    }
    
    // Regitrar una compra de continue
    public function friendsHelp()
    {
        $rules = array('idPlayerBuying' => 'required',
                       'idPlayerHelped' => 'required',
                       'price' => 'required'
        );
        
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->fails()) return Response::json($validator->messages(), 200);
        
        $idJugadorComprador = Input::get('idPlayerBuying');
        $jugadorComprador = Jugador::find($idJugadorComprador);
        if(!$jugadorComprador) return Response::json(['error' => 'No existe el jugador con id = ' . $idJugadorComprador], 200);
        
        $idJugadorAyudado = Input::get('idPlayerHelped');
        $jugadorAyudado = Jugador::find($idJugadorAyudado);
        if(!$jugadorAyudado) return Response::json(['error' => 'No existe el jugador con id = ' . $idJugadorAyudado], 200);
        
        $precioContinue = Input::get('price');
        $jugadorComprador->coins = $jugadorComprador->coins - $precioContinue;
        $jugadorComprador->save();
        $jugadorAyudado->continues = $jugadorAyudado->continues + 1;
        $jugadorAyudado->save();
        
        return Response::json(['success' => 1], 200);
    }
}
