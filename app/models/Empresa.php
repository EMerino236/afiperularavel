<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Empresa extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idempresas';

}