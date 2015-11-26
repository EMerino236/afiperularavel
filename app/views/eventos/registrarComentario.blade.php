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
	{{ Form::open(array('url'=>'eventos/submit_registrar_comentario', 'role'=>'form')) }}
		{{ Form::hidden('ideventos', $evento_info->ideventos) }}		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Registrar Comentario</h3>
			</div>
			<div class="panel-body">
				<table class="table">
					<tr class="info">
						<th>Nombre del niño</th>
						<th>Calificación</th>
						<th>Comentario</th>
					</tr>
					@for ($i = 0; $i < count($asistencia_ninhos); $i++)
					<tr>
						@if(!empty($comentario_ninhos) && $comentario_ninhos[$i])
							{{ Form::hidden('idcomentarios[]', $comentario_ninhos[$i]->idcomentarios) }}
						@else
							{{ Form::hidden('idcomentarios[]', null) }}
						@endif
						{{ Form::hidden('idasistencia_ninhos[]', $asistencia_ninhos[$i]->idasistencia_ninhos) }}
						<td style="vertical-align:middle">{{$asistencia_ninhos[$i]->nombres}} {{$asistencia_ninhos[$i]->apellido_pat}} {{$asistencia_ninhos[$i]->apellido_mat}}</td>
						<td style="vertical-align:middle">
							@if($comentario_ninhos[$i])
								{{ Form::select('calificaciones[]', ['0'=>':(','1'=>':)'],$comentario_ninhos[$i]->calificacion,array('class'=>'form-control')) }}
							@else
							{{ Form::select('calificaciones[]', ['0'=>':(','1'=>':)'],0,array('class'=>'form-control')) }}
							@endif
						</td>
						<td style="vertical-align:middle">
							@if($comentario_ninhos[$i])
								{{Form::textarea('comentarios[]', $comentario_ninhos[$i]->comentario,array('rows'=>'3','cols'=>'70','maxlength'=>'200'))}}
							@else
								{{Form::textarea('comentarios[]', null,array('rows'=>'3','cols'=>'70','maxlength'=>'200'))}}
							@endif
						</td>
					</tr>
					@endfor
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