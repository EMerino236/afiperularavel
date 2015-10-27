<?php namespace api\v1;

use \Evento;
use \TipoEvento;
use \Periodo;
use \PuntoReunion;
use \PuntoEvento;
use \Documento;
use \DocumentosEvento;
use \Asistencia;
use \User;
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
        // obtener tipo de evento sesion
        $tipo_sesion = TipoEvento::find(1);
        
        // obtener sesiones
        $sesiones = Evento::where('idtipo_eventos', '=', $tipo_sesion->idtipo_eventos)->get();
        
        $response = [];
        foreach($sesiones as $sesion)
        {
            //obtener los puntos de reunion de la sesion
            //$idpuntos = PuntoEvento::where('ideventos', '=', $sesion->ideventos)->get()->lists('idpuntos_reunion');
            //$puntos_reunion = PuntoReunion::whereIn('idpuntos_reunion', $idpuntos)->get();
            $puntos_reunion = PuntoEvento::getPuntosPorEvento($sesion->ideventos)->get();
            $lista_puntos = [];
            foreach($puntos_reunion as $punto)
            {
                $lista_puntos[] = [
                    'id' => $punto->idpuntos_reunion,
                    'latitude' => (double)$punto->latitud,
                    'longitude' => (double)$punto->longitud
                ];
            }
            
            //obtener los documentos de la sesion
            //$iddocumentos = DocumentosEvento::where('ideventos', '=', $sesion->ideventos)->get()->lists('iddocumentos');
            //$documentos = Documento::whereIn('iddocumentos', $iddocumentos)->get();
            $documentos = DocumentosEvento::getDocumentosPorEvento($sesion->ideventos)->get();
            $lista_docs = [];
            foreach($documentos as $doc)
            {
                $lista_docs[] = [
                    'name' => $doc->nombre_archivo,
                    'date' => date('Y-m-d'),
                    //'date' => strtotime($doc->fecha),
                    'size' => 1.2
                    //'size' => $doc->tamaño
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
                    'attended' => $v->asistio
                ];
            }
            
            $response[] = [
                'id' => $sesion->ideventos,
                'name' => $sesion->nombre,
                'date' => strtotime($sesion->fecha_evento),
                'location' => [
                    'latitude' => (double)$sesion->latitud,
                    'longitude' => (double)$sesion->longitud
                ],
                'points_of_reunion' => $lista_puntos,
                'documents' => $lista_docs,
                'attendance_volunteers' => $lista_voluntarios
            ];
        }
        
        return Response::json($response, 200);
    }

}
