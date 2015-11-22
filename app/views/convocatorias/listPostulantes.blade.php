@extends('templates/convocatoriasTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Proceso de Postulación del Periodo: {{$convocatoria_info->nombre}}</h3>
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
							{{ Form::select('idfases',$fases_postulacion,$idfase,['class' => 'form-control']) }}
						</div>
						<div class="form-group col-md-4 @if($errors->first('select_aprobacion')) has-error has-feedback @endif">
							{{ Form::label('select_aprobacion','Estado de Aprobación') }}
							{{ Form::select('select_aprobacion',['-1'=>'Sin Revisión','1'=>'Aprobado','0'=>'Desaprobado'],$estado_aprobacion,['class' => 'form-control']) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4">
							{{ Form::submit('Buscar',array('id'=>'submit-search', 'class'=>'btn btn-info')) }}	
						</div>
					</div>			
				</div>
			</div>
		</div>
	{{ Form::close() }}

	{{ Form::open(array('url'=>'convocatorias/submit_aprobacion_postulantes', 'role'=>'form','id'=>'submitAprobacion')) }}
		{{ Form::hidden('idperiodos', $convocatoria_info->idperiodos) }}
		{{ Form::hidden('idfase', $idfase) }}
		<input type="hidden" id="cantidad_postulantes" name="cantidad_postulantes" value="<?php echo $cantidad_postulantes; ?>" />
		<table class="table">
			<tr class="info">
				<th>No. Documento</th>
				<th>Postulante</th>
				<th>Comentario</th>
				<th>Estado</th>
				<th>Asistencia <br />Si <input type="checkbox" class="checkbox-todos-asistio" name="seleccionar-todos-asistio" value="0"> No <input type="checkbox" class="checkbox-todos-no-asistio" name="seleccionar-todos-no-asistio" value="0"> </th>
				<th>Aprobación <br />Si <input type="checkbox" class="checkbox-todos-aprobados" name="seleccionar-todos-aprobados" value="0"> No <input type="checkbox" class="checkbox-todos-no-aprobados" name="seleccionar-todos-no-aprobados" value="0"></th>
			</tr>
			@foreach($postulantes_info as $postulante_info)
			<tr>
				{{ Form::hidden('idpostulantes_periodos[]', $postulante_info->idpostulantes_periodos) }}
				<td style="vertical-align:middle">
					<a href="{{URL::to('/convocatorias/view_postulante/')}}/{{$postulante_info->idpostulantes_periodos}}">{{$postulante_info->num_documento}}</a>
					</td>
				<td style="vertical-align:middle">{{$postulante_info->nombres}} {{$postulante_info->apellido_pat}} {{$postulante_info->apellido_mat}}</td>
				<td style="vertical-align:middle">
					{{Form::textarea('comentarios[]', $postulante_info->comentario,array('rows'=>'4','cols'=>'60','maxlength'=>'255'))}}
				</td>
				<td style="vertical-align:middle">
					@if($postulante_info->aprobacion === null)
						Sin Revisión
					@else
						Revisado
					@endif
				</td>
				<td class="text-center" style="vertical-align:middle">
					@if($postulante_info->asistencia == -1)
						Si <input type="checkbox" name="asistencia" class="checkbox-asistencia" value="0"> No <input type="checkbox" name="no-asistencia" class="checkbox-no-asistencia" value="0">
						{{ Form::hidden('asistencias[]', $postulante_info->asistencia,array('class'=>'hidden-asistencia')) }}
						{{ Form::hidden('no-asistencias[]', $postulante_info->asistencia,array('class'=>'hidden-no-asistencia')) }}
					@endif
					@if($postulante_info->asistencia == 1)
						<input hidden type="checkbox" name="asistencia" class="checkbox-asistencia" value="">
						{{ Form::hidden('asistencias[]', -1) }}
						{{ Form::hidden('no-asistencias[]', -1) }}
						Asistió
					@endif
					@if($postulante_info->asistencia == 0)
						<input hidden type="checkbox" name="asistencia" class="checkbox-asistencia" value="">
						{{ Form::hidden('asistencias[]', -1) }}
						{{ Form::hidden('no-asistencias[]', -1) }}
						No Asistió
					@endif
				</td>
				<td class="text-center" style="vertical-align:middle">
					@if($postulante_info->aprobacion == -1)
						Si <input type="checkbox" name="aprobacion" class="checkbox-aprobacion" value="0"> No <input type="checkbox" name="no-aprobacion" class="checkbox-no-aprobacion" value="0">
						{{ Form::hidden('aprobaciones[]', $postulante_info->aprobacion,array('class'=>'hidden-aprobacion')) }}
						{{ Form::hidden('no-aprobaciones[]', $postulante_info->aprobacion,array('class'=>'hidden-no-aprobacion')) }}
					@endif
					@if($postulante_info->aprobacion == 1)
						<input hidden type="checkbox" name="aprobacion" class="checkbox-aprobacion" value="">
						{{ Form::hidden('aprobaciones[]', -1) }}
						{{ Form::hidden('no-aprobaciones[]', -1) }}
						Aprobado
					@endif
					@if($postulante_info->aprobacion == 0)
						<input hidden type="checkbox" name="aprobacion" class="checkbox-aprobacion" value="">
						{{ Form::hidden('aprobaciones[]', -1) }}
						{{ Form::hidden('no-aprobaciones[]', -1) }}
						No Aprobado
					@endif
				</td>
			</tr>
			@endforeach
		</table>
		@if($idfase)
			{{ $postulantes_info->appends(array('idfases' => $idfase,'select_aprobacion'=>$estado_aprobacion))->links() }}
		@else
			{{ $postulantes_info->links() }}
		@endif
		<div class="col-md-6">
			<div class="row">
				@if($estado_aprobacion === null)
					<div class="form-group col-md-2">
						{{ Form::submit('Guardar',array('id'=>'submit-aprobacion-postulantes','class'=>'btn btn-primary')) }}	
					</div>
				@endif
				<div class="form-group col-md-3">
					<a class="btn btn-default btn-block" href="{{URL::to('/convocatorias/list_convocatoria/')}}">Regresar</a>				
				</div>
			</div>
		</div>
	{{ Form::close() }}
@stop