@extends('templates/convocatoriasTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nueva Convocatoria</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_inicio') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_fin') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'convocatorias/submit_create_convocatoria', 'role'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos Generales</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<div class="form-group required @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre de Periodo') }}
							{{ Form::text('nombre',Input::old('nombre'),['class' => 'form-control','maxlength'=>'100']) }}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group required col-md-4">
						{{ Form::label('fecha_inicio','Fecha de inicio del Periodo') }}
						<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_inicio')) has-error has-feedback @endif">
							{{ Form::text('fecha_inicio',Input::old('fecha_inicio'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group required col-md-4">
						{{ Form::label('fecha_fin','Fecha de fin del Periodo') }}
						<div id="datetimepicker2" class="form-group input-group date @if($errors->first('fecha_fin')) has-error has-feedback @endif">
							{{ Form::text('fecha_fin',Input::old('fecha_fin'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
						</div>
					</div>	
				</div>
			</div>
		</div>
	{{ Form::close() }}
@stop