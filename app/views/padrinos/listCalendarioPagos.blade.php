@extends('templates/padrinosTemplate') 
@section('content') 
<div class="row"> 
<div class="col-lg-12"> 
	<h3 class="page-header">Mi Reporte de Pagos</h3> 
</div> 
</div> 

@if (Session::has('danger')) 
	<div class="alert alert-danger">{{ Session::get('danger') }}</div> 
@endif 

{{ Form::open(array('url'=>'padrinos/render_view_calendario_pagos', 'role'=>'form')) }} 	
	
	<table class="table">
		
		@if($error)
			*No tiene calendarios de pago asociados.
		@endif
		@if($error===false)
			<tr class="info">
				<th><center>Num. de Cuota</center></th>
				<th><center>Fecha Vencimiento</center></th>
				<th><center>Monto (Soles)</center></th>
				<th><center>Estado</center></th>
			</tr>
			@foreach($calendario_pagos as $calendario_pago)
			<tr class="@if($calendario_pago->deleted_at) bg-danger @endif">			
				<td>
					<center>{{$calendario_pago->num_cuota}}</center>
				</td>
				<td>
					<center>{{$calendario_pago->vencimiento}}</center>
				</td>
				<td>
					<center>{{$calendario_pago->monto}}</center>
				</td>
				<td class="text-center" style="vertical-align:middle">
					@if($calendario_pago->aprobacion === 0)				
						{{ Form::hidden('aprobaciones[]', $calendario_pago->aprobacion,array('class'=>'hidden-aprobacion')) }}
						Pendiente
					@endif
					@if($calendario_pago->aprobacion === 1)					
						{{ Form::hidden('aprobaciones[]', -1) }}
						Aprobado
					@endif				
				</td>
			</tr>
			@endforeach
		@endif		
	</table>

{{ Form::close() }} 
@stop	
