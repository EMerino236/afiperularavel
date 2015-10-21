<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DetalleProyecto extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddetalle_proyectos';

}