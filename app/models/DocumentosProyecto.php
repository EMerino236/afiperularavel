<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentosProyecto extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentos_proyectos';

	public function scopeGetDocumentosPorProyecto($query,$idproyectos)
	{
		$query->join('documentos','documentos.iddocumentos','=','documentos_proyectos.iddocumentos')
			  ->join('tipo_documentos','tipo_documentos.idtipo_documentos','=','documentos.idtipo_documentos')
			  ->where('documentos_proyectos.idproyectos','=',$idproyectos)
			  ->select('tipo_documentos.nombre as tipo_documento','documentos.titulo','documentos.nombre_archivo','documentos.ruta','documentos.iddocumentos','documentos_proyectos.iddocumentos_proyectos','documentos.*');
		return $query;
	}

}