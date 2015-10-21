<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Log extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idlogs';

}