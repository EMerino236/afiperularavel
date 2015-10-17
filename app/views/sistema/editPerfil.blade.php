@extends('templates/sistemaTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Perfil</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'sistema/submit_disable_perfil', 'role'=>'form')) }}
		{{ Form::hidden('idperfiles', $perfil_info->idperfiles) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre del Perfil') }}
					{{ Form::text('nombre',$perfil_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>		
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Breve Descripción') }}
					{{ Form::text('descripcion',$perfil_info->descripcion,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="row">
				<div class="form-group col-xs-8">
				{{ Form::label('permisos[]','Seleccione los Permisos del Nuevo Perfil') }}
				</div>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Convocatorias</h3>
					</div>
					<div class="panel-body">
						<input class="convocatorias-parent" type="checkbox" name="permisos[]" value="1" @if($permisos_data && in_array("1",$permisos_data)) checked @endif disabled> Menú Convocatorias<br>
						<input class="convocatorias-child" type="checkbox" name="permisos[]" value="9" @if($permisos_data && in_array("9",$permisos_data)) checked @endif disabled> Crear Convocatoria<br>
						<input class="convocatorias-child" type="checkbox" name="permisos[]" value="10" @if($permisos_data && in_array("10",$permisos_data)) checked @endif disabled> Listar Convocatorias<br>
						<br>
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Eventos</h3>
					</div>
					<div class="panel-body">
						<input class="eventos-parent" type="checkbox" name="permisos[]" value="2" @if($permisos_data && in_array("2",$permisos_data)) checked @endif disabled> Menú Eventos<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="11" @if($permisos_data && in_array("11",$permisos_data)) checked @endif disabled> Crear Evento<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="12" @if($permisos_data && in_array("12",$permisos_data)) checked @endif disabled> Listar Eventos<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="13" @if($permisos_data && in_array("13",$permisos_data)) checked @endif disabled> Crear Punto Reunion<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="14" @if($permisos_data && in_array("14",$permisos_data)) checked @endif disabled> Listar Puntos Reunion<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="15" @if($permisos_data && in_array("15",$permisos_data)) checked @endif disabled> Ver Mis Eventos<br>						
						<br>
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Voluntarios</h3>
					</div>
					<div class="panel-body">
						<input class="voluntarios-parent" type="checkbox" name="permisos[]" value="3" @if($permisos_data && in_array("3",$permisos_data)) checked @endif disabled> Menú Voluntarios<br>
						<input class="voluntarios-child" type="checkbox" name="permisos[]" value="16" @if($permisos_data && in_array("16",$permisos_data)) checked @endif disabled> Listar Voluntarios<br>
						<br>
						<br>
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Padrinos</h3>
					</div>
					<div class="panel-body">
						<input class="padrinos-parent" type="checkbox" name="permisos[]" value="4" @if($permisos_data && in_array("4",$permisos_data)) checked @endif disabled> Menú Pdrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="17" @if($permisos_data && in_array("17",$permisos_data)) checked @endif disabled> Listar Padrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="18" @if($permisos_data && in_array("18",$permisos_data)) checked @endif disabled> Aprobar Padrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="19" @if($permisos_data && in_array("19",$permisos_data)) checked @endif disabled> Crear Reporte Padrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="20" @if($permisos_data && in_array("20",$permisos_data)) checked @endif disabled> Listar Reportes Padrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="21" @if($permisos_data && in_array("21",$permisos_data)) checked @endif disabled> Ver Calendario Pagos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="22" @if($permisos_data && in_array("22",$permisos_data)) checked @endif disabled> Registrar Pago<br>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Concursos</h3>
					</div>
					<div class="panel-body">
						<input class="concursos-parent" type="checkbox" name="permisos[]" value="5" @if($permisos_data && in_array("5",$permisos_data)) checked @endif disabled> Menú Concursos<br>
						<input class="concursos-child" type="checkbox" name="permisos[]" value="23" @if($permisos_data && in_array("23",$permisos_data)) checked @endif disabled> Crear Concurso<br>
						<input class="concursos-child" type="checkbox" name="permisos[]" value="24" @if($permisos_data && in_array("24",$permisos_data)) checked @endif disabled> Listar Concursos<br>
						<input class="concursos-child" type="checkbox" name="permisos[]" value="25" @if($permisos_data && in_array("25",$permisos_data)) checked @endif disabled> Crear Proyecto<br>
						<input class="concursos-child" type="checkbox" name="permisos[]" value="26" @if($permisos_data && in_array("26",$permisos_data)) checked @endif disabled> Listar Proyectos<br>
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Colegios</h3>
					</div>
					<div class="panel-body">
						<input class="colegios-parent" type="checkbox" name="permisos[]" value="6" @if($permisos_data && in_array("6",$permisos_data)) checked @endif disabled> Menú Colegios<br>
						<input class="colegios-child" type="checkbox" name="permisos[]" value="27" @if($permisos_data && in_array("27",$permisos_data)) checked @endif disabled> Crear Colegio<br>
						<input class="colegios-child" type="checkbox" name="permisos[]" value="28" @if($permisos_data && in_array("28",$permisos_data)) checked @endif disabled> Listar Colegios<br>
						<input class="colegios-child" type="checkbox" name="permisos[]" value="29" @if($permisos_data && in_array("29",$permisos_data)) checked @endif disabled> Aprobar Colegios<br>
						<br>
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Usuarios</h3>
					</div>
					<div class="panel-body">
						<input class="usuarios-parent" type="checkbox" name="permisos[]" value="7" @if($permisos_data && in_array("7",$permisos_data)) checked @endif disabled> Menú Usuarios<br>
						<input class="usuarios-child" type="checkbox" name="permisos[]" value="30" @if($permisos_data && in_array("30",$permisos_data)) checked @endif disabled> Crear Usuario<br>
						<input class="usuarios-child" type="checkbox" name="permisos[]" value="31" @if($permisos_data && in_array("31",$permisos_data)) checked @endif disabled> Listar Usuarios<br>
						<br>
						<br>
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Sistema</h3>
					</div>
					<div class="panel-body">
						<input class="sistema-parent" type="checkbox" name="permisos[]" value="8" @if($permisos_data && in_array("8",$permisos_data)) checked @endif disabled> Menú Sistema<br>
						<input class="sistema-child" type="checkbox" name="permisos[]" value="32" @if($permisos_data && in_array("32",$permisos_data)) checked @endif disabled> Crear Perfil<br>
						<input class="sistema-child" type="checkbox" name="permisos[]" value="33" @if($permisos_data && in_array("33",$permisos_data)) checked @endif disabled> Listar Perfiles<br>
						<br>
						<br>
					</div>
				</div>
			</div>
		</div>
		@if($perfil_info->idperfiles>4)
		<div class="col-xs-12">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Eliminar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}
				</div>
			</div>	
		</div>
		@endif
	{{ Form::close() }}
@stop