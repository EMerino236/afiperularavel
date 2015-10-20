<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoDocumento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idtipo_documentos';

}