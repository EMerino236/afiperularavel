@extends('templates/eventosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Mis Eventos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	@if(in_array('side_mis_eventos',$permisos) && $periodo_actual && !$usuario_ya_inscrito)
	{{ Form::open(array('url'=>'voluntarios/submit_repostulacion', 'role'=>'form')) }}
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
	{{ Form::close() }}	
	@endif
	<div class="col-xs-12">
		<!-- Responsive calendar - START -->
		<div class="responsive-calendar">
		  <div class="controls">
		      <a class="pull-left" data-go="prev"><div class="btn"><i class="glyphicon glyphicon-chevron-left"></i></div></a>
		      <h4><span data-head-year></span> <span data-head-month></span></h4>
		      <a class="pull-right" data-go="next"><div class="btn"><i class="glyphicon glyphicon-chevron-right"></i></div></a>
		  </div><hr/>
		  <div class="day-headers">
		    <div class="day header">Lun</div>
		    <div class="day header">Mar</div>
		    <div class="day header">Mie</div>
		    <div class="day header">Jue</div>
		    <div class="day header">Vie</div>
		    <div class="day header">Sab</div>
		    <div class="day header">Dom</div>
		  </div>
		  <div class="days" data-group="days">
		    <!-- the place where days will be generated -->
		  </div>
		</div>
		<!-- Responsive calendar - END -->
	</div>

<script src="{{ asset('js/eventos/mis-eventos.js') }}"></script>
@stop