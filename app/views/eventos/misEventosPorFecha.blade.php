@extends('templates/eventosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Mis Eventos</h3>
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
			<th>Evento</th>
			<th>Fecha</th>
			<th>Dirección</th>
			<th>Registrar Comentario</th>
		</tr>
		@foreach($eventos_data as $evento_data)
		<tr>
			<td>
				<a href="{{URL::to('/eventos/ver_evento/')}}/{{$evento_data->ideventos}}">{{$evento_data->nombre}}</a>
			</td>
			<td>
				{{date('d/m/Y - H:i',strtotime($evento_data->fecha_evento))}}
			</td>
			<td>
				{{$evento_data->direccion}}
			</td>
			<td>
				<a href="{{URL::to('/eventos/registrar_comentario/')}}/{{$evento_data->ideventos}}">@if($hoy > date('Y-m-d', strtotime($evento_data->fecha_evento)) && $hoy < date('Y-m-d', strtotime($evento_data->fecha_evento. ' + 2 days'))) Comentar @else Ver Comentarios @endif</a>	
			</td>
		</tr>
		@endforeach
	</table>
@stop