<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Fase extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idfases';

}