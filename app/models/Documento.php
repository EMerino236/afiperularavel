<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Documento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentos';

}