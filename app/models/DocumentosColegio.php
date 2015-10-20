<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentosColegio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentos_colegios';

}