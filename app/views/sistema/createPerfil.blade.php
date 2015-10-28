@extends('templates/sistemaTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Registrar Perfil</h3>
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

	{{ Form::open(array('url'=>'sistema/submit_create_perfil', 'role'=>'form')) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre del Perfil') }}
					{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
				</div>
			</div>		
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Breve Descripción') }}
					{{ Form::text('descripcion',Input::old('descripcion'),array('class'=>'form-control')) }}
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
						<h3 class="panel-title"><input class="convocatorias-parent" type="checkbox" name="permisos[]" value="1" @if(Input::old('permisos') && in_array("1",Input::old('permisos'))) checked @endif>Menú Convocatorias</h3>
					</div>
					<div class="panel-body">
						<input class="convocatorias-child" type="checkbox" name="permisos[]" value="9" @if(Input::old('permisos') && in_array("9",Input::old('permisos'))) checked @endif> Crear Convocatoria<br>
						<input class="convocatorias-child" type="checkbox" name="permisos[]" value="10" @if(Input::old('permisos') && in_array("10",Input::old('permisos'))) checked @endif> Listar Convocatorias<br>
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
						<h3 class="panel-title"><input class="eventos-parent" type="checkbox" name="permisos[]" value="2" @if(Input::old('permisos') && in_array("2",Input::old('permisos'))) checked @endif>Menú Eventos</h3>
					</div>
					<div class="panel-body">
						<input class="eventos-child" type="checkbox" name="permisos[]" value="11" @if(Input::old('permisos') && in_array("11",Input::old('permisos'))) checked @endif> Crear Evento<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="12" @if(Input::old('permisos') && in_array("12",Input::old('permisos'))) checked @endif> Listar Eventos<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="13" @if(Input::old('permisos') && in_array("13",Input::old('permisos'))) checked @endif> Crear Punto Reunion<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="14" @if(Input::old('permisos') && in_array("14",Input::old('permisos'))) checked @endif> Listar Puntos Reunion<br>
						<input class="eventos-child" type="checkbox" name="permisos[]" value="15" @if(Input::old('permisos') && in_array("15",Input::old('permisos'))) checked @endif> Ver Mis Eventos<br>						
						<br>
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="voluntarios-parent" type="checkbox" name="permisos[]" value="3" @if(Input::old('permisos') && in_array("3",Input::old('permisos'))) checked @endif>Menú Voluntarios</h3>
					</div>
					<div class="panel-body">
						<input class="voluntarios-child" type="checkbox" name="permisos[]" value="16" @if(Input::old('permisos') && in_array("16",Input::old('permisos'))) checked @endif> Listar Voluntarios<br>
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
						<h3 class="panel-title"><input class="padrinos-parent" type="checkbox" name="permisos[]" value="4" @if(Input::old('permisos') && in_array("4",Input::old('permisos'))) checked @endif>Menú Padrinos</h3>
					</div>
					<div class="panel-body">
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="17" @if(Input::old('permisos') && in_array("17",Input::old('permisos'))) checked @endif> Listar Padrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="18" @if(Input::old('permisos') && in_array("18",Input::old('permisos'))) checked @endif> Aprobar Padrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="19" @if(Input::old('permisos') && in_array("19",Input::old('permisos'))) checked @endif> Crear Reporte Padrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="20" @if(Input::old('permisos') && in_array("20",Input::old('permisos'))) checked @endif> Listar Reportes Padrinos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="21" @if(Input::old('permisos') && in_array("21",Input::old('permisos'))) checked @endif> Ver Calendario Pagos<br>
						<input class="padrinos-child" type="checkbox" name="permisos[]" value="22" @if(Input::old('permisos') && in_array("22",Input::old('permisos'))) checked @endif> Registrar Pago<br>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="concursos-parent" type="checkbox" name="permisos[]" value="5" @if(Input::old('permisos') && in_array("5",Input::old('permisos'))) checked @endif>Menú Concursos</h3>
					</div>
					<div class="panel-body">
						<input class="concursos-child" type="checkbox" name="permisos[]" value="23" @if(Input::old('permisos') && in_array("23",Input::old('permisos'))) checked @endif> Crear Concurso<br>
						<input class="concursos-child" type="checkbox" name="permisos[]" value="24" @if(Input::old('permisos') && in_array("24",Input::old('permisos'))) checked @endif> Listar Concursos<br>
						<input class="concursos-child" type="checkbox" name="permisos[]" value="25" @if(Input::old('permisos') && in_array("25",Input::old('permisos'))) checked @endif> Crear Proyecto<br>
						<input class="concursos-child" type="checkbox" name="permisos[]" value="26" @if(Input::old('permisos') && in_array("26",Input::old('permisos'))) checked @endif> Listar Proyectos<br>
						<br>
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="colegios-parent" type="checkbox" name="permisos[]" value="6" @if(Input::old('permisos') && in_array("6",Input::old('permisos'))) checked @endif>Menú Colegios</h3>
					</div>
					<div class="panel-body">
						<input class="colegios-child" type="checkbox" name="permisos[]" value="27" @if(Input::old('permisos') && in_array("27",Input::old('permisos'))) checked @endif> Crear Colegio<br>
						<input class="colegios-child" type="checkbox" name="permisos[]" value="28" @if(Input::old('permisos') && in_array("28",Input::old('permisos'))) checked @endif> Listar Colegios<br>
						<input class="colegios-child" type="checkbox" name="permisos[]" value="29" @if(Input::old('permisos') && in_array("29",Input::old('permisos'))) checked @endif> Aprobar Colegios<br>
						<input class="colegios-child" type="checkbox" name="permisos[]" value="30" @if(Input::old('permisos') && in_array("30",Input::old('permisos'))) checked @endif> Registrar Niño<br>
						<input class="colegios-child" type="checkbox" name="permisos[]" value="31" @if(Input::old('permisos') && in_array("31",Input::old('permisos'))) checked @endif> Listar Niños<br>
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="usuarios-parent" type="checkbox" name="permisos[]" value="7" @if(Input::old('permisos') && in_array("7",Input::old('permisos'))) checked @endif>Menú Usuarios</h3>
					</div>
					<div class="panel-body">
						<input class="usuarios-child" type="checkbox" name="permisos[]" value="32" @if(Input::old('permisos') && in_array("32",Input::old('permisos'))) checked @endif> Crear Usuario<br>
						<input class="usuarios-child" type="checkbox" name="permisos[]" value="33" @if(Input::old('permisos') && in_array("33",Input::old('permisos'))) checked @endif> Listar Usuarios<br>
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><input class="sistema-parent" type="checkbox" name="permisos[]" value="8" @if(Input::old('permisos') && in_array("8",Input::old('permisos'))) checked @endif>Menú Sistema</h3>
					</div>
					<div class="panel-body">
						<input class="sistema-child" type="checkbox" name="permisos[]" value="34" @if(Input::old('permisos') && in_array("34",Input::old('permisos'))) checked @endif> Crear Perfil<br>
						<input class="sistema-child" type="checkbox" name="permisos[]" value="35" @if(Input::old('permisos') && in_array("35",Input::old('permisos'))) checked @endif> Listar Perfiles<br>
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
				</div>
			</div>	
		</div>
	{{ Form::close() }}
@stop