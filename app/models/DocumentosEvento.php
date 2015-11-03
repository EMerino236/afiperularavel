<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentosEvento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentos_eventos';

	public function scopeGetDocumentosPorEvento($query,$ideventos)
	{
		$query->join('documentos','documentos.iddocumentos','=','documentos_eventos.iddocumentos')
			  ->join('tipo_documentos','tipo_documentos.idtipo_documentos','=','documentos.idtipo_documentos')
			  ->where('documentos_eventos.ideventos','=',$ideventos)
			  ->select('tipo_documentos.nombre as tipo_documento','documentos.titulo','documentos.nombre_archivo','documentos.ruta','documentos.iddocumentos','documentos.created_at','documentos_eventos.iddocumentos_eventos');
		return $query;
	}

}