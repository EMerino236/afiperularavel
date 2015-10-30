@extends('templates/colegiosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Colegio</h3>
        </div>
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'colegios/submit_edit_colegio', 'role'=>'form')) }}
		{{ Form::hidden('colegio_id', $colegio_info->idcolegios) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre',$colegio_info->nombre,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre_contacto')) has-error has-feedback @endif">
					{{ Form::label('nombre_contacto','Nombre Contacto') }}
					{{ Form::text('nombre_contacto',$colegio_info->nombre_contacto,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('telefono_contacto')) has-error has-feedback @endif">
					{{ Form::label('telefono_contacto','Telefono contacto') }}
					{{ Form::text('telefono_contacto',$colegio_info->telefono_contacto,array('class'=>'form-control')) }}
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('direccion')) has-error has-feedback @endif">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',$colegio_info->direccion,array('class'=>'form-control')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('email_contacto')) has-error has-feedback @endif">
					{{ Form::label('email_contacto','Email contacto') }}
					{{ Form::text('email_contacto',$colegio_info->email_contacto,array('class'=>'form-control')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('interes')) has-error has-feedback @endif">
					{{ Form::label('interes','Interes') }}
					{{ Form::text('interes',$colegio_info->interes,array('class'=>'form-control')) }}
				</div>
			</div>
			
		</div>
	{{ Form::close() }}
	<div class="col-xs-12">
		<div class="row">
			<div class="form-group col-xs-8">
			@if($colegio_info->deleted_at)
				{{ Form::open(array('url'=>'colegios/submit_enable_colegio', 'role'=>'form')) }}
					{{ Form::hidden('colegio_id', $colegio_info->idcolegios) }}
					{{ Form::submit('Habilitar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
			@else
				{{ Form::open(array('url'=>'colegios/submit_disable_colegio', 'role'=>'form')) }}
					{{ Form::hidden('colegio_id', $colegio_info->idcolegios) }}
					 {{ Form::submit('Inhabilitar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}
				
			@endif
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop