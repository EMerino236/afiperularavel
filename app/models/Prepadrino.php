<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Prepadrino extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idprepadrinos';

	public function scopeGetPrepadrinosInfo($query)
	{
		$query->withTrashed()			  
			  ->select('prepadrinos.*');
		return $query;
	}

	public function scopeSearchPrepadrinos($query,$search_criteria)
	{
		$query->withTrashed()			  
			  ->join('periodo_pagos','periodo_pagos.idperiodo_pagos','=','prepadrinos.idperiodo_pagos')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('prepadrinos.dni','LIKE',"%$search_criteria%")
			  			  ->orWhere('prepadrinos.email','LIKE',"%$search_criteria%")
			  			  ->orWhere('prepadrinos.nombres','LIKE',"%$search_criteria%")
			  			  ->orWhere('prepadrinos.apellido_pat','LIKE',"%$search_criteria%")
			  			  ->orWhere('prepadrinos.apellido_mat','LIKE',"%$search_criteria%");
			  })
			  ->select('periodo_pagos.nombre','prepadrinos.*');
		return $query;
	}

	public function scopeSearchPrepadrinoById($query,$search_criteria)
	{
		$query->withTrashed()			  			  			  
			  ->join('periodo_pagos','periodo_pagos.idperiodo_pagos','=','prepadrinos.idperiodo_pagos')
			  ->where('prepadrinos.idprepadrinos','=',$search_criteria)
			  ->select('periodo_pagos.nombre','prepadrinos.*');
		return $query;
	}

}