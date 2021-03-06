@extends('templates/colegiosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Niño</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
        </div>
    </div>

    @if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('dni') }}</strong></p>
			<p><strong>{{ $errors->first('nombres') }}</strong></p>
			<p><strong>{{ $errors->first('apellido_pat') }}</strong></p>
			<p><strong>{{ $errors->first('apellido_mat') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_nacimiento') }}</strong></p>
			<p><strong>{{ $errors->first('genero') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_apoderado') }}</strong></p>
			<p><strong>{{ $errors->first('dni_apoderado') }}</strong></p>
			<p><strong>{{ $errors->first('num_familiares') }}</strong></p>
			<p><strong>{{ $errors->first('idcolegios') }}</strong></p>
		</div>
	@endif

    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'ninhos/submit_edit_ninho', 'role'=>'form','id'=>'submitEdit')) }}
		{{ Form::hidden('idninhos', $ninho_info->idninhos) }}
			<div class="row">
				<div class="form-group col-md-6 required @if($errors->first('dni')) has-error has-feedback @endif">
					{{ Form::label('dni','Número de Documento') }}
					@if($ninho_info->deleted_at)
						{{ Form::text('dni',$ninho_info->dni,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('dni',$ninho_info->dni,array('class'=>'form-control')) }}
					@endif	
				</div>
				<div class="form-group col-md-6 required @if($errors->first('nombre_apoderado')) has-error has-feedback @endif">
					{{ Form::label('nombre_apoderado','Nombre Apoderado') }}
					@if($ninho_info->deleted_at)
						{{ Form::text('nombre_apoderado',$ninho_info->nombre_apoderado,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('nombre_apoderado',$ninho_info->nombre_apoderado,array('class'=>'form-control')) }}
					@endif	
				</div>	
			</div>
			<div class="row">
				<div class="form-group col-md-6 required @if($errors->first('nombres')) has-error has-feedback @endif">
					{{ Form::label('nombres','Nombres') }}
					@if($ninho_info->deleted_at)
						{{ Form::text('nombres',$ninho_info->nombres,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('nombres',$ninho_info->nombres,array('class'=>'form-control')) }}	
					@endif	
				</div>
				<div class="form-group col-md-6 required @if($errors->first('dni_apoderado')) has-error has-feedback @endif">
					{{ Form::label('dni_apoderado','Número de documento de apoderado') }}
					@if($ninho_info->deleted_at)
						{{ Form::text('dni_apoderado',$ninho_info->dni_apoderado,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('dni_apoderado',$ninho_info->dni_apoderado,array('class'=>'form-control')) }}
					@endif	
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 required @if($errors->first('apellido_pat')) has-error has-feedback @endif">
					{{ Form::label('apellido_pat','Apellido Paterno') }}
					@if($ninho_info->deleted_at)	
						{{ Form::text('apellido_pat',$ninho_info->apellido_pat,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('apellido_pat',$ninho_info->apellido_pat,array('class'=>'form-control')) }}
					@endif	
				</div>
				<div class="form-group col-md-6 @if($errors->first('num_familiares')) has-error has-feedback @endif">
					{{ Form::label('num_familiares','Número de Familiares') }}
					@if($ninho_info->deleted_at)	
						{{ Form::text('num_familiares',$ninho_info->num_familiares,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('num_familiares',$ninho_info->num_familiares,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 required @if($errors->first('apellido_mat')) has-error has-feedback @endif">
					{{ Form::label('apellido_mat','Apellido Materno') }}
					@if($ninho_info->deleted_at)
						{{ Form::text('apellido_mat',$ninho_info->apellido_mat,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('apellido_mat',$ninho_info->apellido_mat,array('class'=>'form-control')) }}
					@endif	
				</div>
				<div class="form-group col-md-6 @if($errors->first('observaciones')) has-error has-feedback @endif">
					{{ Form::label('observaciones','Observaciones') }}
					@if($ninho_info->deleted_at)
						{{ Form::text('observaciones',$ninho_info->observaciones,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('observaciones',$ninho_info->observaciones,array('class'=>'form-control')) }}
					@endif	
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 required">
					{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
					@if(!$ninho_info->deleted_at)
					<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
						{{ Form::text('fecha_nacimiento',date('d/m/Y',strtotime($ninho_info->fecha_nacimiento)),array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
					@else
						{{ Form::text('fecha_nacimiento',date('d/m/Y',strtotime($ninho_info->fecha_nacimiento)),array('class'=>'form-control','readonly'=>'')) }}
	                @endif
				</div>
				<div class="form-group col-md-6 required">
					{{ Form::label('idcolegios','Colegio') }}
					@if($ninho_info->deleted_at)
						{{ Form::select('idcolegios',$colegios,$ninho_info->idcolegios,['class' => 'form-control','disabled'=>'']) }}
					@else
						{{ Form::select('idcolegios',$colegios,$ninho_info->idcolegios,['class' => 'form-control']) }}
					@endif	
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-6">
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
				<div class="form-group col-md-6">
					@if(!$ninho_info->deleted_at)
						{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
					@endif	
					{{ Form::close() }}	
				</div>
				<div class="form-group col-md-6">
				@if($ninho_info->deleted_at)
					{{ Form::open(array('url'=>'ninhos/submit_enable_ninho', 'role'=>'form','id'=>'submitEnableNinho')) }}
						{{ Form::hidden('ninho_id', $ninho_info->idninhos) }}
						{{ Form::submit('Habilitar',array('id'=>'submit-enable-ninho', 'class'=>'btn btn-success')) }}
				@else
					{{ Form::open(array('url'=>'ninhos/submit_disable_ninho', 'role'=>'form','id'=>'submitDeleteNinho')) }}
						{{ Form::hidden('ninho_id', $ninho_info->idninhos) }}
						 {{ Form::submit('Inhabilitar',array('id'=>'submit-delete-ninho', 'class'=>'btn btn-danger')) }}	
				@endif
					{{ Form::close() }}
				</div>
			</div>
	
@stop