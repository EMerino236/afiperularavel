@extends('templates/concursosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Concurso</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    </br>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('titulo') }}</strong></p>
			
			
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'concursos/submit_create_concurso', 'role'=>'form')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Datos Generales</h3>
		</div>
		<div class="panel-body">	
			<div class="row">
				<div class="form-group col-md-6 required @if($errors->first('titulo')) has-error has-feedback @endif">
					{{ Form::label('titulo','Título') }}
					{{ Form::text('titulo',Input::old('titulo'),array('class'=>'form-control','maxlength'=>100)) }}
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