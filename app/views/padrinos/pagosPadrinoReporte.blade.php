@extends('templates/padrinosTemplate') 
@section('content') 
<div class="row"> 
	<div class="col-lg-12"> 
	<h3 class="page-header">Reporte de pagos por padrino</h3> 
	</div> 
</div> 

	@if (Session::has('danger')) 
		<div class="alert alert-danger">{{ Session::get('danger') }}</div> 
	@endif 

{{ Form::open(array('url'=>'padrinos/submit_reporte_pagos_padrinos', 'role'=>'form')) }} 
	{{ Form::hidden('nombre_padrino',$nomb_padrino) }}
	
		<div class="row"> 
			<div class="form-group col-md-6 required @if($errors->first('nombre')) has-error has-feedback @endif"> 
				{{ Form::label('num_doc','Numero de Documento') }} 
				{{ Form::text('num_doc',Input::old('num_doc'),array('class'=>'form-control')) }} 
			</div> 
			<div class="form-group col-md-6 required @if($errors->first('rad')) has-error has-feedback @endif"> 
				{{ Form::label('rad','Pagos') }}</br>
				{{ Form::radio('rad', 'todos',true) }} Todos
				{{ Form::radio('rad', 'pagados',false,array('style'=>'margin-left:40px')) }} Pagados
				{{ Form::radio('rad', 'pendientes',false,array('style'=>'margin-left:40px')) }} Pendientes				
			</div>
		</div> 
	<div class="row"> 
		<div class="form-group col-md-6"> 
			{{ Form::submit('Generar',array('id'=>'submit-report', 'class'=>'btn btn-primary')) }}
		</div> 
	</div>		
	{{ Form::close() }} 
	
	@if($report_rows) 
	<div class="row"> 
		<h4>Resumen de pagos de: {{ $nomb_padrino }}</h4> 
	</div>	
	<div class="row"> <div class="form-group col-md-6"> </div></div>	
		<table class="table table-hover"> 
			<tr class="info"> 
				<th>N° cuota</th>
				<th>Fecha de vencimiento</th> 
				<th>Fecha de pago</th> 
				<th>Monto</th> 
			</tr> 
			@foreach($report_rows as $report_row) 
			<tr> 
				<td>
					{{$report_row->num_cuota}}
				</td>	
				<td> 
					{{$report_row->vencimiento}} 
				</td> 
				<td> 
					@if ($report_row->fecha_pago)
						{{$report_row->fecha_pago}} 
					@else
						Pendiente
					@endif	
				</td> 
				<td> 
					{{$report_row->monto}} 
				</td> 
			</tr> 
			@endforeach 
		</table> 
	@endif
@stop	
