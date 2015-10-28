<?php namespace api\v1;

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
        return $response;
	}

}
