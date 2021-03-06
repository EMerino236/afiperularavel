@extends('templates/voluntariosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Voluntarios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/voluntarios/search_voluntarios','method'=>'get' ,'role'=>'form', 'id'=>'search-form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Periodo, Doc. de Identidad, Nombre')) }}
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
			<th>Periodo</th>
			<th>Doc. de Identidad</th>
			<th>Nombre</th>
			<th>E-mail</th>
			<th>Celular</th>
			<th>Dirección</th>
		</tr>
		@foreach($voluntarios_data as $voluntario_data)
		<tr class="@if($voluntario_data->deleted_at) bg-danger @endif">
			<td>
				{{$voluntario_data->nombre_periodo}}
			</td>
			<td>
				<a href="{{URL::to('/voluntarios/view_voluntario/')}}/{{$voluntario_data->id}}">{{$voluntario_data->num_documento}}</a>
			</td>
			<td>
				{{$voluntario_data->apellido_pat.' '.$voluntario_data->apellido_mat.', '.$voluntario_data->nombre_persona}}
			</td>
			<td>
				{{$voluntario_data->email}}
			</td>
			<td>
				{{$voluntario_data->celular}}
			</td>
			<td>
				{{$voluntario_data->direccion}}
			</td>
		</tr>
		@endforeach
	</table>
@stop