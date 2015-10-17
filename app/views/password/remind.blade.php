@extends('templates/passwordTemplate')
@section('content')
	<h3 class="text-center">¿Olvidó su contraseña?</h3>
	<p class="text-center">
		<img src="{{ asset('img') }}/afilogo.png" width="80"/>
	</p>
	<div id="message-container">
		@if (Session::has('error'))
			<div class="alert alert-danger">{{ Session::get('error') }}</div>
		@endif

		@if (Session::has('status'))
			<div class="alert alert-success">{{ Session::get('status') }}</div>
		@endif
	</div>
	<div id="reset-password-container" class="bg-info">
		<form action="{{ action('RemindersController@postRemind') }}" method="POST">
			{{ Form::label('email','Ingrese su email') }}
			{{ Form::text('email','',array('class'=>'form-control')) }}
			{{ Form::submit('Enviar',array('class'=>'btn btn-lg btn-primary')) }}
		</form>
		<p class="text-right help-block">{{ HTML::link('/','Regresar al Login') }}</p>
	</div>
		 
@stop