<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentosProyecto extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentos_proyectos';

}