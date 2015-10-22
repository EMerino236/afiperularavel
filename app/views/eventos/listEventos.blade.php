@extends('templates/eventosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Eventos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

    {{ Form::open(array('url'=>'/eventos/search_evento','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Seleccione un período</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				{{ Form::select('search',$periodos,Input::old('search'),['class' => 'form-control']) }}
				{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
			</div>	
			</div>
		</div>
	{{ Form::close() }}</br>
	
	@if($no_hay_periodo)
		<div class="alert alert-danger">No se encontró un período actual activo.</div>
	@endif

	<table class="table">
		<tr class="info">
			<th>Evento</th>
			<th>Fecha</th>
			<th>Dirección</th>
			<th>Tipo</th>
			<th>Asistencia</th>
			<th>Documentos</th>
		</tr>
		@foreach($eventos_data as $evento_data)
		<tr>
			<td>
				<a href="{{URL::to('/eventos/edit_evento/')}}/{{$evento_data->ideventos}}">{{$evento_data->nombre}}</a>
			</td>
			<td>
				{{date('d/m/Y - H:i',strtotime($evento_data->fecha_evento))}}
			</td>
			<td>
				{{$evento_data->direccion}}
			</td>
			<td>
				{{$evento_data->tipo_evento}}
			</td>
			<td>
				@if($hoy < date('Y-m-d', strtotime($evento_data->fecha_evento. ' + 2 days')))
					Tomar Asistencia 
				@else 
					Ver Asistencia 
				@endif
			</td>
			<td>
				<a href="{{URL::to('/eventos/upload_file/')}}/{{$evento_data->ideventos}}">@if($hoy < $evento_data->fecha_evento)Subir Documentos @else Visualizaciones @endif</a>
			</td>
		</tr>
		@endforeach
	</table>
	@if($search)
		{{ $eventos_data->appends(array('search' => $search))->links() }}
	@elseif(!$no_hay_periodo)
		{{ $eventos_data->links() }}
	@endif
@stop
