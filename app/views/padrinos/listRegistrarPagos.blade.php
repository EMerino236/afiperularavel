@extends('templates/padrinosTemplate') 
@section('content') 
<div class="row"> 
<div class="col-lg-12"> 
	<h3 class="page-header">Lista de Pagos</h3> 
</div> 
</div> 



	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('comprobante') }}</strong></p>	
			<p><strong>{{ $errors->first('banco') }}</strong></p>		
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	
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
				<th><center>Banco</center></th>
				<th><center>Num. Comprobante</center></th>
				<th><center>Estado</center></th>
				<th><center>Aprobación AFI</center></th>
				<th><center>Pago Depósito</center></th>
				<th><center>Pago PayPal</center></th>
			</tr>
			@foreach($calendario_pagos as $calendario_pago)
			{{ Form::open(array('url'=>'padrinos/submit_registrar_pagos', 'role'=>'form')) }}
			<tr class="@if($calendario_pago->deleted_at) bg-danger @endif">			
				<td>
					<center>{{$calendario_pago->num_cuota}}</center>
				</td>
				<td>
					<center>{{$calendario_pago->monto}}</center>
				</td>
				<td>
					<center>{{date('d/m/Y',strtotime($calendario_pago->vencimiento))}}</center>
				</td>
				<td>
					@if($calendario_pago->fecha_pago)						
						<center>{{date('d/m/Y',strtotime($calendario_pago->fecha_pago))}}</center>
					@endif
					@if($calendario_pago->fecha_pago === null)											
						<center>-</center>
					@endif
				</td>
				<td>
					@if($calendario_pago->fecha_pago)						
						{{ Form::text('banco',$calendario_pago->banco,array('class'=>'form-control','maxlength'=>'100','disabled'=>'disabled')) }}
					@endif
					@if($calendario_pago->fecha_pago === null)											
						{{ Form::text('banco',$calendario_pago->banco,array('class'=>'form-control','maxlength'=>'100')) }}
						{{ Form::hidden('bank', $calendario_pago->banco) }}
					@endif
				</td>
				<td>
					@if($calendario_pago->fecha_pago && $calendario_pago->aprobacion !== 0)
						{{ Form::text('comprobante',$calendario_pago->num_comprobante,array('class'=>'form-control','maxlength'=>'100','disabled'=>'disabled')) }}
					@endif
					@if($calendario_pago->fecha_pago === null || $calendario_pago->aprobacion === 0)
						{{ Form::text('comprobante',$calendario_pago->num_comprobante,array('class'=>'form-control','maxlength'=>'100')) }}
						{{ Form::hidden('num_comprobante', $calendario_pago->num_comprobante) }}
					@endif
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
					@if($calendario_pago->aprobacion === null)
						Por Aprobar		
					@endif
					@if($calendario_pago->aprobacion === 0)
						Rechazado<br>
						(Volver a Registrar Pago)
					@endif
					@if($calendario_pago->aprobacion === 1)
						Aprobado
					@endif				
				</td>
				<td class"=text-center" style="vertical-align:middle">					
						@if($calendario_pago->fecha_pago && $calendario_pago->aprobacion !== 0)
							<center>{{ Form::submit('Depósito',array('class'=>'btn btn-primary','disabled'=>'disabled')) }}</center>
						@endif
						@if($calendario_pago->fecha_pago === null || $calendario_pago->aprobacion === 0)
							<center>{{ Form::submit('Depósito',array('class'=>'btn btn-primary')) }}</center>
							{{ Form::hidden('idcalendario_pagos', $calendario_pago->idcalendario_pagos) }}
						@endif
					{{ Form::close() }} 
				</td>
				<td class"=text-center" style="vertical-align:middle">
					{{ Form::open(array('url'=>'padrinos/payment', 'role'=>'form')) }}
					@if($calendario_pago->fecha_pago && $calendario_pago->aprobacion !== 0)
						<center>{{ Form::submit('Paypal',array('id'=>'submit-registrar-pago', 'class'=>'btn btn-info','disabled'=>'disabled')) }}</center>
					@endif
					@if($calendario_pago->fecha_pago === null || $calendario_pago->aprobacion === 0)					
						{{ Form::hidden('idcalendario_pagos', $calendario_pago->idcalendario_pagos) }}
						{{ Form::hidden('monto', $calendario_pago->monto) }}
					 	<center>{{ Form::submit('Paypal',array('id'=>'submit-registrar-pago', 'class'=>'btn btn-info')) }}</center>					 	
					@endif
					{{Form::close()}}
				</td>
			</tr>
			@endforeach
		@endif		
	</table>

	<div class="row">
			
			<div class="form-group col-md-1">
					
			</div>
		</div>		

@stop	
