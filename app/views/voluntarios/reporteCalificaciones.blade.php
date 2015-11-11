@extends('templates/voluntariosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reporte de Calificaciones de Voluntarios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/voluntarios/search_reporte_calificaciones','method'=>'get' ,'role'=>'form', 'id'=>'search-form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Periodo, N° Documento, Nombre')) }}
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
			<th>Doc. de identidad</th>
			<th>Nombre</th>
			<th>E-mail</th>
			<th>Calificación</th>
		</tr>
		@foreach($voluntarios_data as $voluntario_data)
		<tr class="@if($voluntario_data->deleted_at) bg-danger @endif">
			<td>
				{{$voluntario_data->nombre_periodo}}
			</td>
			<td>
				{{$voluntario_data->num_documento}}</a>
			</td>
			<td>
				{{$voluntario_data->apellido_pat.' '.$voluntario_data->apellido_mat.', '.$voluntario_data->nombre_persona}}
			</td>
			<td>
				{{$voluntario_data->email}}
			</td>
			<td style="vertical-align:left">				
				<input name="calificaciones[]" type="number" value="{{$voluntario_data->prom_calificaciones}}" class="calificacion" data-min=0 data-max=5 data-step=0.1 data-size="sm" readonly="true" >										
			</td>
		</tr>
		@endforeach
	</table>
	
@stop