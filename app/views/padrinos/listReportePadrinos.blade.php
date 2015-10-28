@extends('templates/padrinosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Historial de Reportes a Padrinos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
				<table class="table table-hover">
					<tr class="info">
						<th>Título del Reporte</th>
						<th>Fecha de Envío</th>
						<th>Descargar</th>
					</tr>
					@foreach($reportes_padrinos as $reporte)
					<tr>
						<td>{{$reporte->titulo}}</td>
						<td>{{$reporte->created_at}}</td>
						<td>
						{{ Form::open(array('url'=>'padrinos/descargar_reporte_padrino', 'role'=>'form')) }}
							{{ Form::hidden('iddocumentos', $reporte->iddocumentos) }}
							<button type="submit" class="btn btn-primary">
							  <span class="fa fa-download"></span> Descargar
							</button>
						</td>
						{{ Form::close() }}
					</tr>
					@endforeach
				</table>
				{{ $reportes_padrinos->links() }}
<script src="{{ asset('js/eventos/ver-evento.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
@stop