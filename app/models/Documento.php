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

	public function scopeSearchDocumentosPorTipo($query,$idtipo_documentos,$search,$fecha_ini,$fecha_fin)
	{
		$query->where('idtipo_documentos','=',$idtipo_documentos)
			  ->where('titulo','LIKE',"%$search%");
			  if($fecha_ini != "")
				  $query->where('created_at','>=',date('Y-m-d H:i:s',strtotime($fecha_ini)));
			  if($fecha_fin != "")
				  $query->where('created_at','<=',date('Y-m-d H:i:s',strtotime($fecha_fin.' + 1 days')));
		$query->orderBy('created_at','desc');
		return $query;
	}

}