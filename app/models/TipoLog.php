<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoLog extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idtipo_logs';

}