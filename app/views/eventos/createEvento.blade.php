@extends('templates/eventosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Evento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_eventos') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_evento') }}</strong></p>
			<p><strong>{{ $errors->first('idcolegios') }}</strong></p>
			<p><strong>{{ $errors->first('direccion') }}</strong></p>
			<p><strong>{{ $errors->first('voluntarios') }}</strong></p>
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
	@if($no_hay_periodo)
		<div class="alert alert-danger">No se encontró un período activo, para crear un evento necesita tener un registrar un nuevo período.</div>
	@else
		{{ Form::open(array('url'=>'eventos/submit_create_evento', 'role'=>'form')) }}
			{{ Form::hidden('idperiodos', $periodo) }}
			{{ Form::hidden('latitud', null) }}
			{{ Form::hidden('longitud', null) }}
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Información Básica</h3>
				</div>
				<div class="panel-body">
					<div class="col-xs-6">
						<div class="row">
							<div class="form-group col-xs-8">
								{{ Form::label('nombre','Título del Evento') }}
								{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
							</div>
						</div>
						<div class="row">
							<div class="form-group col-xs-8">
								{{ Form::label('idtipo_eventos','Tipo de Evento') }}
								{{ Form::select('idtipo_eventos',$tipos_eventos,Input::old('idtipo_eventos'),['class' => 'form-control']) }}
							</div>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="row">
							{{ Form::label('fecha_evento','Fecha del Evento') }}
							<div id="datetimepicker1" class="form-group input-group date col-xs-8 @if($errors->first('fecha_evento')) has-error has-feedback @endif">
								{{ Form::text('fecha_evento',Input::old('fecha_evento'),array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-xs-8">
								{{ Form::label('idcolegios','Los niños pertenecen al colegio') }}
								{{ Form::select('idcolegios',$colegios,Input::old('idcolegios'),['class' => 'form-control']) }}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Ingrese la Ubicación del Evento en el Mapa</h3>
				</div>
				<div class="panel-body">
					<div class="col-xs-12">
						<div class="row">
							<div class="form-group col-xs-8 @if($errors->first('direccion')) has-error has-feedback @endif">
								{{ Form::label('direccion','Dirección') }}
								{{ Form::text('direccion',Input::old('direccion'),array('class'=>'form-control')) }}
							</div>
						</div>	
						<div id="map-eventos"></div>
					</div>
					<div class="col-xs-12">
						{{ Form::label('puntos_reunion','Seleccione los Puntos de Reunión') }}
						<div class="row">
							@foreach($puntos_reunion as $punto_reunion)
							<div class="form-group col-xs-4">
								<input class="puntos-reunion-evento" type="checkbox" name="puntos_reunion[]" data-latitud="{{ $punto_reunion->latitud }}" data-longitud="{{ $punto_reunion->longitud }}" data-direccion="{{$punto_reunion->direccion}}" value="{{$punto_reunion->idpuntos_reunion}}"> {{$punto_reunion->direccion}}<br>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Seleccione los Asistentes al Evento <input type="checkbox" name="seleccionar-todos-voluntarios" value=""></h3>
				</div>
				<div class="panel-body">
					<div class="col-xs-12">
						<div class="row">
							@foreach($voluntarios as $voluntario)
							<div class="form-group col-xs-4">
								<input type="checkbox" class="checkbox-voluntarios" name="voluntarios[]" value="{{$voluntario->idusers}}"> {{$voluntario->nombres}} {{$voluntario->apellido_pat}} {{$voluntario->apellido_mat}}<br>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12">
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::submit('Crear',array('class'=>'btn btn-primary')) }}	
					</div>
				</div>
			</div>
		{{ Form::close() }}
	<script src="{{ asset('js/eventos/eventos.js') }}"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
	@endif
@stop