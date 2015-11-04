<?php namespace api\v1;

use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class NinhosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{   
        $niños = \Ninho::all();
        
        $response = [];
        foreach($niños as $n)
        {
            // genero
            $genero = null;
            if (($n->genero == 'm') || ($n->genero == 'M')) $genero = 0;
            elseif (($n->genero == 'f') || ($n->genero == 'F')) $genero = 1;
            
            // edad
            $from = new \DateTime($n->fecha_nacimiento);
            $to = new \DateTime('today');
            $edad = $from->diff($to)->y;
            
            $response[] = [
                'id' => $n->idninhos,
                'names' => $n->nombres,
                'last_name' => $n->apellido_pat,
                'age' => $edad,
                'gender' => $genero
            ];
        }
        return Response::json($response, 200);
	}
    
    public function comment($attendance_children_id)
    {
        // validar si el id es de un registro existente
        $asistencia_ninho = \AsistenciaNinho::find($attendance_children_id);
        if(!$asistencia_ninho)
            return Response::json(['error' => 'No existe un registro de asistencia con id = ' . $attendance_children_id], 200);
        
        $rules = array('message' => 'required',
                       'face' => 'required',
        );
        $validator = \Validator::make(Input::all(), $rules);
        if($validator->fails()) return Response::json($validator->messages(), 200);
        
        // verificar si el usuario ya le comento al niño
        $auth_token = \Request::header('authorization');
        $user = \User::where('auth_token', '=', $auth_token)->first();
        $comentario = \Comentario::getComentarioPorUserPorNinhos($user->id, $attendance_children_id)->first();
        if($comentario)
        {
            $comentario->comentario = Input::get('message');
            $comentario->calificacion = Input::get('face');
            $comentario->save();
        }
        else 
        {
            $nuevo_comentario = new \Comentario;
            $nuevo_comentario->comentario = Input::get('message');
            $nuevo_comentario->calificacion = Input::get('face');
            $nuevo_comentario->idusers = $user->id;
            $nuevo_comentario->idasistencia_ninhos = $attendance_children_id;
            $nuevo_comentario->save();
        }
        
        
        // armar la respuesta
        
        // verificar si tiene permiso para leer todos los comentarios del niño
        $idpermisos = \User::getPermisosPorUsuarioId($user->id)->get()->lists('idpermisos');
        
        if(!(in_array(35, $idpermisos))) return Response::json(['success' => 1], 200);
        
        $n = \Ninho::find($asistencia_ninho->idninhos);
        // genero
        $genero = null;
        if (($n->genero == 'm') || ($n->genero == 'M')) $genero = 0;
        elseif (($n->genero == 'f') || ($n->genero == 'F')) $genero = 1;        
        // edad
        $from = new \DateTime($n->fecha_nacimiento);
        $to = new \DateTime('today');
        $edad = $from->diff($to)->y;
        // obtener todos los comentarios hechos al niño en todas las sesiones
        $lista_comentarios = [];
        $asistencias = \AsistenciaNinho::where('idninhos', '=', $n->idninhos)->get();
        foreach($asistencias as $a)
        {
            $comentarios = \Comentario::where('idasistencia_ninhos', '=', $a->idasistencia_ninhos)->get();
            foreach($comentarios as $c)
            {
                $autor = \User::searchUserById($c->idusers)->first();
                $lista_comentarios[] = [
                    'id' => $c->idcomentarios,
                    'session_id' =>  $a->ideventos,
                    'message' => $c->comentario,
                    'face' => (int)$c->calificacion,
                    'author' => [
                        'id' => $autor->id,
                        'names' => $autor->nombres,
                        'last_name' => $autor->apellido_pat
                    ]
                ];
            }
        }
        
        $response = [
            'success' => 1,
            'id' => $n->idninhos,
            'names' => $n->nombres,
            'last_name' => $n->apellido_pat,
            'gender' => $genero,
            'age' => $edad,
            'sessions' => 12,
            'joining_date' => strtotime($n->created_at),
            'comments' => $lista_comentarios
        ];
        
        return Response::json($response, 200);
    }

}
