<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Permiso extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idpermisos';

}