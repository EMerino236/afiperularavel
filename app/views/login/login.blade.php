@extends('templates/loginTemplate')
@section('content')
	<h3 class="text-center">Ingrese a su cuenta</h3>
	<p class="text-center">
		<img src="{{ asset('img') }}/afilogo.png" width="80"/>
	</p>
	<div id="message-container">
		@if (Session::has('error'))
			<div class="alert alert-danger">{{ Session::get('error') }}</div>
		@endif
		@if (Session::has('message'))
			<div class="alert alert-success">{{ Session::get('message') }}</div>
		@endif
	</div>
	<div id="login-container" class="bg-info">
		{{ Form::open(array('url'=>'login', 'role'=>'form')) }}
			<div class="form-group">
				{{ Form::label('num_documento','Número de documento') }}
				{{ Form::text('num_documento',Input::old('num_documento'),array('class'=>'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('password','Contraseña') }}
				{{ Form::password('password',array('class'=>'form-control')) }}
			</div>
			{{ Form::submit('Iniciar Sesión',array('id'=>'submit-login', 'class'=>'btn btn-lg btn-primary btn-block')) }}
			<p class="text-right help-block">{{ HTML::link('/password/remind','Olvidé mi contraseña') }}</p>
		{{ Form::close() }}
	</div>
@stop