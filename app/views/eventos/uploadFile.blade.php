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
			<div class="col-md-8">
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
				<div class="row">
					<div class="col-md-8">
						<strong>Documento:</strong> {{$documento['documento']->titulo}}
					</div>
					<div class="col-md-2 text-right">
						{{ Form::open(array('url'=>'eventos/descargar_documento', 'role'=>'form')) }}
							{{ Form::hidden('ideventos', $evento_info->ideventos) }}
							{{ Form::hidden('iddocumentos', $documento['documento']->iddocumentos_eventos) }}
							<button type="submit" class="btn btn-primary">
							  <span class="fa fa-download"></span> Descargar
							</button>
						{{ Form::close() }}
					</div>
					<div class="col-md-2 text-right">
						@if($hoy < $evento_info->fecha_evento)
						{{ Form::open(array('url'=>'eventos/submit_delete_file', 'role'=>'form','id'=>'form-eliminar-'.$documento['documento']->iddocumentos_eventos)) }}
							{{ Form::hidden('ideventos', $evento_info->ideventos) }}
							{{ Form::hidden('iddocumentos_eventos', $documento['documento']->iddocumentos_eventos) }}
							<button type="submit" data-id="{{$documento['documento']->iddocumentos_eventos}}" class="btn btn-danger eliminar">
							  <i class="fa fa-trash-o"></i> Eliminar
							</button>
						{{ Form::close() }}
						@endif
					</div>
				</div>
				<a href='#' id="label{{$documento['documento']->iddocumentos_eventos}}" data-id="{{$documento['documento']->iddocumentos_eventos}}" class="label_visualizaciones">Ver visualizaciones</a>
				<br></br>
				<table class="table" id="table{{$documento['documento']->iddocumentos_eventos}}" hidden>
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
    <script src="{{ asset('js/eventos/uploadFile.js') }}"></script>
@stop