<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentosConcurso extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentos_concursos';

}