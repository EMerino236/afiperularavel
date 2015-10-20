<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Periodo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idperiodos';

}