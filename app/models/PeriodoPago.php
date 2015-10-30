<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PeriodoPago extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idperiodo_pagos';

}