@extends('templates/userTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Mi Cuenta</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
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

	{{ Form::open(array('url'=>'user/submit_mi_cuenta', 'role'=>'form')) }}
		{{ Form::hidden('latitud', $user_info->latitud) }}
		{{ Form::hidden('longitud', $user_info->longitud) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información de la cuenta</h3>
			</div>
			<div class="panel-body">
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('idtipo_identificacion','Tipo de identificación') }}
							{{ Form::text('idtipo_identificacion',$user_info->nombre_tipo_identificacion,array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('num_documento','Número de Documento') }}
							{{ Form::text('num_documento',$user_info->num_documento,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8 @if($errors->first('password')) has-error has-feedback @endif">
							{{ Form::label('password','Cambiar Contraseña') }}
							{{ Form::password('password',array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8 @if($errors->first('password_confirmation')) has-error has-feedback @endif">
							{{ Form::label('password_confirmation','Confirmar Nueva Contraseña') }}
							{{ Form::password('password_confirmation',array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información de contacto</h3>
			</div>
			<div class="panel-body">
			<div class="col-xs-6">
				<div class="row">
					<div class="form-group col-xs-8 @if($errors->first('nombres')) has-error has-feedback @endif">
						{{ Form::label('nombres','Nombres') }}
						{{ Form::text('nombres',$user_info->nombres,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8 @if($errors->first('apellido_pat')) has-error has-feedback @endif">
						{{ Form::label('apellido_pat','Apellido Paterno') }}
						{{ Form::text('apellido_pat',$user_info->apellido_pat,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8 @if($errors->first('apellido_mat')) has-error has-feedback @endif">
						{{ Form::label('apellido_mat','Apellido Materno') }}
						{{ Form::text('apellido_mat',$user_info->apellido_mat,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('fecha_nac','Fecha de Nacimiento Registrada') }}
						{{ Form::text('fecha_nac',date('d-m-Y',strtotime($user_info->fecha_nacimiento)),array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					{{ Form::label('fecha_nacimiento','Cambiar Fecha de Nacimiento') }}
					<div id="datetimepicker1" class="form-group input-group date col-xs-8 @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
						{{ Form::text('fecha_nacimiento',Input::old('fecha_nacimiento'),array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="row">
					<div class="form-group col-xs-8 @if($errors->first('direccion')) has-error has-feedback @endif">
						{{ Form::label('direccion','Dirección') }}
						{{ Form::text('direccion',$user_info->direccion,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8 @if($errors->first('telefono')) has-error has-feedback @endif">
						{{ Form::label('telefono','Teléfono') }}
						{{ Form::text('telefono',$user_info->telefono,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8 @if($errors->first('celular')) has-error has-feedback @endif">
						{{ Form::label('celular','Celular') }}
						{{ Form::text('celular',$user_info->celular,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('email_reg','E-mail Registrado') }}
						{{ Form::text('email_reg',$user_info->email,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8 @if($errors->first('email')) has-error has-feedback @endif">
						{{ Form::label('email','Cambiar E-mail') }}
						{{ Form::text('email','',array('class'=>'form-control')) }}
					</div>
				</div>
			</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Ingrese su ubicación en el mapa</h3>
			</div>
			<div class="panel-body">
			<div id="map"></div>
			</div>
		</div>
		{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
	{{ Form::close() }}
@stop