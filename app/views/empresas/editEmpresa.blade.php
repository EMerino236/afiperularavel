@extends('templates/empresasTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información de la Empresa</h3>
        </div>
    </div>

    @if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre_representante') }}</strong></p>
			<p><strong>{{ $errors->first('email') }}</strong></p>
			<p><strong>{{ $errors->first('sector') }}</strong></p>
			<p><strong>{{ $errors->first('telefono') }}</strong></p>
			<p><strong>{{ $errors->first('intereses') }}</strong></p>
			@if($errors->first('latitud'))
				<p><strong>Mueva el punto en el mapa a una ubicación diferente</strong></p>
			@endif
		</div>
	@endif

    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'empresas/submit_edit_empresa', 'role'=>'form', 'id'=>'submitEdit')) }}
		{{ Form::hidden('idempresas', $empresa_info->idempresas) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información Básica</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('razon_social')) has-error has-feedback @endif">
						{{ Form::label('razon_social','Razón Social') }}
						{{ Form::text('razon_social',$empresa_info->razon_social,array('class'=>'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-6 required @if($errors->first('nombre_representante')) has-error has-feedback @endif">
						{{ Form::label('nombre_representante','Nombre del Representante') }}
						@if($empresa_info->deleted_at)
							{{ Form::text('nombre_representante',$empresa_info->nombre_representante,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('nombre_representante',$empresa_info->nombre_representante,array('class'=>'form-control')) }}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('email')) has-error has-feedback @endif">
						{{ Form::label('email','Email de contacto') }}
						@if($empresa_info->deleted_at)
							{{ Form::text('email',$empresa_info->email,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('email',$empresa_info->email,array('class'=>'form-control')) }}
						@endif	
					</div>
					<div class="form-group col-md-6 required @if($errors->first('telefono')) has-error has-feedback @endif">
						{{ Form::label('telefono','Teléfono de Contacto') }}
						@if($empresa_info->deleted_at)
							{{ Form::text('telefono',$empresa_info->telefono,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('telefono',$empresa_info->telefono,array('class'=>'form-control','maxlength'=>'9')) }}
						@endif	
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('sector')) has-error has-feedback @endif">
						{{ Form::label('sector','Sector Empresarial') }}
						@if($empresa_info->deleted_at)
							{{ Form::text('sector',$empresa_info->sector,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('sector',$empresa_info->sector,array('class'=>'form-control')) }}
						@endif	
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('intereses')) has-error has-feedback @endif">
						{{ Form::label('intereses','Intereses') }}
						@if($empresa_info->deleted_at)
							{{ Form::textarea('intereses',$empresa_info->intereses,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::textarea('intereses',$empresa_info->intereses,array('class'=>'form-control','rows'=>'4','cols'=>'60','maxlength'=>'200', 'style'=>'resize:none')) }}
						@endif	
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			@if(!$empresa_info->deleted_at)
				<div class="form-group col-md-1">
					{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
				</div>
			@endif
		{{ Form::close() }}
			<div class="form-group col-md-1">
			@if($empresa_info->deleted_at)
				{{ Form::open(array('url'=>'empresas/submit_enable_empresa', 'role'=>'form','id'=>'submitEnable')) }}
					{{ Form::hidden('empresa_id', $empresa_info->idempresas) }}
					{{ Form::submit('Habilitar',array('id'=>'submit-enable', 'class'=>'btn btn-success')) }}
			@else
				{{ Form::open(array('url'=>'empresas/submit_disable_empresa', 'role'=>'form','id'=>'submitDelete')) }}
					{{ Form::hidden('empresa_id', $empresa_info->idempresas) }}
					{{ Form::submit('Inhabilitar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}	
			@endif
				{{ Form::close() }}
			</div>
		</div>	
	
@stop