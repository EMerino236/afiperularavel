@extends('templates/dashboardTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Bienvenido al sistema de AFI Perú</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'voluntarios/submit_repostulacion', 'role'=>'form')) }}
		@if($user_perfil && $periodo_actual && !$usuario_ya_inscrito)
			{{ Form::hidden('user_id', $user->id) }}
			{{ Form::hidden('idperiodos', $periodo_actual->idperiodos) }}
			<p><font color="red" size="5">¡Aviso Importante!</font></p>
		<div id="repostulacion">
				<div class="row">
					<div class="form-group col-md-3">
						{{ Form::label('Está disponible una nueva convocatoria para el periodo '.$periodo_actual->nombre.'. ¿Deseas postular?') }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-3">
						{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Postular',array('id'=>'submit-edit','type' => 'submit', 'class'=>'btn btn-primary btn-block')) }}				
					</div>
				</div>
		</div>
		@endif
	{{ Form::close() }}	
@stop