@extends('templates/userTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Usuario</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idtipo_identificacion') }}</strong></p>
			<p><strong>{{ $errors->first('nombres') }}</strong></p>
			<p><strong>{{ $errors->first('apellido_pat') }}</strong></p>
			<p><strong>{{ $errors->first('apellido_mat') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_nacimiento') }}</strong></p>
			<p><strong>{{ $errors->first('direccion') }}</strong></p>
			<p><strong>{{ $errors->first('telefono') }}</strong></p>
			<p><strong>{{ $errors->first('celular') }}</strong></p>
			<p><strong>{{ $errors->first('email') }}</strong></p>
			<p><strong>{{ $errors->first('password') }}</strong></p>
			<p><strong>{{ $errors->first('password_confirmation') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'user/submit_edit_user', 'role'=>'form')) }}
		{{ Form::hidden('user_id', $user_info->id) }}
		{{ Form::hidden('latitud', $user_info->latitud) }}
		{{ Form::hidden('longitud', $user_info->longitud) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información de la cuenta: <strong>{{$user_info->num_documento}}</strong></h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6 required">
						{{ Form::label('idtipo_identificacion','Tipo de identificación') }}
						{{ Form::select('idtipo_identificacion',$tipos_identificacion,Input::old('idtipo_identificacion'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('num_documento','Cambiar Número de Documento') }}
						{{ Form::text('num_documento',null,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						{{ Form::label('perfiles','Perfiles') }}
						<ul>
							@foreach($perfiles as $perfil)
							<li>{{$perfil->nombre}}</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información de contacto</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6 required">
						{{ Form::label('nombres','Nombres') }}
						{{ Form::text('nombres',$user_info->nombres,array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-6 required">
						{{ Form::label('direccion','Dirección') }}
						{{ Form::text('direccion',$user_info->direccion,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6 required">
						{{ Form::label('apellido_pat','Apellido Paterno') }}
						{{ Form::text('apellido_pat',$user_info->apellido_pat,array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('telefono','Teléfono') }}
						{{ Form::text('telefono',$user_info->telefono,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6 required">
						{{ Form::label('apellido_mat','Apellido Materno') }}
						{{ Form::text('apellido_mat',$user_info->apellido_mat,array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('celular','Celular') }}
						{{ Form::text('celular',$user_info->celular,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						{{ Form::label('fecha_nac','Fecha de Nacimiento Registrada') }}
						{{ Form::text('fecha_nac',date('d-m-Y',strtotime($user_info->fecha_nacimiento)),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('email_reg','E-mail Registrado') }}
						{{ Form::text('email_reg',$user_info->email,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						{{ Form::label('fecha_nacimiento','Cambiar Fecha de Nacimiento') }}
						<div id="fecha-nacimiento" class="form-group input-group date @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
							{{ Form::text('fecha_nacimiento',Input::old('fecha_nacimiento'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="form-group col-md-6 @if($errors->first('email')) has-error has-feedback @endif">
						{{ Form::label('email','Cambiar E-mail') }}
						{{ Form::text('email','',array('class'=>'form-control')) }}
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Ingrese su ubicación en el mapa</h3>
			</div>
			<div class="panel-body">
				<input id="pac-input" class="controls" type="text" placeholder="Bucar lugares">
				<div id="map"></div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-6">
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
				{{ Form::close() }}
			</div>
			<div class="form-group col-md-6">
			@if($user_info->deleted_at)
				{{ Form::open(array('url'=>'user/submit_enable_user', 'role'=>'form')) }}
					{{ Form::hidden('user_id', $user_info->id) }}
					{{ Form::submit('Habilitar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
			@else
				{{ Form::open(array('url'=>'user/submit_disable_user', 'role'=>'form')) }}
					{{ Form::hidden('user_id', $user_info->id) }}
					{{ Form::submit('Inhabilitar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}
			@endif
				{{ Form::close() }}
			</div>
		</div>
<script src="{{ asset('js/gmap.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap" async defer></script>
@stop