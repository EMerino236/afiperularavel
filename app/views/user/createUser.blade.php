@extends('templates/userTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Usuario</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idtipo_identificacion') }}</strong></p>
			<p><strong>{{ $errors->first('num_documento') }}</strong></p>
			<p><strong>{{ $errors->first('nombres') }}</strong></p>
			<p><strong>{{ $errors->first('apellido_pat') }}</strong></p>
			<p><strong>{{ $errors->first('apellido_mat') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_nacimiento') }}</strong></p>
			<p><strong>{{ $errors->first('direccion') }}</strong></p>
			<p><strong>{{ $errors->first('telefono') }}</strong></p>
			<p><strong>{{ $errors->first('celular') }}</strong></p>
			<p><strong>{{ $errors->first('email') }}</strong></p>
			<p><strong>{{ $errors->first('perfiles') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'user/submit_create_user', 'role'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información de la cuenta</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('idtipo_identificacion')) has-error has-feedback @endif">
						{{ Form::label('idtipo_identificacion','Tipo de identificación') }}
						{{ Form::select('idtipo_identificacion',$tipos_identificacion,Input::old('idtipo_identificacion'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-6 required @if($errors->first('num_documento')) has-error has-feedback @endif">
						{{ Form::label('num_documento','Número de Documento') }}
						{{ Form::text('num_documento',Input::old('num_documento'),array('class'=>'form-control','maxlength'=>'16')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12 required">
						{{ Form::label('perfiles','Seleccione el/los perfiles') }}
						@foreach($perfiles as $perfil)
						<div class="row">
							<div class="form-group col-md-4 @if($errors->first('perfiles')) has-error has-feedback @endif">
								{{ Form::checkbox('perfiles[]',$perfil->idperfiles) }} {{$perfil->nombre}}
							</div>
						</div>
						@endforeach
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<span>*La contraseña será autogenerada y enviada al email ingresado.</span>
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
					<div class="form-group col-md-6 required @if($errors->first('nombres')) has-error has-feedback @endif">
						{{ Form::label('nombres','Nombres') }}
						{{ Form::text('nombres',Input::old('nombres'),array('class'=>'form-control','maxlength'=>'100')) }}
					</div>
					<div class="form-group col-md-6 required @if($errors->first('direccion')) has-error has-feedback @endif">
						{{ Form::label('direccion','Dirección') }}
						{{ Form::text('direccion',Input::old('direccion'),array('class'=>'form-control','maxlength'=>'150')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('apellido_pat')) has-error has-feedback @endif">
						{{ Form::label('apellido_pat','Apellido Paterno') }}
						{{ Form::text('apellido_pat',Input::old('apellido_pat'),array('class'=>'form-control','maxlength'=>'100')) }}
					</div>
					<div class="form-group col-md-6 @if($errors->first('telefono')) has-error has-feedback @endif">
						{{ Form::label('telefono','Teléfono') }}
						{{ Form::text('telefono',Input::old('telefono'),array('class'=>'form-control','maxlength'=>'20')) }}
					</div>				
				</div>
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('apellido_mat')) has-error has-feedback @endif">
						{{ Form::label('apellido_mat','Apellido Materno') }}
						{{ Form::text('apellido_mat',Input::old('apellido_mat'),array('class'=>'form-control','maxlength'=>'100')) }}
					</div>
					<div class="form-group col-md-6 @if($errors->first('celular')) has-error has-feedback @endif">
						{{ Form::label('celular','Celular') }}
						{{ Form::text('celular',Input::old('celular'),array('class'=>'form-control','maxlength'=>'20')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6 required">
						{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
						<div id="fecha-nacimiento" class="form-group input-group date @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
							{{ Form::text('fecha_nacimiento',Input::old('fecha_nacimiento'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="form-group col-md-6 required @if($errors->first('email')) has-error has-feedback @endif">
						{{ Form::label('email','E-mail') }}
						{{ Form::text('email',Input::old('email'),array('class'=>'form-control','maxlength'=>'100')) }}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
			</div>
		</div>
	{{ Form::close() }}
@stop