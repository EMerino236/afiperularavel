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

	{{ Form::open(array('url'=>'convocatorias/search_postulantes','method'=>'get', 'role'=>'form')) }}
		{{ Form::hidden('idperiodos', $convocatoria_info->idperiodos) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la fase de postulación</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<div class="row">
						<div class="form-group col-md-4 @if($errors->first('idfases')) has-error has-feedback @endif">
							{{ Form::label('idfases','Fases de Postulación') }}
							{{ Form::select('idfases',array(''=>'Selecicone')+$fases_postulacion,$idfase,['class' => 'form-control']) }}
						</div>
					</div>	
					<div class="row">
						<div class="form-group col-md-4">
							{{ Form::submit('Buscar Postulantes',array('id'=>'submit-search', 'class'=>'btn btn-primary')) }}	
						</div>
					</div>			
				</div>
			</div>
		</div>
	{{ Form::close() }}

	{{ Form::open(array('url'=>'convocatorias/submit_aprobacion_postulantes', 'role'=>'form')) }}
		{{ Form::hidden('idperiodos', $convocatoria_info->idperiodos) }}
		{{ Form::hidden('idfase', $idfase) }}
		<table class="table">
			<tr class="info">
				<th>No. Documento</th>
				<th>Postulante</th>
				<th>Comentario</th>
				<th>Estado</th>
				<th>Asistencia <input type="checkbox" name="seleccionar-todos-asistio" value="0"></th>
				<th>Aprobación <input type="checkbox" name="seleccionar-todos-aprobados" value="0"></th>
			</tr>
			@foreach($postulantes_info as $postulante_info)
			<tr>
				{{ Form::hidden('idpostulantes_periodos[]', $postulante_info->idpostulantes_periodos) }}
				<td style="vertical-align:middle">
					<a href="{{URL::to('/convocatorias/view_postulante/')}}/{{$postulante_info->idpostulantes_periodos}}">{{$postulante_info->num_documento}}</a>
					</td>
				<td style="vertical-align:middle">{{$postulante_info->nombres}} {{$postulante_info->apellido_pat}} {{$postulante_info->apellido_mat}}</td>
				<td style="vertical-align:middle">
					{{Form::textarea('comentarios[]', $postulante_info->comentario,array('rows'=>'3','cols'=>'70','maxlength'=>'200'))}}
				</td>
				<td style="vertical-align:middle">
					@if($postulante_info->aprobacion === null)
						No Revisado
					@else
						Revisado
					@endif
				</td>
				<td class="text-center" style="vertical-align:middle">
					@if($postulante_info->asistencia === null)
						<input type="checkbox" name="asistencia" class="checkbox-asistencia" value="0" @if($postulante_info->asistencia == 1) checked @endif>
						{{ Form::hidden('asistencias[]', $postulante_info->asistencia,array('class'=>'hidden-asistencia')) }}
					@endif
					@if($postulante_info->asistencia === 1)
						<input hidden type="checkbox" name="asistencia" class="checkbox-asistencia" value="">
						{{ Form::hidden('asistencias[]', -1) }}
						Asistió
					@endif
					@if($postulante_info->asistencia === 0)
						<input hidden type="checkbox" name="asistencia" class="checkbox-asistencia" value="">
						{{ Form::hidden('asistencias[]', -1) }}
						No Asistió
					@endif
				</td>
				<td class="text-center" style="vertical-align:middle">
					@if($postulante_info->aprobacion === null)
						<input type="checkbox" name="aprobacion" class="checkbox-aprobacion" value="0" @if($postulante_info->aprobacion == 1) checked @endif>
						{{ Form::hidden('aprobaciones[]', $postulante_info->aprobacion,array('class'=>'hidden-aprobacion')) }}
					@endif
					@if($postulante_info->aprobacion === 1)
						<input hidden type="checkbox" name="aprobacion" class="checkbox-aprobacion" value="">
						{{ Form::hidden('aprobaciones[]', -1) }}
						Aprobado
					@endif
					@if($postulante_info->aprobacion === 0)
						<input hidden type="checkbox" name="aprobacion" class="checkbox-asistencia" value="">
						{{ Form::hidden('aprobaciones[]', -1) }}
						No Aprobado
					@endif
				</td>
			</tr>
			@endforeach
		</table>
		<div class="col-md-6">
			<div class="row">
				<div class="form-group col-md-8">
					{{ Form::submit('Guardar',array('class'=>'btn btn-primary')) }}	
				</div>
			</div>
		</div>
	{{ Form::close() }}
@stop