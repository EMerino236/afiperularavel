@extends('templates/padrinoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Padrino</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'padrinos/submit_edit_padrino', 'role'=>'form')) }}
		{{ Form::hidden('user_id', $user_info->id) }}
		{{ Form::hidden('latitud', $user_info->latitud) }}
		{{ Form::hidden('longitud', $user_info->longitud) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('idtipo_identificacion','Tipo de identificación') }}
					{{ Form::text('idtipo_identificacion',$user_info->nombre_tipo_identificacion,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('num_documento','Número de Documento') }}
					{{ Form::text('num_documento',$user_info->num_documento,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('nombres','Nombres') }}
					{{ Form::text('nombres',$user_info->nombres,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('apellido_pat','Apellido Paterno') }}
					{{ Form::text('apellido_pat',$user_info->apellido_pat,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('apellido_mat','Apellido Materno') }}
					{{ Form::text('apellido_mat',$user_info->apellido_mat,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
					{{ Form::text('fecha_nacimiento',date('d-m-Y',strtotime($user_info->fecha_nacimiento)),array('class'=>'form-control')) }}
				</div>
			</div>	
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',$user_info->direccion,array('class'=>'form-control')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('telefono','Teléfono') }}
					{{ Form::text('telefono',$user_info->telefono,array('class'=>'form-control')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('celular','Celular') }}
					{{ Form::text('celular',$user_info->celular,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('email','E-mail') }}
					{{ Form::text('email',$user_info->email,array('class'=>'form-control')) }}
				</div>
			</div>			
		</div>
	{{ Form::close() }}
	
@stop