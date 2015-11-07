@extends('templates/eventosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Administrar Documentos del Evento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	@if($hoy < $evento_info->fecha_evento)
	{{ Form::open(array('url'=>'eventos/submit_upload_file', 'role'=>'form', 'files'=>true)) }}
	{{ Form::hidden('ideventos', $evento_info->ideventos) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Subir Documentos</h3>
		</div>
		<div class="panel-body">
			<div class="col-xs-8">
				<label class="control-label">Seleccione un Documento</label>(pdf,doc,docx,xls,xlsx,ppt,pptx)
				<input name="archivo" id="input-1" type="file" class="file file-loading" data-allowed-file-extensions='["pdf","doc","docx","xls","xlsx","ppt","pptx"]'>
			</div>
		</div>
	</div>
	{{ Form::close() }}
	@endif
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Visualizaciones</h3>
		</div>
		<div class="panel-body">
			@foreach($documentos as $documento)
				<div class="col-xs-12">
					<div class="row">
						@if($hoy < $evento_info->fecha_evento)
						{{ Form::open(array('url'=>'eventos/submit_delete_file', 'role'=>'form')) }}
							{{ Form::hidden('ideventos', $evento_info->ideventos) }}
							{{ Form::hidden('iddocumentos_eventos', $documento['documento']->iddocumentos_eventos) }}
							{{ Form::submit('X',array('class'=>'btn btn-danger','title'=>'Eliminar Documento')) }}
							<strong>Documento:</strong> {{$documento['documento']->titulo}}
						{{ Form::close() }}
						@else
							<strong>Documento:</strong> {{$documento['documento']->titulo}}
						@endif
					</div>
				</div>
				<table class="table">
					<tr class="info">
						<th>Nombres</th>
						<th>Apellidos</th>
						<th>E-mail</th>
						<th>Teléfono</th>
						<th>Celular</th>
						<th>Fecha de Visualización</th>
					</tr>
					@foreach($documento['visualizaciones'] as $visualizacion)
					<tr>
						<td>
							{{$visualizacion->nombres}}
						</td>
						<td>
							{{$visualizacion->apellido_pat}} {{$visualizacion->apellido_mat}}
						</td>
						<td>
							{{$visualizacion->email}}
						</td>
						<td>
							{{$visualizacion->telefono}}
						</td>
						<td>
							{{$visualizacion->celular}}
						</td>
						<td>
							{{date('d/m/Y - H:i',strtotime($visualizacion->created_at))}}
						</td>
					</tr>
					@endforeach
				</table>
			@endforeach
		</div>
	</div>

    <script src="{{ asset('js/fileinput.min.js') }}"></script>
@stop