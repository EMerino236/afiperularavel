@extends('templates/concursosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Proyecto</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    </br>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('concursos') }}</strong></p>
			<p><strong>{{ $errors->first('jefe_proyecto') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'concursos/submit_create_proyecto', 'role'=>'form')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Datos Generales</h3>
		</div>
		<div class="panel-body">	
			<div class="row">
				<div class="form-group col-md-6 required @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre Proyecto') }}
					{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control','maxlength'=>100)) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 required @if($errors->first('idconcursos')) has-error has-feedback @endif">
					{{ Form::label('concursos','Concurso') }}
					{{ Form::select('concursos',array(""=>"Seleccione")+$concursos_data,Input::old('concursos'),['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 required @if($errors->first('jefe_proyecto')) has-error has-feedback @endif">
					{{ Form::label('jefe_proyecto','Nombre Jefe Proyecto') }}
					{{ Form::text('jefe_proyecto',Input::old('jefe_proyecto'),array('class'=>'form-control','maxlength'=>100)) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 ">
					{{ Form::label('resenha','Reseña') }}
					{{ Form::textarea('resenha',Input::old('resenha'),array('class'=>'form-control','maxlength'=>255)) }}
				</div>
			</div>					
			<div class="row">
				<div class="form-group col-md-8">
					{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
				</div>
			</div>		
		</div>
	</div>	
		
	{{ Form::close() }}
@stop