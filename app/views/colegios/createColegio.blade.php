@extends('templates/colegiosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Registrar Nuevo Colegio</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
        </div>
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('direccion') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_contacto') }}</strong></p>
			<p><strong>{{ $errors->first('email_contacto') }}</strong></p>
			<p><strong>{{ $errors->first('telefono_contacto') }}</strong></p>
			<p><strong>{{ $errors->first('interes') }}</strong></p>
			@if($errors->first('latitud'))
				<p><strong>Mueva el punto en el mapa a una ubicación diferente</strong></p>
			@endif
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'colegios/submit_create_colegio', 'role'=>'form')) }}
	{{ Form::hidden('latitud', null) }}
	{{ Form::hidden('longitud', null) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Información Básica</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-6 required @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
				</div>
				<div class="form-group col-md-6 required @if($errors->first('email_contacto')) has-error has-feedback @endif">
					{{ Form::label('email_contacto','Email contacto') }}
					{{ Form::text('email_contacto',Input::old('email_contacto'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 required @if($errors->first('nombre_contacto')) has-error has-feedback @endif">
					{{ Form::label('nombre_contacto','Nombre Contacto') }}
					{{ Form::text('nombre_contacto',Input::old('nombre_contacto'),array('class'=>'form-control')) }}
				</div>
				<div class="form-group col-md-6 required @if($errors->first('interes')) has-error has-feedback @endif">
					{{ Form::label('interes','Interes') }}
					{{ Form::text('interes',Input::old('interes'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 required @if($errors->first('telefono_contacto')) has-error has-feedback @endif">
					{{ Form::label('telefono_contacto','Telefono contacto') }}
					{{ Form::text('telefono_contacto',Input::old('telefono_contacto'),array('class'=>'form-control')) }}
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Ingrese la Ubicación del Colegio en el Mapa</h3>
		</div>
		<div class="panel-body">
			
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('direccion')) has-error has-feedback @endif">
						{{ Form::label('direccion','Dirección') }}
						{{ Form::text('direccion',Input::old('direccion'),array('class'=>'form-control')) }}
					</div>
				</div>	
				<div id="map"></div>
			
			<div class="col-md-6">
				<div class="row">
					<div class="form-group col-md-6">
						<br>
						{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
					</div>
				</div>	
			</div>
		</div>
	</div>
	{{ Form::close() }}
	<script src="{{ asset('js/colegio/colegios.js') }}"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
	
@stop