<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Colegio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idcolegios';

}