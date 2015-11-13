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
					<div class="form-group col-md-5">
						{{ Form::label('search_periodo','Periodo') }}
						{{ Form::select('search_periodo',array("0"=>"Todos")+$periodos,$search_periodo,['class' => 'form-control']) }}
					</div>
					<div class="col-md-5">
						{{ Form::label('search_usuario','Voluntario') }}
						{{ Form::text('search_usuario',$search_usuario,array('class'=>'form-control','placeholder'=>'N° Documento, Nombre')) }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-1">
						{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
					</div>
					<div class="col-md-1">
						<a href="" id="submit_asistencia_excel_button" class="btn btn-success"><span class="glyphicon glyphicon-download-alt"></span> Exportar a Excel</a>
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}</br>
	{{ Form::open(array('url'=>'voluntarios/submit_asistencia_excel', 'id' => 'submit_asistencia_excel' ,'role'=>'form')) }}
		{{ Form::hidden('search_periodo_excel',$search_periodo) }}
		{{ Form::hidden('search_usuario_excel',$search_usuario) }}
	{{ Form::close() }}
	<table class="table">
		<tr class="info">
			<th>Periodo</th>
			<th>Doc. de identidad</th>
			<th>Nombre</th>
			<th>Eventos Programados</th>
			<th>Eventos que asistió</th>
			<th>% Asistencia</th>
			<th>Promedio Calificación</th>
		</tr>		
		@foreach($voluntarios_data as $voluntario_data)
		<?php  
				   $eventos_total =0;
				   $eventos_asistidos=0;
		?>
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
				@foreach($eventos_asistencia as $asistencia)
					@if($asistencia->idusers == $voluntario_data->id)
						-{{$asistencia->nombre}}<br>
						<?php 
							$eventos_total++;
						?>
					@endif
				@endforeach
			</td>
			<td>
				@foreach($eventos_asistencia as $asistencia)
					@if($asistencia->idusers == $voluntario_data->id)
						@if($asistencia->asistio ==1)
							-{{$asistencia->nombre}}<br>
							<?php $eventos_asistidos++;?>
						@endif
					@endif
				@endforeach
			</td>
			<td>
				{{round(($eventos_asistidos/$eventos_total)*100,2)}}%
			</td>
			<td style="vertical-align:left">				
				<input name="calificaciones[]" type="number" value="{{$voluntario_data->prom_calificaciones}}" class="calificacion" data-min=0 data-max=5 data-step=0.1 data-size="xs" readonly="true" >										
			</td>
		</tr>
		@endforeach
	</table>
	
@stop