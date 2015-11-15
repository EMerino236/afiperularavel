@extends('templates/padrinosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Padrino</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'padrinos/submit_edit_padrino', 'role'=>'form')) }}
		{{ Form::hidden('padrino_id', $padrino_info->idpadrinos) }}		
		{{ Form::hidden('user_id', $padrino_info->id) }}
		{{ Form::hidden('latitud', $padrino_info->latitud) }}
		{{ Form::hidden('longitud', $padrino_info->longitud) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('idtipo_identificacion','Tipo de identificación') }}
					{{ Form::text('idtipo_identificacion',$padrino_info->nombre_tipo_identificacion,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('num_documento','Número de Documento') }}
					{{ Form::text('num_documento',$padrino_info->num_documento,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('nombres','Nombres') }}
					{{ Form::text('nombres',$padrino_info->nombres,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('apellido_pat','Apellido Paterno') }}
					{{ Form::text('apellido_pat',$padrino_info->apellido_pat,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('apellido_mat','Apellido Materno') }}
					{{ Form::text('apellido_mat',$padrino_info->apellido_mat,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
					{{ Form::text('fecha_nacimiento',date('d-m-Y',strtotime($padrino_info->fecha_nacimiento)),array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>	
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',$padrino_info->direccion,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('telefono','Teléfono') }}
					{{ Form::text('telefono',$padrino_info->telefono,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('celular','Celular') }}
					{{ Form::text('celular',$padrino_info->celular,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('email','E-mail') }}
					{{ Form::text('email',$padrino_info->email,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>				
			<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('idperiodo_pagos','Periodo de Pago') }}
						{{ Form::text('idperiodo_pagos',$padrino_info->nombre,array('class'=>'form-control','readonly' => 'true')) }}
					</div>
			</div>		
		</div>
	{{ Form::close() }}
	<div class="col-xs-12">
		<div class="row">
			<div class="form-group col-xs-8">
			@if($padrino_info->deleted_at)
				{{ Form::open(array('url'=>'padrinos/submit_enable_padrino', 'role'=>'form')) }}
					{{ Form::hidden('user_id', $padrino_info->id) }}
					{{ Form::hidden('padrino_id', $padrino_info->idpadrinos) }}
					{{ Form::submit('Habilitar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
			@else
				{{ Form::open(array('url'=>'padrinos/submit_disable_padrino', 'role'=>'form')) }}
					{{ Form::hidden('user_id', $padrino_info->id) }}
					{{ Form::hidden('padrino_id', $padrino_info->idpadrinos) }}
					{{ Form::submit('Inhabilitar',array('idpadrinos'=>'submit-delete', 'class'=>'btn btn-danger')) }}
			@endif
				{{ Form::close() }}
			</div>
		</div>
	</div>
	
@stop