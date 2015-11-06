<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Voluntario extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idvoluntarios';

}