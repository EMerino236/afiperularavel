<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentosPadrino extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentos_padrinos';

	public function scopeGetDocumentoIdsByPadrino($query, $idpadrinos)
	{
		$query->join('documentos','documentos.iddocumentos','=','documentos_padrinos.iddocumentos')
			->where('documentos_padrinos.idpadrinos', '=', $idpadrinos)
			->select('*');

		return $query;
	}

	public function scopeGetDocumentosPorUsuarioPorTipo($query,$idtipo_documentos,$idpadrinos)
	{
		$query->join('documentos','documentos.iddocumentos','=','documentos_padrinos.iddocumentos_padrinos')
			  ->where('documentos.idtipo_documentos','=',$idtipo_documentos)
			  ->where('documentos_padrinos.idpadrinos','=',$idpadrinos)
			  ->orderBy('created_at','desc')
			  ->select('documentos.*');
		return $query;
	}

	public function scopeSearchDocumentosPorUsuarioPorTipo($query,$idtipo_documentos,$idpadrinos,$search,$fecha_ini,$fecha_fin)
	{
		$query->join('documentos','documentos.iddocumentos','=','documentos_padrinos.iddocumentos_padrinos')
			  ->where('documentos.idtipo_documentos','=',$idtipo_documentos)
			  ->where('documentos_padrinos.idpadrinos','=',$idpadrinos)
			  ->where('documentos.titulo','LIKE',"%$search%");
			  if($fecha_ini != "")
				  $query->where('documentos.created_at','>=',date('Y-m-d H:i:s',strtotime($fecha_ini)));
			  if($fecha_fin != "")
				  $query->where('documentos.created_at','<=',date('Y-m-d H:i:s',strtotime($fecha_fin.' + 1 days')));
		$query->orderBy('documentos.created_at','desc')
			  ->select('documentos.*');
		return $query;
	}
}