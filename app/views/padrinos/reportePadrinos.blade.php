@extends('templates/padrinosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reporte a Padrinos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	
	{{ Form::open(array('url'=>'padrinos/submit_create_reporte_padrinos', 'role'=>'form', 'files'=>true)) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Subir Documentos</h3>
		</div>
		<div class="panel-body">
			<div class="col-xs-8">
				<p>Este documento será enviado por correo a todos los padrinos que han sido registrados en el presente año y una vez realizada, no podrá deshacerse la acción.</p>
			</div>
			<div class="col-xs-8">
				<label class="control-label">Seleccione un Documento</label>(pdf)
				<input name="archivo" id="input-1" type="file" class="file file-loading" data-allowed-file-extensions='["pdf"]'>
			</div>
		</div>
	</div>
	{{ Form::close() }}

    <script src="{{ asset('js/fileinput.min.js') }}"></script>
@stop