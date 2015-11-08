@extends('templates/colegiosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Colegio</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
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

	{{ Form::open(array('url'=>'colegios/submit_edit_colegio', 'role'=>'form')) }}
		{{ Form::hidden('idcolegios', $colegio_info->idcolegios) }}
		{{ Form::hidden('latitud', $colegio_info->latitud) }}
		{{ Form::hidden('longitud', $colegio_info->longitud) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información Básica</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}
						@if($colegio_info->deleted_at)
							{{ Form::text('nombre',$colegio_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('nombre',$colegio_info->nombre,array('class'=>'form-control')) }}
						@endif
					</div>
					<div class="form-group col-md-6 required @if($errors->first('email_contacto')) has-error has-feedback @endif">
						{{ Form::label('email_contacto','Email contacto') }}
						@if($colegio_info->deleted_at)
							{{ Form::text('email_contacto',$colegio_info->email_contacto,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('email_contacto',$colegio_info->email_contacto,array('class'=>'form-control')) }}
						@endif	
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('nombre_contacto')) has-error has-feedback @endif">
						{{ Form::label('nombre_contacto','Nombre Contacto') }}
						@if($colegio_info->deleted_at)
							{{ Form::text('nombre_contacto',$colegio_info->nombre_contacto,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('nombre_contacto',$colegio_info->nombre_contacto,array('class'=>'form-control')) }}
						@endif	
					</div>
					<div class="form-group col-md-6 required @if($errors->first('interes')) has-error has-feedback @endif">
						{{ Form::label('interes','Interes') }}
						@if($colegio_info->deleted_at)
							{{ Form::text('interes',$colegio_info->interes,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('interes',$colegio_info->interes,array('class'=>'form-control')) }}
						@endif	
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('telefono_contacto')) has-error has-feedback @endif">
						{{ Form::label('telefono_contacto','Telefono contacto') }}
						@if($colegio_info->deleted_at)
							{{ Form::text('telefono_contacto',$colegio_info->telefono_contacto,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('telefono_contacto',$colegio_info->telefono_contacto,array('class'=>'form-control')) }}
						@endif	
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
						{{ Form::label('direccion','Dirección exacta') }}
						@if($colegio_info->deleted_at)
							{{ Form::text('direccion',$colegio_info->direccion,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('direccion',$colegio_info->direccion,array('class'=>'form-control')) }}
						@endif	
					</div>
				</div>	
				<div id="map"></div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				@if(!$colegio_info->deleted_at)
					{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
				@endif	
				{{ Form::close() }}
			</div>
			<div class="form-group col-md-6">
			@if($colegio_info->deleted_at)
				{{ Form::open(array('url'=>'colegios/submit_enable_colegio', 'role'=>'form')) }}
					{{ Form::hidden('colegio_id', $colegio_info->idcolegios) }}
					{{ Form::submit('Habilitar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
			@else
				{{ Form::open(array('url'=>'colegios/submit_disable_colegio', 'role'=>'form')) }}
					{{ Form::hidden('colegio_id', $colegio_info->idcolegios) }}
					{{ Form::submit('Inhabilitar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}	
			@endif
				{{ Form::close() }}
			</div>
		</div>	
	
	<script src="{{ asset('js/colegio/colegios.js') }}"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
@stop