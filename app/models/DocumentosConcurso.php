<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentosConcurso extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentos_concursos';


	public function scopeGetDocumentosPorConcurso($query,$idconcursos)
	{
		$query->join('documentos','documentos.iddocumentos','=','documentos_concursos.iddocumentos')
			  ->join('tipo_documentos','tipo_documentos.idtipo_documentos','=','documentos.idtipo_documentos')
			  ->where('documentos_concursos.idconcursos','=',$idconcursos)
			  ->select('tipo_documentos.nombre as tipo_documento','documentos.titulo','documentos.nombre_archivo','documentos.ruta','documentos.iddocumentos','documentos_concursos.iddocumentos_concursos');
		return $query;
	}

}