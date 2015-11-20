@extends('templates/concursosTemplate')	
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Detalle del Proyecto: {{$proyecto_info->nombre}}</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Registrar Detalle</h3>
		</div>
		<div class="panel-body">
	    {{ Form::hidden('idproyectos',$proyecto_info->idproyectos) }}
		{{ Form::hidden('aprobacion',$proyecto_info->aprobacion) }}
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('titulo')) has-error has-feedback @endif">
						{{ Form::label('titulo','Título') }}
						{{ Form::text('titulo',Input::old('titulo'),array('class'=>'form-control','maxlength'=>100)) }}
					</div>
					<div class="form-group col-md-6 required @if($errors->first('presupuesto')) has-error has-feedback @endif">
						{{ Form::label('presupuesto','Presupuesto (S/.)') }}
						{{ Form::text('presupuesto',Input::old('presupuesto'),array('class'=>'form-control')) }}
					</div>
				
				</div>
				<div class="row">
					<div class="form-group col-md-6 @if($errors->first('gastoreal')) has-error has-feedback @endif">
						{{ Form::label('gastoreal','Gasto Real (S/.)') }}
						{{ Form::text('gastoreal',Input::old('gastoreal'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-12">
						{{ HTML::link('','Registrar Detalle',array('id'=>'submit-detalle-proyecto', 'class'=>'btn btn-primary')) }}	
					</div>
				</div>
		
		</div>
	</div>
	{{ Form::close() }}  

	<table class="table"  style ="width:100%;word-wrap:break-word;table-layout: fixed;">
		<tr class="info">
			<th>Titulo</th>
			<th>Presupuesto (S/.)</th>
			<th>Gasto Real (S/.)</th>
			<th>Eliminar</th>
		</tr>
		@foreach($detalles_proyecto as $detalle_proyecto)
		<tr class="@if($detalle_proyecto->deleted_at) bg-danger @endif">
			{{ Form::hidden('tituloh',$detalle_proyecto->titulo) }}
			{{ Form::hidden('presupuestoh',$detalle_proyecto->presupuesto) }}
			{{ Form::hidden('gastorealh',$detalle_proyecto->gasto_real) }}
			{{ Form::hidden('iddetalle',$detalle_proyecto->iddetalle_proyectos) }}				
			<td>
				{{ HTML::link('',$detalle_proyecto->titulo,array('class'=>'submit-edit-detalle','data-detalle'=>$detalle_proyecto->iddetalle_proyectos,'data-titulo'=>$detalle_proyecto->titulo,'data-presupuesto'=>$detalle_proyecto->presupuesto,'data-gastoreal'=>$detalle_proyecto->gasto_real,'data-aprobacion'=>$proyecto_info->aprobacion)) }}
			</td>
			<td>
				{{$detalle_proyecto->presupuesto}}
			</td>
			<td>
				{{$detalle_proyecto->gasto_real}}
			</td>			
			<td>
				{{ HTML::link('',' Eliminar',array('class'=>'btn btn-danger delete-detalle-proyecto fa fa-trash-o','data-detalle'=>$detalle_proyecto->iddetalle_proyectos)) }}
			</td>
		</tr>
		@endforeach
	</table>

<div class="modal fade" id="edit-detalle-form" tabindex="-1" role="dialog" aria-labelledby="edit-detalle-form" aria-hidden="true" data-backdrop="true">
		<div class="modal-dialog">
			<div class="modal-content">
		    	<div class="modal-header">
		    		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="edit-detalle-form-title">Editar Detalle</h3>
				</div>
				<div class="modal-body">					
					<table style="width:100%;">
						{{ Form::hidden('iddetalle','') }}
						<tr>
							<td style="width:100%;">
								<div class="form-group col-md-12">
									<span><strong>Titulo</strong></span>
									{{ Form::text('titulo_detalle','',array('class'=>'form-control')) }}
								</div>								
							</td>
						</tr>	
						<tr>
							<td >
								<div class="form-group col-md-6">
									<span><strong>Presupuesto (S/.)</strong></span>
									{{ Form::text('presupuesto_detalle','',array('class'=>'form-control')) }}
								</div>
								<div class="form-group col-md-6">
									<span><strong>Gasto Real (S/.)</strong></span>
									{{ Form::text('gasto_real_detalle','',array('class'=>'form-control','readonly'=>'')) }}
								</div>
							</td>												
							<td >
								
							</td>							
						</tr>
					</table>
					{{ HTML::link('','Guardar',array('id'=>'submit-edit-detalle-form', 'class'=>'btn btn-success','style'=>'margin: 15px 0 0 15px;')) }}					
				</div>
			</div>
		</div>
	</div>

	@if($detalles_proyecto)
		{{ $detalles_proyecto->links() }}
	@endif


@stop