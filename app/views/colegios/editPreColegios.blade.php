@extends('templates/colegiosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Colegio por Aprobar</h3>
        </div>
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'colegios/list_precolegios','method'=>'get','role'=>'form')) }}
		{{ Form::hidden('precolegio_id', $precolegio_info->idprecolegios) }}
		
		<div class="row">
			<div class="form-group col-md-5 @if($errors->first('nombre')) has-error has-feedback @endif">
				{{ Form::label('nombre','Nombre') }}
				{{ Form::text('nombre',$precolegio_info->nombre,array('class'=>'form-control','readonly' => 'true')) }}
			</div>

			<div class="form-group col-md-5 @if($errors->first('direccion')) has-error has-feedback @endif">
				{{ Form::label('direccion','Dirección') }}
				{{ Form::text('direccion',$precolegio_info->direccion,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5 @if($errors->first('nombre_contacto')) has-error has-feedback @endif">
				{{ Form::label('nombre_contacto','Nombre Contacto') }}
				{{ Form::text('nombre_contacto',$precolegio_info->nombre_contacto,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
			<div class="form-group col-md-5 @if($errors->first('email_contacto')) has-error has-feedback @endif">
				{{ Form::label('email_contacto','Email contacto') }}
				{{ Form::text('email_contacto',$precolegio_info->email_contacto,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5 @if($errors->first('telefono_contacto')) has-error has-feedback @endif">
				{{ Form::label('telefono_contacto','Telefono contacto') }}
				{{ Form::text('telefono_contacto',$precolegio_info->telefono_contacto,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
			<div class="form-group col-md-5 @if($errors->first('interes')) has-error has-feedback @endif">
				{{ Form::label('interes','Interes') }}
				{{ Form::text('interes',$precolegio_info->interes,array('class'=>'form-control','readonly' => 'true')) }}
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-md-6">	
				{{ Form::submit('Regresar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
			</div>
		</div>
	{{ Form::close() }}
	<!--
	<div class="row">
		<div class="form-group col-md-6">	
		@if(!$precolegio_info->deleted_at)		
			{{ Form::open(array('url'=>'colegios/submit_aprove_precolegio', 'role'=>'form')) }}
			{{ Form::hidden('precolegio_id', $precolegio_info->idprecolegios) }}
			{{ Form::submit('Aprobar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}							
		@endif
		{{ Form::close() }}
		</div>
	</div>
	-->	
@stop