<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Persona extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idpersonas';

}