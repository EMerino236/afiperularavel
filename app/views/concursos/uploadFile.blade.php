@extends('templates/concursosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Administrar Documentos del Concurso</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	{{ Form::open(array('url'=>'concursos/submit_upload_file', 'role'=>'form', 'files'=>true)) }}
	{{ Form::hidden('idconcursos', $concurso_info->idconcursos) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Subir Documentos</h3>
		</div>
		<div class="panel-body">
			<div class="col-xs-8">
				<label class="control-label">Seleccione un Documento</label>
				<input name="archivo" id="input-1" type="file" class="file file-loading" data-allowed-file-extensions='["pdf","doc","docx","xls","xlsx","ppt","pptx"]'>
			</div>
		</div>
	</div>
	{{ Form::close() }}
	<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Documentos del Concurso</h3>
			</div>
			<div class="panel-body">
				<div class="col-xs-12">
					@foreach($documentos as $documento)
						@if(!$documento->deleted_at)
						{{ Form::open(array('url'=>'concursos/descargar_documento', 'role'=>'form')) }}
							{{ Form::hidden('idconcursos', $concurso_info->idconcursos) }}
							{{ Form::hidden('iddocumentos', $documento->iddocumentos) }}
							<div class="row">
								<div class="form-group col-xs-8">
									<button type="submit" class="btn btn-primary">
									  <span class="fa fa-download"></span> {{$documento->titulo}}
									</button>
								</div>
							</div>
						@endif
					@endforeach
				</div>
			</div>
		</div>

    <script src="{{ asset('js/fileinput.min.js') }}"></script>
@stop