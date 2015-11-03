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
        
        // verificar si el voluntario ya le comento al niño
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
        return Response::json(['success' => 1], 200);
    }

}
