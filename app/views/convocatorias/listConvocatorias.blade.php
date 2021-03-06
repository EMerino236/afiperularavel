@extends('templates/convocatoriasTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Periodos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/convocatorias/search_convocatorias','method'=>'get' ,'role'=>'form', 'id'=>'search-form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Nombre de Periodo')) }}
					</div>
					<div class="col-md-4">
						{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
					</div>
				</div>	
			</div>
		</div>
	{{ Form::close() }}</br>

	<table class="table">
		<tr class="info">
			<th>Nombre</th>
			<th>Fecha Inicio</th>
			<th>Fecha Fin</th>
			<th>Postulantes</th>
			<th>Voluntarios</th>
		</tr>
		@foreach($convocatorias_data as $convocatoria_data)
		<tr class="@if($convocatoria_data->deleted_at) bg-danger @endif">
			<td>
				<a href="{{URL::to('/convocatorias/edit_convocatoria/')}}/{{$convocatoria_data->idperiodos}}">{{$convocatoria_data->nombre}}</a>
			</td>
			<td>
				{{$convocatoria_data->fecha_inicio}}
			</td>
			<td>
				{{$convocatoria_data->fecha_fin}}
			</td>
			<td>
				@if($convocatoria_data->deleted_at)
					Ver Postulantes
				@else
					<a href="{{URL::to('/convocatorias/list_postulantes/')}}/{{$convocatoria_data->idperiodos}}">Ver Postulantes</a>
				@endif
			</td>
			<td>
				@if($convocatoria_data->deleted_at)
					Ver Voluntarios
				@else
					<a href="{{URL::to('/convocatorias/list_voluntarios_convocatoria/')}}/{{$convocatoria_data->idperiodos}}">Ver Voluntarios</a>
				@endif
			</td>
		</tr>
		@endforeach
	</table>
	@if($search)
		{{ $convocatorias_data->appends(array('search' => $search))->links() }}
	@else
		{{ $convocatorias_data->links() }}
	@endif
@stop