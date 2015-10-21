<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Prepadrino extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idprepadrinos';

}