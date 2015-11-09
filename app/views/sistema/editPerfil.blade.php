@extends('templates/sistemaTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Perfil</h3><span class="campos-obligatorios">Los campos con asterisco son obligatorios</span>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('permisos') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'sistema/submit_edit_perfil', 'role'=>'form')) }}
		{{ Form::hidden('idperfiles', $perfil_info->idperfiles) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información básica del perfil <strong>{{$perfil_info->nombre}}</strong></h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6 required @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Cambiar Nombre del Perfil') }}
						{{ Form::text('nombre',null,array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-6 required @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Breve Descripción') }}
						{{ Form::text('descripcion',$perfil_info->descripcion,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<span class="campos-obligatorios"><strong>¡Cuidado! </strong>Modificar la información de un perfil que tenga usuarios asociados puede traer problemas de seguridad.</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-8 required">
			{{ Form::label('permisos[]','Permisos del Perfil') }}
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="convocatorias-parent" type="checkbox" name="permisos[]" value="1" @if($permisos_data && in_array("1",$permisos_data)) checked @endif>Convocatorias</h3>
					</div>
					<div class="panel-body">
						<input class="convocatorias-child" type="checkbox" name="permisos[]" value="9" @if($permisos_data && in_array("9",$permisos_data)) checked @endif> Crear Convocatoria<br>
						<input class="convocatorias-child" type="checkbox" name="permisos[]" value="10" @if($permisos_data && in_array("10",$permisos_data)) checked @endif> Listar Convocatorias<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="eventos-parent" type="checkbox" name="permisos[]" value="2" @if($permisos_data && in_array("2",$permisos_data)) checked @endif>Eventos</h3>
					</div>
					<div class="panel-body">
						<input class="eventos-child" type="checkbox" name="permisos[]" value="11" @if($permisos_data && in_array("11",$permisos_data)) checked @endif> Crear Evento<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="12" @if($permisos_data && in_array("12",$permisos_data)) checked @endif> Listar Eventos<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="13" @if($permisos_data && in_array("13",$permisos_data)) checked @endif> Crear Punto Reunion<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="14" @if($permisos_data && in_array("14",$permisos_data)) checked @endif> Listar Puntos Reunion<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="15" @if($permisos_data && in_array("15",$permisos_data)) checked @endif> Ver Mis Eventos<br>						
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="voluntarios-parent" type="checkbox" name="permisos[]" value="3" @if($permisos_data && in_array("3",$permisos_data)) checked @endif>Voluntarios</h3>
					</div>
					<div class="panel-body">
						<input class="voluntarios-child" type="checkbox" name="permisos[]" value="16" @if($permisos_data && in_array("16",$permisos_data)) checked @endif> Listar Voluntarios<br>
						<input class="voluntarios-child" type="checkbox" name="permisos[]" value="17" @if($permisos_data && in_array("17",$permisos_data)) checked @endif> Reporte de Asistencia<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="padrinos-parent" type="checkbox" name="permisos[]" value="4" @if($permisos_data && in_array("4",$permisos_data)) checked @endif>Padrinos</h3>
					</div>
					<div class="panel-body">
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="18" @if($permisos_data && in_array("18",$permisos_data)) checked @endif> Listar Padrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="19" @if($permisos_data && in_array("19",$permisos_data)) checked @endif> Aprobar Padrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="20" @if($permisos_data && in_array("20",$permisos_data)) checked @endif> Crear Reporte Padrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="21" @if($permisos_data && in_array("21",$permisos_data)) checked @endif> Listar Reportes Padrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="22" @if($permisos_data && in_array("22",$permisos_data)) checked @endif> Ver Calendario Pagos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="23" @if($permisos_data && in_array("23",$permisos_data)) checked @endif> Reporte de Pagos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="24" @if($permisos_data && in_array("24",$permisos_data)) checked @endif> Registrar Pago<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="39" @if($permisos_data && in_array("39",$permisos_data)) checked @endif> Mis Reportes<br>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="concursos-parent" type="checkbox" name="permisos[]" value="5" @if($permisos_data && in_array("5",$permisos_data)) checked @endif>Concursos</h3>
					</div>
					<div class="panel-body">
						<input class="concursos-child" type="checkbox" name="permisos[]" value="25" @if($permisos_data && in_array("25",$permisos_data)) checked @endif> Crear Concurso<br>
						<input class="concursos-child" type="checkbox" name="permisos[]" value="26" @if($permisos_data && in_array("26",$permisos_data)) checked @endif> Listar Concursos<br>
						<input class="concursos-child" type="checkbox" name="permisos[]" value="27" @if($permisos_data && in_array("27",$permisos_data)) checked @endif> Crear Proyecto<br>
						<input class="concursos-child" type="checkbox" name="permisos[]" value="28" @if($permisos_data && in_array("28",$permisos_data)) checked @endif> Listar Proyectos<br>
						<br>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="colegios-parent" type="checkbox" name="permisos[]" value="6" @if($permisos_data && in_array("6",$permisos_data)) checked @endif>Colegios</h3>
					</div>
					<div class="panel-body">
						<input class="colegios-child" type="checkbox" name="permisos[]" value="29" @if($permisos_data && in_array("29",$permisos_data)) checked @endif> Crear Colegio<br>
						<input class="colegios-child" type="checkbox" name="permisos[]" value="30" @if($permisos_data && in_array("30",$permisos_data)) checked @endif> Listar Colegios<br>
						<input class="colegios-child" type="checkbox" name="permisos[]" value="31" @if($permisos_data && in_array("31",$permisos_data)) checked @endif> Aprobar Colegios<br>
						<input class="colegios-child" type="checkbox" name="permisos[]" value="32" @if($permisos_data && in_array("32",$permisos_data)) checked @endif> Registrar Niño<br>
						<input class="colegios-child" type="checkbox" name="permisos[]" value="33" @if($permisos_data && in_array("33",$permisos_data)) checked @endif> Listar Niños<br>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="usuarios-parent" type="checkbox" name="permisos[]" value="7" @if($permisos_data && in_array("7",$permisos_data)) checked @endif>Usuarios</h3>
					</div>
					<div class="panel-body">
						<input class="usuarios-child" type="checkbox" name="permisos[]" value="34" @if($permisos_data && in_array("34",$permisos_data)) checked @endif> Crear Usuario<br>
						<input class="usuarios-child" type="checkbox" name="permisos[]" value="35" @if($permisos_data && in_array("35",$permisos_data)) checked @endif> Listar Usuarios<br>
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="sistema-parent" type="checkbox" name="permisos[]" value="8" @if($permisos_data && in_array("8",$permisos_data)) checked @endif>Sistema</h3>
					</div>
					<div class="panel-body">
						<input class="sistema-child" type="checkbox" name="permisos[]" value="36" @if($permisos_data && in_array("36",$permisos_data)) checked @endif> Crear Perfil<br>
						<input class="sistema-child" type="checkbox" name="permisos[]" value="37" @if($permisos_data && in_array("37",$permisos_data)) checked @endif> Listar Perfiles<br>
						<input class="sistema-child" type="checkbox" name="permisos[]" value="38" @if($permisos_data && in_array("38",$permisos_data)) checked @endif> Listar Perfiles<br>
						<br>
						<br>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				{{ Form::submit('Guardar',array('id'=>'submit-save', 'class'=>'btn btn-primary')) }}
			</div>
	{{ Form::close() }}
	{{ Form::open(array('url'=>'sistema/submit_disable_perfil', 'role'=>'form')) }}
		{{ Form::hidden('idperfiles', $perfil_info->idperfiles) }}
		@if($perfil_info->idperfiles>4)
			<div class="form-group col-md-6">
				{{ Form::submit('Eliminar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}
			</div>
		@endif
	{{ Form::close() }}
		</div>
<script src="{{ asset('js/sistema/perfiles.js') }}"></script>
@stop