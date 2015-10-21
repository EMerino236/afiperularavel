<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PostulantesFase extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idpostulantes_fases';

}