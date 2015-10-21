<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Asistencia extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idasistencias';

}