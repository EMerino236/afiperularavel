<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Comentario extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idcomentarios';

}