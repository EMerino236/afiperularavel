<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Postulante extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idpostulantes';

}