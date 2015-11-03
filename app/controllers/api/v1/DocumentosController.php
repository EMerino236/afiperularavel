<?php namespace api\v1;

class DocumentosController extends \BaseController {

	public function index()
	{
		// obtener los eventos a los que esta asignado el usuario
        $auth_token = \Request::header('authorization');
        $user = \User::where('auth_token', '=', $auth_token)->first();
        $eventos = \Asistencia::getEventosPorUser($user->id)->get();
        
        $response = [];
        
        foreach($eventos as $e)
        {
            // obtener los documentos del evento
            $docs = \DocumentosEvento::getDocumentosPorEvento($e->ideventos)->get();
            
            foreach($docs as $d)
            {
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
                    'name' => $d->nombre_archivo,
                    'url' => $d->ruta,
                    'users' => $users
                ];
            }
        }
        
        return \Response::json($response, 200);
	}

}
