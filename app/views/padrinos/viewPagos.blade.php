@extends('templates/padrinosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Comprobante de Pago</h3>
        </div>
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	{{ Form::open(array('url'=>'padrinos/submit_aprove_pago', 'role'=>'form')) }}
		{{ Form::hidden('idcalendario_pagos', $pago_data->idcalendario_pagos) }}
		
		<div class="row">
			<div class="form-group col-md-5 @if($errors->first('comprobante')) has-error has-feedback @endif">
				{{ Form::label('comprobante','Número Comprobante') }}
				{{ Form::text('comprobante',$pago_data->num_comprobante,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
			<div class="form-group col-md-5 @if($errors->first('num_cuota')) has-error has-feedback @endif">
				{{ Form::label('num_cuota','Número Cuota') }}
				{{ Form::text('num_cuota',$pago_data->num_cuota,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5 @if($errors->first('nombre_padrino')) has-error has-feedback @endif">
				{{ Form::label('nombre_padrino','Nombres') }}
				{{ Form::text('nombre_padrino',$pago_data->nombres,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
			<div class="form-group col-md-5 @if($errors->first('monto')) has-error has-feedback @endif">
				{{ Form::label('monto','Monto') }}
				{{ Form::text('monto',$pago_data->monto,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5 @if($errors->first('apellidosp')) has-error has-feedback @endif">
				{{ Form::label('apellidosp','Apellido Paterno') }}
				{{ Form::text('apellidosp',$pago_data->apellido_pat,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
			<div class="form-group col-md-5 @if($errors->first('vencimiento')) has-error has-feedback @endif">
				{{ Form::label('vencimiento','Fecha Vencimiento') }}
				{{ Form::text('vencimiento',$pago_data->vencimiento,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5 @if($errors->first('apellidosm')) has-error has-feedback @endif">
				{{ Form::label('apellidosm','Apellido Materno') }}
				{{ Form::text('apellidosm',$pago_data->apellido_mat,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
			<div class="form-group col-md-5 @if($errors->first('fecha_pago')) has-error has-feedback @endif">
				{{ Form::label('fecha_pago','Fecha Pago') }}
				{{ Form::text('fecha_pago',$pago_data->fecha_pago,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5 @if($errors->first('email')) has-error has-feedback @endif">
				{{ Form::label('email','Email') }}
				{{ Form::text('email',$pago_data->email,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
			<div class="form-group col-md-5 @if($errors->first('estado')) has-error has-feedback @endif">
				{{ Form::label('estado','Estado') }}
				@if($pago_data->aprobacion ===1)
					{{ Form::text('estado','Aprobado',array('class'=>'form-control','readonly' => 'true')) }}					
				@endif
				@if($pago_data->aprobacion ===null)
					{{ Form::text('estado','Pendiente',array('class'=>'form-control','readonly' => 'true')) }}					
				@endif
				@if($pago_data->aprobacion ===0)
					{{ Form::text('estado','Rechazado',array('class'=>'form-control','readonly' => 'true')) }}					
				@endif
			</div>
		</div>
		
		
	{{ Form::close() }}
	
	<div class="row">
			
		@if(!$pago_data->deleted_at)
			@if($pago_data->aprobacion ===null)
		<div class="form-group col-md-1">		
				{{ Form::open(array('url'=>'padrinos/submit_aprove_pago', 'role'=>'form')) }}
				{{ Form::hidden('idcalendario_pagos', $pago_data->idcalendario_pagos) }}
				{{ Form::submit('Aprobar',array('id'=>'submit-aprove', 'class'=>'btn btn-success')) }}
				{{ Form::close() }}
		</div>
		<div class="form-group col-md-1">	
				{{ Form::open(array('url'=>'padrinos/submit_rechazar_pago', 'role'=>'form')) }}
				{{ Form::hidden('idcalendario_pagos', $pago_data->idcalendario_pagos) }}
				{{ Form::submit('Rechazar',array('id'=>'submit-reject', 'class'=>'btn btn-danger')) }}
				{{ Form::close() }}	
		</div>
			@endif						
		@endif
		{{ Form::close() }}
		
	</div>
	
@stop