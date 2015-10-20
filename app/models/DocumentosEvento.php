<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentosEvento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentos_eventos';

}