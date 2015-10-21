<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AsistenciaNinho extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idasistencia_ninhos';

}