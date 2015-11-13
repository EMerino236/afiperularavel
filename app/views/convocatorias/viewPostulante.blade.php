@extends('templates/convocatoriasTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Ficha del Postulante</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>   
	{{ Form::open(array('method'=>'get','role'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos Personales del Postulante</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<div class="row">
						<div class="form-group col-md-4">
							<div class="form-group">
								{{ Form::label('nombre','Nombres') }}
								{{ Form::text('nombre',$postulante_info->nombres,['class' => 'form-control','readonly'=>'']) }}
							</div>
						</div>
						<div class="form-group col-md-4">
							<div class="form-group">
								{{ Form::label('apellidos','Apellidos') }}
								{{ Form::text('apellidos',$postulante_info->apellido_pat.' '.$postulante_info->apellido_mat,['class' => 'form-control','readonly'=>'']) }}
							</div>
						</div>
						<div class="form-group col-md-4">
							<div class="form-group">
								{{ Form::label('num_documento','Número de Documento') }}
								{{ Form::text('num_documento',$postulante_info->num_documento,['class' => 'form-control','readonly'=>'']) }}
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
						<div class="form-group col-md-4">
							<div class="form-group">
								{{ Form::label('email','Correo Electrónico') }}
								{{ Form::text('email',$postulante_info->email,['class' => 'form-control','readonly'=>'']) }}
							</div>
						</div>
						<div class="form-group col-md-4">
							<div class="form-group">
								{{ Form::label('direccion','Dirección Actual') }}
								{{ Form::text('direccion',$postulante_info->direccion,['class' => 'form-control','readonly'=>'']) }}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4">
							<div class="form-group">
								{{ Form::label('telefono','Teléfono de Contacto') }}
								{{ Form::text('telefono','Cel: '.$postulante_info->celular.' / Tlf: '.$postulante_info->telefono,['class' => 'form-control','readonly'=>'']) }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos Complementarios del Postulante</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<div class="row">
						<div class="form-group col-md-4">
							<div class="form-group">
								{{ Form::label('centro_estudio_trabajo','Centro de Estudios o Laboral') }}
								{{ Form::text('centro_estudio_trabajo',$postulante_info->centro_estudio_trabajo,['class' => 'form-control','readonly'=>'']) }}
							</div>
						</div>
						<div class="form-group col-md-4">
							<div class="form-group">
								{{ Form::label('ciclo_estudio_grado_titulo','Ciclo de estudios/Grados o títulos') }}
								{{ Form::text('ciclo_estudio_grado_titulo',$postulante_info->ciclo_grado,['class' => 'form-control','readonly'=>'']) }}
							</div>
						</div>
						<div class="form-group col-md-4">
							<div class="form-group">
								{{ Form::label('carrera','Carrera') }}
								{{ Form::text('carrera',$postulante_info->carrera,['class' => 'form-control','readonly'=>'']) }}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4">
							<div class="form-group">
								{{ Form::label('experiencia','Experiencia Laboral o Voluntariado') }}
								@if($postulante_info->experiencia===0)
									{{ Form::text('experiencia','No',['class' => 'form-control','readonly'=>'']) }}
								@endif
								@if($postulante_info->experiencia===1)
									{{ Form::text('experiencia','Si',['class' => 'form-control','readonly'=>'']) }}
								@endif
								@if($postulante_info->experiencia===null)
									{{ Form::text('experiencia','',['class' => 'form-control','readonly'=>'']) }}
								@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<div class="form-group">
								{{ Form::label('aprendizaje','Mayor Aprendizaje') }}
								{{ Form::textarea('aprendizaje',$postulante_info->aprendizaje,['class' => 'form-control','readonly'=>'']) }}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<div class="form-group">
								{{ Form::label('motivacion','Motivacion') }}
								{{ Form::textarea('motivacion',$postulante_info->motivacion,['class' => 'form-control','readonly'=>'']) }}
							</div>
						</div>
					</div>	
					<div class="row">
						<div class="form-group col-md-12">
							<div class="form-group">
								{{ Form::label('aportacion','Aportacion al Voluntariado') }}
								{{ Form::textarea('aportacion',$postulante_info->aporte,['class' => 'form-control','readonly'=>'']) }}
							</div>
						</div>
					</div>	
					<div class="row">
						<div class="form-group col-md-12">
							<div class="form-group">
								{{ Form::label('expectativas','Expectativas del Voluntariado') }}
								{{ Form::textarea('expectativas',$postulante_info->expectativas,['class' => 'form-control','readonly'=>'']) }}
							</div>
						</div>
					</div>				
					<div class="row">
						<div class="form-group col-xs-4">
							<a class="btn btn-primary btn-block" onclick="goBack()">Regresar</a>
						</div>
					</div>	
				</div>
			</div>
		</div>
	{{ Form::close() }}
@stop