@extends('templates/eventosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">{{$evento_info->nombre}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	{{ Form::open(array('url'=>'eventos/submit_asistencia_evento', 'role'=>'form')) }}
		{{ Form::hidden('ideventos', $evento_info->ideventos) }}		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Tomar Asistencia</h3>
			</div>
			<div class="panel-body">
				<table class="table">
					<tr class="info">
						<th>No. Documento</th>
						<th>Voluntario</th>
						<th>Calificación</th>
						<th>Comentario</th>
						<th>Asistió <input type="checkbox" name="seleccionar-todos-asistio" value="0"></th>
					</tr>
					@foreach($voluntarios as $voluntario)
					<tr>
						{{ Form::hidden('idasistencias[]', $voluntario->idasistencias) }}
						<td style="vertical-align:middle">{{$voluntario->num_documento}}</td>
						<td style="vertical-align:middle">{{$voluntario->nombres}} {{$voluntario->apellido_pat}} {{$voluntario->apellido_mat}}</td>
						<td style="vertical-align:middle"><input name="calificaciones[]" type="number" value="{{$voluntario->calificacion}}" class="calificacion" min=0 max=5 step=1.0 data-size="sm"></td>
						<td style="vertical-align:middle">
							{{Form::textarea('comentarios[]', $voluntario->comentario,array('rows'=>'3','cols'=>'70','maxlength'=>'200'))}}
						</td>
						<td class="text-center" style="vertical-align:middle">
							<input type="checkbox" name="asistio" class="checkbox-asistio" value="0" @if($voluntario->asistio == 1) checked @endif>
							{{ Form::hidden('asistencias[]', $voluntario->asistio,array('class'=>'hidden-asistencia')) }}
						</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
		@if($hoy < date('Y-m-d', strtotime($evento_info->fecha_evento. ' + 2 days')))
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Guardar',array('class'=>'btn btn-primary')) }}	
				</div>
			</div>
		</div>
		@endif
	{{ Form::close() }}

    <script src="{{ asset('js/star-rating.min.js') }}"></script>
    <script src="{{ asset('js/eventos/asistencia.js') }}"></script>
@stop