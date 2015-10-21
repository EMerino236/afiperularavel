<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Padrino extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idpadrinos';

}