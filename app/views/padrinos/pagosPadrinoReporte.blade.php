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

{{ Form::open(array('url'=>'padrinos/submit_reporte_pagos_padrino', 'role'=>'form')) }} 
	<div class="panel panel-default"> 
		<div class="panel-heading"> 
			<h3 class="panel-title">Información Básica</h3> 
		</div> 
	<div class="panel-body"> 
	<div class="col-xs-6"> 
		<div class="row"> 
			<div class="form-group col-xs-8 required @if($errors->first('nombre')) has-error has-feedback @endif"> 
				{{ Form::label('num_doc','Numero de Documento') }} 
				{{ Form::text('num_doc',Input::old('$num_doc'),array('class'=>'form-control')) }} 
			</div> 
		</div> 
	<div class="row"> 
		<div class="form-group col-xs-6"> 
			{{ Form::submit('Generar',array('id'=>'submit-report', 'class'=>'btn btn-primary')) }}
		</div> 
	</div>	
	{{ Form::close() }} 
	</div> 

	@if($report_rows) 
		<h4>Resumen de pagos</h4> 
		<table class="table table-hover"> 
		<tr class="info"> 
			<th>Fecha de vencimiento</th> 
			<th>Fecha de pago</th> 
			<th>Monto</th> 
		</tr> 
		@foreach($report_rows as $report_row) 
		<tr> 
			<td> 
				{{$report_row->vencimiento}} 
			</td> 
			<td> 
				{{$report_row->fecha_pago}} 
			</td> 
			<td> 
				{{$report_row->monto}} 
			</td> 
		</tr> 
		@endforeach 
	</table> 
@endif

{{ Form::close() }} 
@stop	
