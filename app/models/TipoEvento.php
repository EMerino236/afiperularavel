<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoEvento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idtipo_eventos';

}