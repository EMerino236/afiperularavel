<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Precolegio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idprecolegios';

}