@extends('templates/concursosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Concurso</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('titulo') }}</strong></p>
			<p><strong>{{ $errors->first('resenha') }}</strong></p>
			
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
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('titulo')) has-error has-feedback @endif">
					{{ Form::label('titulo','Título') }}
					{{ Form::text('titulo',$concurso_info->titulo,['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('resenha')) has-error has-feedback @endif">
					{{ Form::label('resenha','Reseña') }}
					{{ Form::textarea('resenha',$concurso_info->resenha,['class' => 'form-control']) }}
				</div>
			</div>			
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
				</div>
			</div>		
		</div>
		
	{{ Form::close() }}
@stop