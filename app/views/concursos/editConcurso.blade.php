@extends('templates/concursosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Concurso</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
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

	{{ Form::open(array('url'=>'concursos/submit_edit_concurso', 'role'=>'form')) }}
	{{ Form::hidden('concurso_id', $concurso_info->idconcursos) }}
		
		<div class="row">
			<div class="form-group col-xs-6 required @if($errors->first('titulo')) has-error has-feedback @endif">
				{{ Form::label('titulo','Título') }}
				{{ Form::text('titulo',$concurso_info->titulo,['class' => 'form-control','maxlength'=>100]) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-xs-6" >
				{{ Form::label('resenha','Reseña') }}
				{{ Form::textarea('resenha',$concurso_info->resenha,['class' => 'form-control','maxlength'=>255]) }}
			</div>
		</div>			
		<div class="row">
			<div class="form-group col-xs-1">
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
				{{Form::close()}}	
			</div>
			<div class="form-group col-xs-1">
				{{ Form::open(array('url'=>'concursos/submit_disable_concurso', 'role'=>'form')) }}
					{{ Form::hidden('idconcursos', $concurso_info->idconcursos) }}
					 {{ Form::submit('Eliminar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}
				{{Form::close()}}	
			</div>
		</div>		
		
		
	{{ Form::close() }}
@stop