@extends('templates/colegiosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Colegio</h3>
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
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'colegios/submit_create_colegio', 'role'=>'form')) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre_contacto')) has-error has-feedback @endif">
					{{ Form::label('nombre_contacto','Nombre Contacto') }}
					{{ Form::text('nombre_contacto',Input::old('nombre_contacto'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('telefono_contacto')) has-error has-feedback @endif">
					{{ Form::label('telefono_contacto','Telefono contacto') }}
					{{ Form::text('telefono_contacto',Input::old('telefono_contacto'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
				</div>
			</div>	
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('direccion')) has-error has-feedback @endif">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',Input::old('direccion'),array('class'=>'form-control')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('email_contacto')) has-error has-feedback @endif">
					{{ Form::label('email_contacto','Email contacto') }}
					{{ Form::text('email_contacto',Input::old('email_contacto'),array('class'=>'form-control')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('interes')) has-error has-feedback @endif">
					{{ Form::label('interes','Interes') }}
					{{ Form::text('interes',Input::old('interes'),array('class'=>'form-control')) }}
				</div>
			</div>
			
		</div>
	{{ Form::close() }}
@stop