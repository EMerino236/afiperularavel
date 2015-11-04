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
			<p><strong>{{ $errors->first('fecha_evento') }}</strong></p>
			<p><strong>{{ $errors->first('idcolegios') }}</strong></p>
			<p><strong>{{ $errors->first('direccion') }}</strong></p>
			<p><strong>{{ $errors->first('voluntarios') }}</strong></p>
			<p><strong>{{ $errors->first('puntos_reunion') }}</strong></p>
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
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('nombre','Título del Evento') }}
							{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
						</div>
						<div class="form-group col-md-6">
							{{ Form::label('fecha_evento','Fecha del Evento') }}
							<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_evento')) has-error has-feedback @endif">
								{{ Form::text('fecha_evento',Input::old('fecha_evento'),array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('idcolegios','Los niños pertenecen al colegio') }}
							{{ Form::select('idcolegios',$colegios,Input::old('idcolegios'),['class' => 'form-control']) }}
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Ingrese la Ubicación del Evento en el Mapa</h3>
				</div>
				<div class="panel-body">
						<div class="row">
							<div class="form-group col-md-6 @if($errors->first('direccion')) has-error has-feedback @endif">
								{{ Form::label('direccion','Dirección') }}
								{{ Form::text('direccion',Input::old('direccion'),array('class'=>'form-control')) }}
							</div>
							<div class="form-group col-md-12">
								<div id="map-eventos"></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								{{ Form::label('puntos_reunion','Seleccione los Puntos de Reunión') }}
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
					<h3 class="panel-title">Seleccione los Asistentes al Evento</h3>
				</div>
				<div class="panel-body">
					<table class="table table-hover">
						<tr class="info">
							<th>No. Documento</th>
							<th>Nombres</th>
							<th>Apellidos</th>
							<th>E-mail</th>
							<th>Teléfono</th>
							<th>Celular</th>
							<th>Seleccionar <input type="checkbox" name="seleccionar-todos-voluntarios" value=""></th>
						</tr>
						@foreach($voluntarios as $voluntario)
						<tr>
							<td>{{$voluntario->num_documento}}</td>
							<td>{{$voluntario->nombres}}</td>
							<td>{{$voluntario->apellido_pat}} {{$voluntario->apellido_mat}}</td>
							<td>{{$voluntario->email}}</td>
							<td>{{$voluntario->telefono}}</td>
							<td>{{$voluntario->celular}}</td>
							<td class="text-center">
								<input type="checkbox" class="checkbox-voluntarios" name="voluntarios[]" value="{{$voluntario->idusers}}">
							</td>
						</tr>
						@endforeach
					</table>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Crear',array('class'=>'btn btn-primary')) }}	
				</div>
			</div>
		{{ Form::close() }}
	<script src="{{ asset('js/eventos/eventos.js') }}"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
	@endif
@stop