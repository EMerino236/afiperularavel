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
		<div class="row">
			<div class="form-group col-md-4">
				<div class="form-group @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre de Periodo') }}
					{{ Form::text('nombre',$convocatoria_info->nombre,['class' => 'form-control']) }}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-4">
				{{ Form::label('fecha_inicio','Fecha de inicio del Periodo') }}
				<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_inicio')) has-error has-feedback @endif">
					{{ Form::text('fecha_inicio',date('d-m-Y',strtotime($convocatoria_info->fecha_inicio)),array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-4">
				{{ Form::label('fecha_fin','Fecha de fin del Periodo') }}
				<div id="datetimepicker2" class="form-group input-group date @if($errors->first('fecha_fin')) has-error has-feedback @endif">
					{{ Form::text('fecha_fin',date('d-m-Y',strtotime($convocatoria_info->fecha_fin)),array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-1">
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
			</div>
	{{ Form::close() }}
			<div class="form-group col-md-1">
			@if($convocatoria_info->deleted_at)
				{{ Form::open(array('url'=>'convocatorias/submit_enable_convocatoria', 'role'=>'form')) }}
					{{ Form::hidden('idperiodo', $convocatoria_info->idperiodos) }}
					{{ Form::submit('Habilitar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
			@else
				{{ Form::open(array('url'=>'convocatorias/submit_disable_convocatoria', 'role'=>'form')) }}
					{{ Form::hidden('idperiodo', $convocatoria_info->idperiodos) }}
					 {{ Form::submit('Inhabilitar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}	
			@endif
				{{ Form::close() }}
			</div>
		</div>
@stop