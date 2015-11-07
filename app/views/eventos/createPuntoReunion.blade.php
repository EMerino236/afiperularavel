@extends('templates/eventosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Punto de Reunión</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('direccion') }}</strong></p>
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

	{{ Form::open(array('url'=>'eventos/submit_create_punto_reunion', 'role'=>'form')) }}
		{{ Form::hidden('latitud', null) }}
		{{ Form::hidden('longitud', null) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Ingrese la ubicación del nuevo punto</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-8 required @if($errors->first('direccion')) has-error has-feedback @endif">
						{{ Form::label('direccion','Dirección Exacta') }}
						{{ Form::text('direccion',null,array('class'=>'form-control')) }}
					</div>
				</div>
				<input id="pac-input" class="controls" type="text" placeholder="Bucar lugares">
				<div id="map"></div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-8">
				{{ Form::submit('Crear',array('class'=>'btn btn-primary')) }}	
			</div>
		</div>
	{{ Form::close() }}
	
<script src="{{ asset('js/gmap.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap" async defer></script>
@stop