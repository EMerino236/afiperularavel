<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PostulantesPeriodo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idpostulantes_periodos';

}