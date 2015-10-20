<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Evento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'ideventos';

}