@extends('templates/concursosTemplate')	
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Fases del concurso</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Registrar Fase Concurso</h3>
		</div>
		<div class="panel-body">
	    {{ Form::hidden('idconcursos',$concurso_info->idconcursos) }}
		
				<div class="row">
					<div class="form-group col-md-6 @if($errors->first('titulo')) has-error has-feedback @endif">
						{{ Form::label('titulo','Título') }}
						{{ Form::text('titulo',Input::old('titulo'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('fecha_limite','Fecha Limite') }}
						<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_limite')) has-error has-feedback @endif">
							{{ Form::text('fecha_limite',Input::old('fecha_limite'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
				
				</div>
				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Descripción') }}
						{{ Form::textarea('descripcion',Input::old('descripcion'),array('class'=>'form-control','rows'=>'4')) }}
					</div>
					<div class="form-group col-md-12">
						{{ HTML::link('','Registrar Fase',array('id'=>'submit-fase-concurso', 'class'=>'btn btn-primary')) }}	
					</div>
				</div>	
			
			
					
						
					
		
		</div>
	</div>
	{{ Form::close() }}  

	<table class="table">
		<tr class="info">
			<th>Titulo</th>
			<th>Descripcion</th>
			<th>Fecha Límite</th>
			<th>Eliminar</th>
		</tr>
		@foreach($faseconcursos_data as $faseconcurso_data)
		<tr class="@if($faseconcurso_data->deleted_at) bg-danger @endif">				
			<td>
				{{$faseconcurso_data->titulo}}
			</td>
			<td>
				{{$faseconcurso_data->descripcion}}
			</td>
			<td>
				{{date('d/m/Y',strtotime($faseconcurso_data->fecha_limite))}}
			</td>			
			<td>
				{{ HTML::link('','Eliminar',array('class'=>'btn btn-danger delete-fase-concurso','data-fase'=>$faseconcurso_data->idfase_concursos)) }}
			</td>
		</tr>
		@endforeach
	</table>
	
@stop