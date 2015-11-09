@extends('templates/padrinosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Historial de Mis Reportes</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	{{ Form::open(array('url'=>'/padrinos/search_mis_reportes','method'=>'get' ,'role'=>'form', 'id'=>'search-form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search','Título de reporte') }}
						{{ Form::text('search',$search,array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('fecha_ini','Fecha inicial') }}
						<div id="datetimepicker1" class="form-group input-group date fecha-busqueda">
							{{ Form::text('fecha_ini',$fecha_ini,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('fecha_fin','Fecha final') }}
						<div id="datetimepicker2" class="form-group input-group date fecha-busqueda">
							{{ Form::text('fecha_fin',$fecha_fin,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
					</div>
				</div>
			</div>	
			</div>
		</div>
	{{ Form::close() }}</br>
	<table class="table table-hover">
		<tr class="info">
			<th>Título del Reporte</th>
			<th>Fecha de Subida</th>
			<th>Peso</th>
			<th>Descargar</th>
		</tr>
		@foreach($reportes_padrinos as $reporte)
		<tr>
			<td>{{$reporte->titulo}}</td>
			<td>{{date('d/m/Y - H:i',strtotime($reporte->created_at))}}</td>
			<td>{{round($reporte->peso/1024)}} KB</td>
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
@stop