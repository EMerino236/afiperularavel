@extends('templates/eventosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Evento</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
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
	{{ Form::open(array('url'=>'eventos/submit_edit_evento', 'role'=>'form')) }}
		{{ Form::hidden('ideventos', $evento_info->ideventos) }}
		{{ Form::hidden('idperiodos', $evento_info->idperiodos) }}
		{{ Form::hidden('latitud', $evento_info->latitud) }}
		{{ Form::hidden('longitud', $evento_info->longitud) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información Básica</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6 required">
						{{ Form::label('nombre','Título del Evento') }}
						@if($hoy < $evento_info->fecha_evento)
							{{ Form::text('nombre',$evento_info->nombre,array('class'=>'form-control','maxlength'=>'100')) }}
						@else
							{{ Form::text('nombre',$evento_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
						@endif
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('fecha','Fecha del Evento') }}
						{{ Form::text('fecha',date('d/m/Y - H:i',strtotime($evento_info->fecha_evento)),array('class'=>'form-control','readonly'=>'')) }}
					</div>
				</div>
				@if($hoy < $evento_info->fecha_evento)
				<div class="row">
					<div class="form-group col-md-6">
						{{ Form::label('fecha_evento','Cambiar Fecha del Evento') }}
						<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_evento')) has-error has-feedback @endif">
							{{ Form::text('fecha_evento',null,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Ubicación del Evento en el Mapa</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('direccion')) has-error has-feedback @endif">
						{{ Form::label('direccion','Dirección') }}
						@if($hoy < $evento_info->fecha_evento)
							{{ Form::text('direccion',$evento_info->direccion,array('class'=>'form-control','maxlength'=>'100')) }}
						@else
							{{ Form::text('direccion',$evento_info->direccion,array('class'=>'form-control','readonly'=>'')) }}
						@endif
					</div>
					<div class="form-group col-md-12">
						<div id="map-eventos"></div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						@if($puntos_reunion->isEmpty())
							{{ Form::label('puntos_reunion','No existen puntos de reunión creados') }}
						@else
							{{ Form::label('puntos_reunion','Puntos de Reunión') }}
							@foreach($puntos_reunion as $punto_reunion)
							<div class="form-group col-md-4">
								<input class="puntos-reunion-evento" type="checkbox" name="puntos_reunion[]" data-latitud="{{ $punto_reunion->latitud }}" data-longitud="{{ $punto_reunion->longitud }}" data-direccion="{{$punto_reunion->direccion}}" value="{{$punto_reunion->idpuntos_reunion}}" @if(in_array($punto_reunion->idpuntos_reunion,$puntos_reunion_seleccionados)) checked @endif @if($hoy >= $evento_info->fecha_evento) disabled @endif> {{$punto_reunion->direccion}}<br>
							</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Voluntarios Asistentes</h3>
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
					</tr>
					@foreach($voluntarios as $voluntario)
					<tr>
						<td>{{$voluntario->num_documento}}</td>
						<td>{{$voluntario->nombres}}</td>
						<td>{{$voluntario->apellido_pat}} {{$voluntario->apellido_mat}}</td>
						<td>{{$voluntario->email}}</td>
						<td>{{$voluntario->telefono}}</td>
						<td>{{$voluntario->celular}}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
		@if($hoy < $evento_info->fecha_evento)
		<div class="col-md-6">
			<div class="row">
				<div class="form-group col-md-8">
					{{ Form::submit('Guardar',array('class'=>'btn btn-primary')) }}	
				</div>
			</div>
		</div>
		@endif
	{{ Form::close() }}
		@if($hoy < $evento_info->fecha_evento)
		<div class="col-md-6">
			<div class="row">
				<div class="form-group col-md-8">
					{{ Form::open(array('url'=>'eventos/submit_delete_evento', 'role'=>'form')) }}
					{{ Form::hidden('ideventos', $evento_info->ideventos) }}
					{{ Form::submit('Cancelar Evento',array('class'=>'btn btn-danger')) }}
					{{ Form::close() }}
				</div>
			</div>
		</div>
		@endif
<script src="{{ asset('js/eventos/edit-eventos.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
@stop