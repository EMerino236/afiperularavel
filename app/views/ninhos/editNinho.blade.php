@extends('templates/colegiosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Niño</h3>
        </div>
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'ninhos/submit_edit_ninho', 'role'=>'form')) }}
		{{ Form::hidden('idninhos', $ninho_info->idninhos) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('dni')) has-error has-feedback @endif">
					{{ Form::label('dni','Número de Documento') }}
					{{ Form::text('dni',$ninho_info->dni,array('class'=>'form-control')) }}
				</div>	
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombres')) has-error has-feedback @endif">
					{{ Form::label('nombres','Nombres') }}
					{{ Form::text('nombres',$ninho_info->nombres,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellido_pat')) has-error has-feedback @endif">
					{{ Form::label('apellido_pat','Apellido Paterno') }}
					{{ Form::text('apellido_pat',$ninho_info->apellido_pat,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellido_mat')) has-error has-feedback @endif">
					{{ Form::label('apellido_mat','Apellido Materno') }}
					{{ Form::text('apellido_mat',$ninho_info->apellido_mat,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('fecha_nacimiento','Fecha de Nacimiento') }}
						{{ Form::text('fecha_nacimiento',date('d-m-Y',strtotime($ninho_info->fecha_nacimiento)),array('class'=>'form-control')) }}
					</div>
				</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('genero','Género') }}</br>
					@if($ninho_info->genero == 'M')
						{{ Form::radio('genero', 'M',true) }} M
					@else
						{{ Form::radio('genero', 'M') }} M
					@endif

					@if($ninho_info->genero == 'F')
						{{ Form::radio('genero', 'F',true,array('style'=>'margin-left:40px')) }} F
					@else
						{{ Form::radio('genero', 'F',false,array('style'=>'margin-left:40px')) }} F
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre_apoderado')) has-error has-feedback @endif">
					{{ Form::label('nombre_apoderado','Nombre Apoderado') }}
					{{ Form::text('nombre_apoderado',$ninho_info->nombre_apoderado,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('dni_apoderado')) has-error has-feedback @endif">
					{{ Form::label('dni_apoderado','DNI Apoderado') }}
					{{ Form::text('dni_apoderado',$ninho_info->dni_apoderado,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('num_familiares')) has-error has-feedback @endif">
					{{ Form::label('num_familiares','Número de Familiares') }}
					{{ Form::text('num_familiares',$ninho_info->num_familiares,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('observaciones')) has-error has-feedback @endif">
					{{ Form::label('observaciones','Observaciones') }}
					{{ Form::text('observaciones',$ninho_info->observaciones,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('colegio','Colegio') }}
					{{ Form::select('colegio',$colegios,$ninho_info->idcolegios,['class' => 'form-control']) }}
				</div>
			</div>
		</div>	
	
@stop