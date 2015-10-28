<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Documento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentos';

	public function scopeGetDocumentosPorTipo($query,$idtipo_documentos)
	{
		$query->where('idtipo_documentos','=',$idtipo_documentos)
			  ->orderBy('created_at','desc');
		return $query;
	}

}