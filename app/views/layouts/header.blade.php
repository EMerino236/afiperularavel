<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a href="{{ URL::to('/') }}">
		<img src="{{ asset('img') }}/afilogo.png" width="46" style="display:block;margin-top:4px;" title="AFI Perú"/>
	</a>
</div>
<!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">
	<li>
		<a href="{{ URL::to('dashboard') }}"><i class="fa fa-home fa-fw"></i> Inicio</a>
    </li>
    @if(in_array('nav_convocatorias',$permisos))
	<li>
		<a href="{{ URL::to('convocatorias') }}"><i class="fa fa-bullhorn fa-fw"></i> Convocatorias</a>
    </li>
    @endif
    @if(in_array('nav_eventos',$permisos))
	<li>
		<a href="{{ URL::to('eventos') }}"><i class="fa fa-calendar fa-fw"></i> Eventos</a>
    </li>
    @endif
    @if(in_array('nav_voluntarios',$permisos))
	<li>
		<a href="{{ URL::to('voluntarios') }}"><i class="fa fa-users fa-fw"></i> Voluntarios</a>
    </li>
    @endif
    @if(in_array('nav_padrinos',$permisos))
	<li>
		<a href="{{ URL::to('padrinos') }}"><i class="fa fa-credit-card fa-fw"></i> Padrinos</a>
    </li>
    @endif
    @if(in_array('nav_colegios',$permisos))
    <li>
        <a href="{{ URL::to('colegios') }}"><i class="fa fa-send fa-fw"></i> Colegios</a>
    </li>
    @endif
    @if(in_array('nav_concursos',$permisos))
	<li>
		<a href="{{ URL::to('concursos') }}"><i class="fa fa-folder-open fa-fw"></i> Concursos</a>
    </li>
    @endif
    
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-gear fa-fw"></i>  <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            @if(in_array('nav_usuarios',$permisos))
            <li>
                <a href="{{ URL::to('user/list_users') }}"><i class="fa fa-wrench fa-fw"></i> Usuarios</a>
            </li>
            @endif
            @if(in_array('nav_sistema',$permisos))
            <li>
                <a href="{{ URL::to('sistema') }}"><i class="fa fa-gears fa-fw"></i> Sistema</a>
            </li>
            @endif
            <li>
                <a href="{{ URL::to('user/mi_cuenta') }}"><i class="fa fa-user fa-fw"></i> Mi Cuenta</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="{{ URL::to('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->