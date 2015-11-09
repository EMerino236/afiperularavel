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
		@if(in_array('side_mis_eventos',$permisos) && $periodo_actual && !$usuario_ya_inscrito)
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
		<div class="row">
		@if(in_array('side_aprobar_padrinos',$permisos))
			<div class="col-lg-3 col-md-12">
	            <div class="panel panel-primary">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-credit-card fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge">{{$prepadrinos}}</div>
	                            <div>Padrinos nuevos</div>
	                        </div>
	                    </div>
	                </div>
	                <a href="#">
	                    <div class="panel-footer">
	                    	<a class="pull-left" href="{{ URL::to('padrinos/list_prepadrinos') }}">Ir a aprobar padrinos</a>
	                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                        <div class="clearfix"></div>
	                    </div>
	                </a>
	            </div>
	        </div>
		@endif
		@if(in_array('side_listar_convocatorias',$permisos))
			<div class="col-lg-3 col-md-12">
	            <div class="panel panel-green">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-bullhorn fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge">{{$postulantes}}</div>
	                            <div>Postulantes nuevos</div>
	                        </div>
	                    </div>
	                </div>
	                <a href="#">
	                    <div class="panel-footer">
	                    	@if($idperiodos != NULL)
		                        <a class="pull-left" href="{{ URL::to('convocatorias/list_postulantes') }}/{{$idperiodos}}">Ver postulantes</a>
		                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                        <div class="clearfix"></div>
		                    @endif
	                    </div>
	                </a>
	            </div>
	        </div>
		@endif
		@if(in_array('side_aprobar_colegios',$permisos))
			<div class="col-lg-3 col-md-12">
	            <div class="panel panel-yellow">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-university fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge">{{$precolegios}}</div>
	                            <div>Colegios nuevos</div>
	                        </div>
	                    </div>
	                </div>
	                <a href="#">
	                    <div class="panel-footer">
	                        <a class="pull-left" href="{{ URL::to('colegios/list_precolegios') }}">Ir a aprobar colegios</a>
	                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                        <div class="clearfix"></div>
	                    </div>
	                </a>
	            </div>
	        </div>
		@endif
		@if(in_array('side_listar_usuarios',$permisos))
			<div class="col-lg-3 col-md-12">
	            <div class="panel panel-red">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-user fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge">{{$usuarios}}</div>
	                            <div>Usuarios registrados</div>
	                        </div>
	                    </div>
	                </div>
	                <a href="#">
	                    <div class="panel-footer">
	                        <a class="pull-left" href="{{ URL::to('user/list_users') }}">Listar usuarios</a>
	                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                        <div class="clearfix"></div>
	                    </div>
	                </a>
	            </div>
	        </div>
		@endif
	    </div>
	{{ Form::close() }}	
@stop