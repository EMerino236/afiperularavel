<?php namespace api\v1;

use \Evento;
use \TipoEvento;
use \Periodo;
use \PuntoReunion;
use \PuntoEvento;
use \Documento;
use \DocumentosEvento;
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
        $tipo_sesion = TipoEvento::where('nombre', '=', 'Sesión de voluntariado')->first();
        
        // obtener sesiones
        $sesiones = Evento::where('idtipo_eventos', '=', $tipo_sesion->idtipo_eventos)->get();
        
        $response = [];
        foreach($sesiones as $sesion)
        {
            //obtener los puntos de reunion de la sesion
            $idpuntos = PuntoEvento::where('ideventos', '=', $sesion->ideventos)->get()->lists('idpuntos_reunion');
            $puntos_reunion = PuntoReunion::whereIn('idpuntos_reunion', $idpuntos)->get();
            $lista_puntos = [];
            foreach($puntos_reunion as $punto)
            {
                $lista_puntos[] = [
                    'latitude' => (double)$punto->latitud,
                    'longitude' => (double)$punto->longitud
                ];
            }
            
            //obtener los documentos de la sesion
            $iddocumentos = DocumentosEvento::where('ideventos', '=', $sesion->ideventos)->get()->lists('iddocumentos');
            $documentos = Documento::whereIn('iddocumentos', $iddocumentos)->get();
            $lista_docs = [];
            foreach($documentos as $doc)
            {
                $lista_docs[] = [
                    'name' => $doc->nombre_archivo,
                    'date' => date('Y-m-d'),
                    'size' => 1.2
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
                'documents' => $lista_docs
            ];
        }
        
        return Response::json($response, 200);
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
