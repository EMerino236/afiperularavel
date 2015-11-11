@extends('templates/concursosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Proyecto</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
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

	{{ Form::open(array('url'=>'concursos/submit_edit_proyecto', 'role'=>'form')) }}
	{{ Form::hidden('proyecto_id', $proyecto_info->idproyectos) }}
		
		<div class="row">
			<div class="form-group col-md-6 required @if($errors->first('nombre')) has-error has-feedback @endif">
				{{ Form::label('nombre','Nombre Proyecto') }}
				{{ Form::text('nombre',$proyecto_info->nombre,['class' => 'form-control','maxlength'=>100]) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 required @if($errors->first('concursos')) has-error has-feedback @endif">
				{{ Form::label('concursos','Concurso') }}
				{{ Form::select('concursos',$concursos_data,$proyecto_info->idconcursos,['class' => 'form-control']) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 required @if($errors->first('jefe_proyecto')) has-error has-feedback @endif">
				{{ Form::label('jefe_proyecto','Nombre Jefe Proyecto') }}
				{{ Form::text('jefe_proyecto',$proyecto_info->jefe_proyecto,['class' => 'form-control','maxlength'=>100]) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6" >
				{{ Form::label('resenha','Reseña') }}
				{{ Form::textarea('resenha',$proyecto_info->resenha,['class' => 'form-control','maxlength'=>255]) }}
			</div>
		</div>			
		<div class="row">
			<div class="form-group col-md-1">
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
				{{Form::close()}}	
			</div>
			<div class="form-group col-md-1">
				{{ Form::open(array('url'=>'concursos/submit_disable_proyecto', 'role'=>'form')) }}
					{{ Form::hidden('proyecto_id', $proyecto_info->idproyectos) }}
					 {{ Form::submit('Eliminar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}
				{{Form::close()}}	
			</div>
		</div>		
		
		
	{{ Form::close() }}
@stop