<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Ninho extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idninhos';

}