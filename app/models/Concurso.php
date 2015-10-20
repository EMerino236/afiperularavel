<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Concurso extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idconcursos';

}