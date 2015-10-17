<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PuntoReunion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'puntos_reunion';
	protected $primaryKey = 'idpuntos_reunion';

}