<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentosPadrino extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentos_padrinos';

	public function scopeGetDocumentoIdsByPadrino($query, $idpadrinos)
	{
		$query->join('documentos','documentos.iddocumentos','=','documentos_padrinos.documentos_iddocumentos')
			->where('documentos_padrinos.idpadrinos', '=', $idpadrinos)
			->select('*');

		return $query;
	}
}