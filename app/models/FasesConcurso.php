<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class FasesConcurso extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idfases_concursos';

}