@extends('templates/convocatoriasTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información de la Convocatoria</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    @if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_inicio') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_fin') }}</strong></p>
		</div>
	@endif
    
	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'convocatorias/submit_edit_convocatoria', 'role'=>'form')) }}
		{{ Form::hidden('convocatoria_id', $convocatoria_info->idperiodos) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre de Periodo') }}
					{{ Form::text('nombre',$convocatoria_info->nombre,['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				{{ Form::label('fecha_inicio','Fecha de inicio del Periodo') }}
				<div id="datetimepicker1" class="form-group input-group date col-xs-8 @if($errors->first('fecha_inicio')) has-error has-feedback @endif">
					{{ Form::text('fecha_inicio',date('d-m-Y',strtotime($convocatoria_info->fecha_inicio)),array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
			<div class="row">
				{{ Form::label('fecha_fin','Fecha de fin del Periodo') }}
				<div id="datetimepicker2" class="form-group input-group date col-xs-8 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
					{{ Form::text('fecha_fin',date('d-m-Y',strtotime($convocatoria_info->fecha_fin)),array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
				</div>
			</div>		
		</div>		
		</div>
	{{ Form::close() }}
@stop