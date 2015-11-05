@extends('templates/convocatoriasTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Ficha del Postulante</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>   
************Corregir la ruta el regresar
	{{ Form::open(array('url'=>'convocatorias/list_postulantes/'.$idfase, 'method'=>'get','role'=>'form')) }}
		<div class="col-md-12">
			<div class="row">
				<div class="form-group col-md-4">
					<div class="form-group">
						{{ Form::label('nombre','Nombres') }}
						{{ Form::text('nombre',$postulante_info->nombres,['class' => 'form-control','readonly'=>'']) }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					<div class="form-group">
						{{ Form::label('apellidos','Apellidos') }}
						{{ Form::text('apellidos',$postulante_info->apellido_pat.' '.$postulante_info->apellido_mat,['class' => 'form-control','readonly'=>'']) }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					<div class="form-group">
						{{ Form::label('fecha_nacimiento','Fecha de Nacimiento') }}
						{{ Form::text('fecha_nacimiento',date('d-m-Y',strtotime($postulante_info->fecha_nacimiento)),['class' => 'form-control','readonly'=>'']) }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					<div class="form-group">
						{{ Form::label('num_documento','Número de Documento') }}
						{{ Form::text('num_documento',$postulante_info->num_documento,['class' => 'form-control','readonly'=>'']) }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Regresar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
				</div>
			</div>	
		</div>
	{{ Form::close() }}
@stop