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

	public function scopeGetPagosPendientesAprobacion($query)
	{
		$hoy = date('Y-m-d');
		$query->join('padrinos','calendario_pagos.idpadrinos','=','padrinos.idpadrinos')
			  ->join('users','padrinos.idusers','=','users.id')
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->where('fecha_pago', '<=', $hoy)
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','calendario_pagos.*');

		return $query;
	}

	public function scopeSearchPadrinoByIdPago($query,$id)
	{
		$query->withTrashed()
			  ->join('padrinos','calendario_pagos.idpadrinos','=','padrinos.idpadrinos')
			  ->join('users','padrinos.idusers','=','users.id')
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->where('calendario_pagos.idcalendario_pagos','=',$id)
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','users.email','calendario_pagos.*');
		return $query;
	}

	public function scopeGetCalendarioByPadrinoPendientes($query, $idpadrinos)
	{
		$query->where('idpadrinos', '=', $idpadrinos)
			->whereNull('calendario_pagos.fecha_pago')	
			->select('*');
		return $query;
	}

	public function scopeGetCalendarioByPadrinoPagados($query, $idpadrinos)
	{
		$query->where('idpadrinos', '=', $idpadrinos)
			->whereNotNull('calendario_pagos.fecha_pago')	
			->select('*');
		return $query;
	}

	public function scopeGetCalendarioPagoPendienteNextDayByPadrino($query, $idpadrinos)
	{
		$query->where('idpadrinos', '=', $idpadrinos)
			->whereNull('calendario_pagos.fecha_pago')
			->where('vencimiento', '<=', new \DateTime('tomorrow'))
			->where('vencimiento', '>', new \DateTime('today'));

		return $query;
	}

}