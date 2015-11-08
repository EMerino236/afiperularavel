<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Padrino extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idpadrinos';

	public function scopeGetPadrinosInfo($query)
	{
		$query->withTrashed()
			  ->join('users','users.id','=','padrinos.idusers')
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->join('periodo_pagos','periodo_pagos.idperiodo_pagos','=','padrinos.idperiodo_pagos')
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','periodo_pagos.nombre','users.*');
		return $query;
	}

	public function scopeSearchPadrinos($query,$search_criteria)
	{
		$query->withTrashed()
			  ->join('users','users.id','=','padrinos.idusers')
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->join('periodo_pagos','periodo_pagos.idperiodo_pagos','=','padrinos.idperiodo_pagos')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('users.num_documento','LIKE',"%$search_criteria%")
			  			  ->orWhere('users.email','LIKE',"%$search_criteria%")
			  			  ->orWhere('personas.nombres','LIKE',"%$search_criteria%")
			  			  ->orWhere('personas.apellido_pat','LIKE',"%$search_criteria%")
			  			  ->orWhere('personas.apellido_mat','LIKE',"%$search_criteria%");
			  })
			  ->select('personas.nombres','personas.apellido_pat','personas.apellido_mat','periodo_pagos.nombre','users.*');
		return $query;
	}

	public function scopeSearchPadrinoById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->join('users','users.id','=','padrinos.idusers')
			  ->join('personas','personas.idpersonas','=','users.idpersona')
			  ->join('tipo_identificacion','tipo_identificacion.idtipo_identificacion','=','users.idtipo_identificacion')
			  ->join('periodo_pagos','periodo_pagos.idperiodo_pagos','=','padrinos.idperiodo_pagos')
			  ->where('users.id','=',$search_criteria)
			  ->select('tipo_identificacion.nombre as nombre_tipo_identificacion','periodo_pagos.nombre','personas.*','users.*','padrinos.idpadrinos');
		return $query;
	}

	public function scopeGetPadrinosActivos($query,$anho)
	{
		$query->join('users','users.id','=','padrinos.idusers')
			  ->where('padrinos.created_at','LIKE',$anho."%")
			  ->select('users.email','padrinos.idpadrinos');
		return $query;
	}

	public function scopeGetPadrinoByUserId($query, $idusers)
	{
		$query->where('idusers', '=', $idusers)
			->select('padrinos.*');

		return $query;
	}
}