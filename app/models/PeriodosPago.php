<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PeriodosPago extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idperiodos_pagos';

}