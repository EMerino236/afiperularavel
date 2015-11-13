<?php namespace api\v1;

use \Evento;
use \Periodo;
use \PuntoReunion;
use \PuntoEvento;
use \Documento;
use \DocumentosEvento;
use \Asistencia;
use \AsistenciaNinho;
use \User;
use \Comentario;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class EventosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function sesiones()
	{   
        // obtener usuario que esta haciendo la peticion
        $auth_token = \Request::header('authorization');
        $user = User::where('auth_token', '=', $auth_token)->first();
        // obtener los permisos del usuario
        $idpermisos = User::getPermisosPorUsuarioId($user->id)->get()->lists('idpermisos');
        
        // obtener las sesiones de acuerdo a los permisos del usuario
        $sesiones = [];
        if(in_array(12, $idpermisos))
        {
            // tiene el permiso "listar (todos los) eventos"
            $sesiones = \Evento::all();
        }
        elseif(in_array(15, $idpermisos))
        {
            // tiene el permiso "mis eventos"
            $sesiones = \Asistencia::getEventosPorUser($user->id)->get();
        }
        
        $response = [];
        foreach($sesiones as $sesion)
        {
                //obtener los puntos de reunion de la sesion
                //$idpuntos = PuntoEvento::where('ideventos', '=', $sesion->ideventos)->get()->lists('idpuntos_reunion');
                //$puntos_reunion = PuntoReunion::whereIn('idpuntos_reunion', $idpuntos)->get();
                //$puntos_evento = PuntoEvento::getPuntosPorEvento($sesion->ideventos)->get();
                $puntos_reunion = PuntoReunion::all();
                $lista_puntos = [];
                foreach($puntos_reunion as $punto)
                {
                    // verificar si la sesion tiene asignado el punto de reunion
                    $punto_evento = PuntoEvento::getPuntosPorEventoXPunto($sesion->ideventos, $punto->idpuntos_reunion)->first();
                
                    $lista_puntos[] = [
                        'id' => $punto->idpuntos_reunion,
                        'latitude' => (double)$punto->latitud,
                        'longitude' => (double)$punto->longitud,
                        'selected' => ($punto_evento) ? 1 : 0
                    ];
                }
            
                //obtener los documentos de la sesion
                //$iddocumentos = DocumentosEvento::where('ideventos', '=', $sesion->ideventos)->get()->lists('iddocumentos');
                //$documentos = Documento::whereIn('iddocumentos', $iddocumentos)->get();
                $documentos = DocumentosEvento::getDocumentosPorEvento($sesion->ideventos)->get();
                $lista_docs = [];
                foreach($documentos as $doc)
                {
                    // obtener hace cuantos dias se subio el documento
                    $from = new \DateTime();
                    $from->setTimestamp(strtotime($doc->created_at));
                    $to = new \DateTime('today');
                    $dias = $from->diff($to)->d;
                    
                    // obtener los usuarios asignados al documento (al evento)
                    $users = [];
                    $usuarios = \Asistencia::getUsersPorEvento($sesion->ideventos)->get();
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
                        $visto = \Visualizacion::getVisualizacionesPorUserPorEventoPorDocumento($u->id, $sesion->ideventos, $doc->iddocumentos)->first();
                    
                        $users[] = [
                            'id' => $u->id,
                            'names' => $u->nombres,
                            'last_name' => $u->apellido_pat,
                            'username' => $u->num_documento,
                            'profiles' => $perfiles_array,
                            'seen' => ($visto) ? 1 : 0
                        ];
                    }
                    
                    $lista_docs[] = [
                        'id' => $doc->iddocumentos,
                        'name' => $doc->titulo,
                        'url' => $doc->ruta . $doc->nombre_archivo,
                        'upload_date' => 'Hace ' . $dias . ' día' . (($dias != 1) ? 's' : '') . ', ' . date('h:i A', $from->getTimestamp()),
                        'size' => $doc->peso . ' KB',
                        'users' => $users
                    ];
                }
            
                //obtener los niños asignados a la sesion
                $ninhos = AsistenciaNinho::getNinhosPorEvento($sesion->ideventos)->get();
                $lista_ninhos = [];
                foreach($ninhos as $n)
                {
                    // genero
                    $genero = null;
                    if (($n->genero == 'm') || ($n->genero == 'M')) $genero = 0;
                    elseif (($n->genero == 'f') || ($n->genero == 'F')) $genero = 1;
                
                    // edad
                    $from = new \DateTime($n->fecha_nacimiento);
                    $to = new \DateTime('today');
                    $edad = $from->diff($to)->y;
                    
                    // obtener el comentario que el usuario le ha hecho al niño
                    $ha_comentado = 0;
                    $comentario = null;
                    $c = Comentario::getComentarioPorUserPorNinhos($user->id, $n->idasistencia_ninhos)->first();
                    if($c)
                    {
                        $ha_comentado = 1;
                        $comentario = [
                            'id' => $c->idcomentarios,
                            'message' => $c->comentario,
                            'face' => (int)$c->calificacion
                        ];
                    }
                
                    $lista_ninhos[] = [
                        'id' => $n->idasistencia_ninhos,
                        'child' => [
                            'id' => $n->idninhos,
                            'names' => $n->nombres,
                            'last_name' => $n->apellido_pat,
                            'gender' => $genero,
                            'age' => $edad,
                            'sessions' => \AsistenciaNinho::where('idninhos', '=', $n->idninhos)->count(),
                            'joining_date' => strtotime($n->created_at)
                        ],
                        'commented' => $ha_comentado,
                        'comment' => $comentario
                    ];
                }
            
                //obtener los voluntarios asignados a la sesion
                $voluntarios = Asistencia::getUsersPorEvento($sesion->ideventos)->get();
                $lista_voluntarios = [];
                foreach($voluntarios as $v)
                {
                    $perfiles = User::getPerfilesPorUsuario2($v->id)->get();
                    $perfiles_array = array();
                    foreach ($perfiles as $perfil)
                    {
                        $perfiles_array[] = [
                            'id' => $perfil->idperfiles,
                            'name' => $perfil->nombre
                        ];
                    }
                    $lista_voluntarios[] = [
                        'id' => $v->idasistencias,
                        'volunteer' => [
                            'id' => $v->id,
                            'names' => $v->nombres,
                            'last_name' => $v->apellido_pat,
                            'username' => $v->num_documento,
                            'email' => $v->email,
                            'profiles' => $perfiles_array
                        ],
                        'attended' => (bool)$v->asistio,
                        'rating' => (int)$v->calificacion,
                        'comment' => $v->comentario
                    ];
                }
            
                $response[] = [
                    'id' => $sesion->ideventos,
                    'name' => $sesion->nombre,
                    'date' => strtotime($sesion->fecha_evento),
                    'location' => [
                        'latitude' => (double)$sesion->latitud,
                        'longitude' => (double)$sesion->longitud,
                        'address' => $sesion->direccion
                    ],
                    'meeting_points' => $lista_puntos,
                    'documents' => $lista_docs,
                    'attendance_children' => $lista_ninhos,
                    'attendance_volunteers' => $lista_voluntarios
                ];
        }
        
        return Response::json($response, 200);
    }

}
