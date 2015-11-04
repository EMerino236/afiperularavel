@extends('templates/convocatoriasTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Proceso de Postulación: {{$convocatoria_info->nombre}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idfases') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'convocatorias/list_postulantes', 'role'=>'form')) }}
		{{ Form::hidden('convocatoria_id', $convocatoria_info->idperiodos) }}
		<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Datos de la fase de postulación</h3>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="row">
							<div class="form-group col-md-4 @if($errors->first('idfases')) has-error has-feedback @endif">
								{{ Form::label('idfases','Fases de Postulación') }}
								{{ Form::select('idfases',array(''=>'Selecicone')+$fases_postulacion,Input::old('idfases'),['class' => 'form-control']) }}
							</div>
						</div>	
						<div class="row">
							<div class="form-group col-md-4">
								{{ Form::submit('Buscar Postulantes',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
							</div>
						</div>			
					</div>
				</div>
			</div>
	{{ Form::close() }}
	<table class="table">
		<tr class="info">
			<th>No. Documento</th>
			<th>Postulante</th>
			<th>Comentario</th>
			<th>Asistencia <input type="checkbox" name="seleccionar-todos-asistio" value="0"></th>
			<th>Aprobación <input type="radio" name="seleccionar-todos-aprobados" value="0"> <input type="radio" name="seleccionar-todos-rechazados" value="0"></th>
		</tr>
		@foreach($postulantes_info as $postulante_info)
		<tr>
			{{ Form::hidden('idasistencias[]', $postulante_info->idasistencias) }}
			<td style="vertical-align:middle">{{$postulante_info->num_documento}}</td>
			<td style="vertical-align:middle">{{$postulante_info->nombres}} {{$postulante_info->apellido_pat}} {{$postulante_info->apellido_mat}}</td>
			<td style="vertical-align:middle">
				{{Form::textarea('comentarios[]', $postulante_info->comentario,array('rows'=>'3','cols'=>'70','maxlength'=>'200'))}}
			</td>
			<td class="text-center" style="vertical-align:middle">
				<input type="checkbox" name="asistio" class="checkbox-asistio" value="0" @if($postulante_info->asistio == 1) checked @endif>
				{{ Form::hidden('asistencias[]', $postulante_info->asistio) }}
			</td>
		</tr>
		@endforeach
	</table>
@stop