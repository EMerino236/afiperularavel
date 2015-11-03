@extends('templates/eventosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Evento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
		{{ Form::hidden('ideventos', $evento_info->ideventos) }}
		{{ Form::hidden('idperiodos', $evento_info->idperiodos) }}
		{{ Form::hidden('latitud', $evento_info->latitud) }}
		{{ Form::hidden('longitud', $evento_info->longitud) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información Básica</h3>
			</div>
			<div class="panel-body">
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('nombre','Título del Evento') }}
							{{ Form::text('nombre',$evento_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
						</div>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('fecha','Fecha del Evento') }}
							{{ Form::text('fecha',date('d/m/Y - H:i',strtotime($evento_info->fecha_evento)),array('class'=>'form-control','readonly'=>'')) }}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Ubicación del Evento en el Mapa</h3>
			</div>
			<div class="panel-body">
				<div class="col-xs-12">
					<div class="row">
						<div class="form-group col-xs-8 @if($errors->first('direccion')) has-error has-feedback @endif">
							{{ Form::label('direccion','Dirección') }}
							{{ Form::text('direccion',$evento_info->direccion,array('class'=>'form-control','readonly'=>'')) }}
						</div>
					</div>	
					<div id="map-eventos"></div>
				</div>
				<div class="col-xs-12">
					{{ Form::label('puntos_reunion','Puntos de Reunión') }}
					<div class="row">
						@foreach($puntos_reunion as $punto_reunion)
							@if(in_array($punto_reunion->idpuntos_reunion,$puntos_reunion_seleccionados))
								<div class="form-group col-xs-4">
									<input class="puntos-reunion-evento" type="checkbox" name="puntos_reunion[]" data-latitud="{{ $punto_reunion->latitud }}" data-longitud="{{ $punto_reunion->longitud }}" data-direccion="{{$punto_reunion->direccion}}" value="{{$punto_reunion->idpuntos_reunion}}" checked disabled> {{$punto_reunion->direccion}}<br>
								</div>
							@endif
						@endforeach
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
						<th>Nombre</th>
					</tr>
					@foreach($voluntarios as $voluntario)
					<tr>
						<td>{{$voluntario->num_documento}}</td>
						<td>{{$voluntario->nombres}} {{$voluntario->apellido_pat}} {{$voluntario->apellido_mat}}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Documentos del Evento</h3>
			</div>
			<div class="panel-body">
				<div class="col-xs-12">
					@foreach($documentos as $documento)
					{{ Form::open(array('url'=>'eventos/descargar_documento', 'role'=>'form')) }}
						{{ Form::hidden('ideventos', $evento_info->ideventos) }}
						{{ Form::hidden('iddocumentos', $documento->iddocumentos) }}
						<div class="row">
							<div class="form-group col-xs-8">
								<button type="submit" class="btn btn-primary">
								  <span class="fa fa-download"></span> {{$documento->titulo}}
								</button>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
<script src="{{ asset('js/eventos/ver-evento.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
@stop