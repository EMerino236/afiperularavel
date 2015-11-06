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

	{{ Form::open(array('url'=>'padrinos/list_prepadrinos', 'method'=>'get', 'role'=>'form')) }}
		{{ Form::hidden('prepadrino_id', $prepadrino_info->idprepadrinos) }}		
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('dni')) has-error has-feedback @endif">
					{{ Form::label('dni','DNI') }}
					{{ Form::text('dni',$prepadrino_info->dni,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombres')) has-error has-feedback @endif">
					{{ Form::label('nombres','Nombres') }}
					{{ Form::text('nombres',$prepadrino_info->nombres,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellido_pat')) has-error has-feedback @endif">
					{{ Form::label('apellido_pat','Apellido Paterno') }}
					{{ Form::text('apellido_pat',$prepadrino_info->apellido_pat,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellido_mat')) has-error has-feedback @endif">
					{{ Form::label('apellido_mat','Apellido Materno') }}
					{{ Form::text('apellido_mat',$prepadrino_info->apellido_mat,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
					{{ Form::text('fecha_nacimiento',date('d-m-Y',strtotime($prepadrino_info->fecha_nacimiento)),array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>			
		</div>
		<div class="col-xs-6">			
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('direccion')) has-error has-feedback @endif">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',$prepadrino_info->direccion,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Teléfono') }}
					{{ Form::text('telefono',$prepadrino_info->telefono,array('class'=>'form-control','readonly' => 'true')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('celular')) has-error has-feedback @endif">
					{{ Form::label('celular','Celular') }}
					{{ Form::text('celular',$prepadrino_info->celular,array('class'=>'form-control','readonly' => 'true')) }}
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
		<div class="col-xs-12">
			<div class="row">
				<div class="form-group col-xs-8">	
				@if(!$prepadrino_info->deleted_at)
					{{ Form::hidden('prepadrino_id', $prepadrino_info->idprepadrinos) }}
					{{ Form::submit('Regresar',array('prepadrino_id'=>'submit-edit', 'class'=>'btn btn-primary')) }}							
				@endif
				</div>
			</div>
		</div>
	{{ Form::close() }}	
@stop