<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class CalendarioPago extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idcalendario_pagos';

	public function scopeGetCalendarioByPadrino($query, $idpadrinos)
	{
		$query->where('idpadrinos', '=', $idpadrinos)
			->select('*');

		return $query;
	}

}