@extends('templates/padrinosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Padrino por Aprobar</h3>
        </div>
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'padrinos/submit_create_padrino', 'role'=>'form')) }}
		{{ Form::hidden('prepadrino_id', $prepadrino_info->idprepadrino) }}		
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('dni','DNI') }}
					{{ Form::text('dni',$prepadrino_info->dni,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombres') }}
					{{ Form::text('nombre',$prepadrino_info->nombres,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellido_paterno')) has-error has-feedback @endif">
					{{ Form::label('apellido_paterno','Apellido Paterno') }}
					{{ Form::text('apellido_paterno',$prepadrino_info->apellido_pat,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellido_materno')) has-error has-feedback @endif">
					{{ Form::label('apellido_materno','Apellido Materno') }}
					{{ Form::text('apellido_materno',$prepadrino_info->apellido_mat,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
					{{ Form::text('fecha_nacimiento',date('d-m-Y',strtotime($prepadrino_info->fecha_nacimiento)),array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					<span>*La contraseña será autogenerada y enviada al email ingresado.</span>
				</div>
			</div>	
		</div>
		<div class="col-xs-6">			
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('direccion')) has-error has-feedback @endif">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',Input::old('direccion'),array('class'=>'form-control')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Teléfono') }}
					{{ Form::text('telefono',Input::old('telefono'),array('class'=>'form-control')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('celular')) has-error has-feedback @endif">
					{{ Form::label('celular','Celular') }}
					{{ Form::text('celular',Input::old('celular'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('email')) has-error has-feedback @endif">
					{{ Form::label('email','E-mail') }}
					{{ Form::text('email',$prepadrino_info->email,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('nombre_periodo','Periodo Pago') }}
					{{ Form::text('nombre_periodo',$prepadrino_info->nombre_periodo,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
		</div>
	{{ Form::close() }}
	<div class="col-xs-12">
		<div class="row">
			<div class="form-group col-xs-8">	
			@if(!$prepadrino_info->deleted_at)		
				{{ Form::open(array('url'=>'colegios/submit_aprove_precolegio', 'role'=>'form')) }}
				{{ Form::hidden('precolegio_id', $prepadrino_info->idprecolegios) }}
				{{ Form::submit('Aprobar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}							
			@endif
			{{ Form::close() }}
			</div>
		</div>
	</div>
@stop