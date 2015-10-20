<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Proyecto extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idproyectos';

}