<?php namespace api\v1;

class DocumentosController extends \BaseController {

	public function index()
	{
        $auth_token = \Request::header('authorization');
        $user = \User::where('auth_token', '=', $auth_token)->first();
        // obtener los perfiles del usuario
        $perfiles = \User::getPerfilesPorUsuario2($user->id)->get();
        $es_webmaster = 0;
        $es_miembroafi = 0;
        $es_voluntario = 0;
        $es_padrino = 0;
        foreach($perfiles as $p)
        {
            switch ($p->idperfiles) {
                case 1:
                    $es_webmaster = 1;
                    break;
                case 2:
                    $es_miembroafi = 1;
                    break;
                case 3:
                    $es_voluntario = 1;
                    break;
                case 4:
                    $es_padrino = 1;
                    break;
                default:
                    break;
            }
        }
        
        // obtener los eventos a los que esta asignado el usuario
        $eventos = [];
        if($es_webmaster || $es_miembroafi) $eventos = \Evento::all();
        elseif ($es_voluntario) $eventos = \Asistencia::getEventosPorUser($user->id)->get();
        
        $response = [];
        
        foreach($eventos as $e)
        {
            // obtener los documentos del evento
            $docs = \DocumentosEvento::getDocumentosPorEvento($e->ideventos)->get();
            
            foreach($docs as $d)
            {
                // obtener hace cuantos dias se subio el documento
                $from = new \DateTime();
                $from->setTimestamp(strtotime($d->created_at));
                $to = new \DateTime('today');
                $dias = $from->diff($to)->d;
                
                // obtener los usuarios asignados al documento (al evento)
                $users = [];
                $usuarios = \Asistencia::getUsersPorEvento($e->ideventos)->get();
                foreach($usuarios as $u)
                {
                    $perfiles = \User::getPerfilesPorUsuario2($u->id)->get();
                    $perfiles_array = [];
                    foreach ($perfiles as $perfil)
                    {
                        $perfiles_array[] = [
                            'id' => $perfil->idperfiles,
                            'name' => $perfil->nombre
                        ];
                    }
                
                    // verificar si el usuario ha visto el documento
                    $visto = \Visualizacion::getVisualizacionesPorUserPorEventoPorDocumento($u->id, $e->ideventos, $d->iddocumentos)->first();
                    
                    $users[] = [
                        'id' => $u->id,
                        'names' => $u->nombres,
                        'last_name' => $u->apellido_pat,
                        'username' => $u->num_documento,
                        'profiles' => $perfiles_array,
                        'seen' => ($visto) ? 1 : 0
                    ];
                }
                
                $response[] = [
                    'id' => $d->iddocumentos,
                    'name' => $d->titulo,
                    'url' => $d->ruta . $d->titulo,
                    'upload_date' => 'Hace ' . $dias . ' día' . (($dias != 1) ? 's' : '') . ', ' . date('h:i A', $from->getTimestamp()),
                    'size' => $d->peso . ' KB',
                    'users' => $users
                ];
            }
        }
        
        return \Response::json($response, 200);
	}
    
    public function register_visualization($document_id)
    {
        $documento = \Documento::find($document_id);
        if(!$documento)
            return \Response::json(['error' => 'No existe ningun documento con id = ' . $document_id], 200);
        
        $auth_token = \Request::header('authorization');
        $user = \User::where('auth_token', '=', $auth_token)->first();
        
        $idevento = \Input::get('session_id');
        
        if($idevento)
        {
            $evento = \Evento::find($idevento);
            if(!$evento)
                return \Response::json(['error' => 'No existe ninguna sesión con id = ' . $idevento], 200);
        
            $v = new \Visualizacion;
            $v->idusers = $user->id;
            $v->ideventos = $evento->ideventos;
            $v->iddocumentos = $document_id;
            $v->save();   
        }
        else
        {
            // obtener todos los eventos asociados al documento
            $eventos = \DocumentosEvento::where('iddocumentos', '=', $document_id)->get();
            foreach($eventos as $evento)
            {
                $v = new \Visualizacion;
                $v->idusers = $user->id;
                $v->ideventos = $evento->ideventos;
                $v->iddocumentos = $document_id;
                $v->save();  
            }
        }
        
        return \Response::json(['success' => 1], 200);
    }

}
