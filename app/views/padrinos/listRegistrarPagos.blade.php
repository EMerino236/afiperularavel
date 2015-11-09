@extends('templates/padrinosTemplate') 
@section('content') 
<div class="row"> 
<div class="col-lg-12"> 
	<h3 class="page-header">Lista de Pagos</h3> 
</div> 
</div> 

@if (Session::has('danger')) 
	<div class="alert alert-danger">{{ Session::get('danger') }}</div> 
@endif 

{{ Form::open(array('url'=>'padrinos/list_registrar_pagos', 'role'=>'form')) }} 	
	
	<table class="table">
		
		@if($error)
			*No tiene pagos asociados.
		@endif
		@if($error===false)
			<tr class="info">
				<th><center>Num. de Cuota</center></th>
				<th><center>Monto (Soles)</center></th>
				<th><center>Fecha Vencimiento</center></th>
				<th><center>Fecha Pago</center></th>
				<th><center>Num. Comprobante</center></th>
				<th><center>Estado</center></th>
				<th><center>Aprobación AFI</center></th>
			</tr>
			@foreach($calendario_pagos as $calendario_pago)
			<tr class="@if($calendario_pago->deleted_at) bg-danger @endif">			
				<td>
					<center>{{$calendario_pago->num_cuota}}</center>
				</td>
				<td>
					<center>{{$calendario_pago->monto}}</center>
				</td>
				<td>
					<center>{{$calendario_pago->vencimiento}}</center>
				</td>
				<td>
					@if($calendario_pago->fecha_pago)						
						<center>{{$calendario_pago->fecha_pago}}</center>
					@endif
					@if($calendario_pago->fecha_pago === null)											
						<center>-</center>
					@endif
				</td>
				<td>
					{{ Form::text('comprobante',$calendario_pago->num_comprobante,array('class'=>'form-control','maxlength'=>'100')) }}						
				</td>
				<td class="text-center" style="vertical-align:middle">
					@if($calendario_pago->fecha_pago)				
						{{ Form::hidden('aprobaciones[]', $calendario_pago->aprobacion,array('class'=>'hidden-aprobacion')) }}
						Pagado
					@endif
					@if($calendario_pago->fecha_pago === null)					
						{{ Form::hidden('aprobaciones[]', -1) }}
						Por Pagar
					@endif				
				</td>
				<td class="text-center" style="vertical-align:middle">
					@if($calendario_pago->aprobacion === 0)
						Por Aprobar
					@endif
					@if($calendario_pago->aprobacion === 1)
						Aprobado
					@endif				
				</td>
			</tr>
			@endforeach
		@endif		
	</table>

{{ Form::close() }} 
@stop	
