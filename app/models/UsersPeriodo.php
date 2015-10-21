<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UsersPeriodo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idusers_periodos';

}