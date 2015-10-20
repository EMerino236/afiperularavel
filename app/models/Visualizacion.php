<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Visualizacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'visualizaciones';
	protected $primaryKey = 'idvisualizaciones';

}