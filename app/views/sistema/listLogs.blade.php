@extends('templates/sistemaTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reporte de Logs de Auditoría</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/sistema/search_logs','method'=>'get' ,'role'=>'form', 'id'=>'search-form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="row">
					<div class="form-group col-md-6">
						{{ Form::label('search','Búsqueda') }}
						{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'No. Documento, Nombre, E-mail, Acción Realizada')) }}
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('search_tipo_log','Tipo de Log') }}
						{{ Form::select('search_tipo_log',array("0"=>"Seleccione")+$tipo_logs,$search_tipo_log,['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						{{ Form::label('fecha_ini','Fecha inicial') }}
						<div id="datetimepicker1" class="form-group input-group date">
							{{ Form::text('fecha_ini',$fecha_ini,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('fecha_fin','Fecha final') }}
						<div id="datetimepicker2" class="form-group input-group date">
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
	
	<table class="table">
		<tr class="info">
			<th>No. Documento</th>
			<th>Nombre</th>
			<th>E-mail</th>
			<th>Tipo de Log</th>
			<th>Acción Realizada</th>
			<th>Fecha y Hora</th>
		</tr>
		@foreach($logs as $log)
		<tr>
			<td>
				{{$log->num_documento}}
			</td>
			<td>
				{{$log->nombres}} {{$log->apellido_pat}} {{$log->apellido_mat}}
			</td>
			<td>
				{{$log->email}}
			</td>
			<td>
				{{$log->tipo_log}}
			</td>
			<td>
				{{$log->descripcion}}
			</td>
			<td>
				{{date('d-m-Y H:i:s',strtotime($log->created_at))}}
			</td>
		</tr>
		@endforeach
	</table>
	@if($search || $search_tipo_log || $fecha_ini || $fecha_fin)
		{{ $logs->appends(array('search' => $search,'search_tipo_log' => $search_tipo_log,'fecha_ini' => $fecha_ini,'fecha_fin' => $fecha_fin))->links() }}
	@else
		{{ $logs->links() }}
	@endif
<script src="{{ asset('js/sistema/logs.js') }}"></script>
@stop