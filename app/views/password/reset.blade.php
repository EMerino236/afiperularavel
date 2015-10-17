@extends('templates/passwordTemplate')
@section('content')
	<h3 class="text-center">Ingrese una Contraseña Nueva</h3>
	<p class="text-center">
		<img src="{{ asset('img') }}/afilogo.png" width="80"/>
	</p>
	<div id="message-container">
		@if (Session::has('error'))
			<div class="alert alert-danger">{{ Session::get('error') }}</div>
		@endif
	</div>
	<div id="reset-password-container" class="bg-info">
		<form action="{{ action('RemindersController@postReset') }}" method="POST">
			{{ Form::hidden('token', $token) }}
			{{ Form::label('num_documento','Ingrese su Número de Documento') }}
			{{ Form::text('num_documento','',array('class'=>'form-control')) }}
			{{ Form::label('password','Contraseña Nueva') }}
			{{ Form::password('password',array('class'=>'form-control')) }}
			{{ Form::label('password_confirmation','Confirme su Contraseña') }}
			{{ Form::password('password_confirmation',array('class'=>'form-control')) }}
			{{ Form::submit('Cambiar',array('class'=>'btn btn-lg btn-primary')) }}
		</form>
	</div>
@stop