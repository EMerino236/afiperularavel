@extends('templates/colegiosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Niño</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>    

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('dni') }}</strong></p>
			<p><strong>{{ $errors->first('nombres') }}</strong></p>
			<p><strong>{{ $errors->first('apellido_pat') }}</strong></p>
			<p><strong>{{ $errors->first('apellido_mat') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_nacimiento') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_apoderado') }}</strong></p>
			<p><strong>{{ $errors->first('dni_apoderado') }}</strong></p>
			<p><strong>{{ $errors->first('num_familiares') }}</strong></p>
			<p><strong>{{ $errors->first('idcolegios') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'ninhos/submit_create_ninho', 'role'=>'form')) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('dni')) has-error has-feedback @endif">
					{{ Form::label('dni','Número de Documento') }}
					{{ Form::text('dni',Input::old('dni'),array('class'=>'form-control')) }}
				</div>	
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombres')) has-error has-feedback @endif">
					{{ Form::label('nombres','Nombres') }}
					{{ Form::text('nombres',Input::old('nombres'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellido_pat')) has-error has-feedback @endif">
					{{ Form::label('apellido_pat','Apellido Paterno') }}
					{{ Form::text('apellido_pat',Input::old('apellido_pat'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellido_mat')) has-error has-feedback @endif">
					{{ Form::label('apellido_mat','Apellido Materno') }}
					{{ Form::text('apellido_mat',Input::old('apellido_mat'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
				<div id="datetimepicker1" class="form-group input-group date col-xs-8 @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
					{{ Form::text('fecha_nacimiento',Input::old('fecha_nacimiento'),array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
				</div>
			</div>		
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre_apoderado')) has-error has-feedback @endif">
					{{ Form::label('nombre_apoderado','Nombre Apoderado') }}
					{{ Form::text('nombre_apoderado',Input::old('nombre_apoderado'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('dni_apoderado')) has-error has-feedback @endif">
					{{ Form::label('dni_apoderado','DNI Apoderado') }}
					{{ Form::text('dni_apoderado',Input::old('dni_apoderado'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('num_familiares')) has-error has-feedback @endif">
					{{ Form::label('num_familiares','Número de Familiares') }}
					{{ Form::text('num_familiares',Input::old('num_familiares'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('observaciones')) has-error has-feedback @endif">
					{{ Form::label('observaciones','Observaciones') }}
					{{ Form::text('observaciones',Input::old('observaciones'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('idcolegios')) has-error has-feedback @endif">
					{{ Form::label('idcolegios','Colegio') }}
					{{ Form::select('idcolegios', $colegios,Input::old('colegios'),['class' => 'form-control']) }}
				</div>
			</div>
		</div>
	{{ Form::close() }}
@stop
