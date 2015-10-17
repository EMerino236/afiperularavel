<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoIdentificacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_identificacion';
	protected $primaryKey = 'idtipo_identificacion';

}