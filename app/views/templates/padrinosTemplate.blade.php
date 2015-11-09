<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, follow">
    <title>Padrinos</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Datepicker CSS-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
    <!-- MetisMenu CSS -->
    <link href="{{ asset('bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/general.css') }}" rel="stylesheet">
    <script type="text/javascript">
        var inside_url = "{{$inside_url}}";
    </script>
    <!-- jQuery -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Moment JavaScript -->
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <!-- Bootstrap Datepicker JavaScript -->
    <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('dist/js/sb-admin-2.js') }}"></script>
    <script src="{{ asset('js/padrinos/pagos.js') }}"></script>
    <script src="{{ asset('js/padrinos/padrinos.js') }}"></script>
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            @include('layouts.header', array('user'=>$user,'permisos'=>$permisos))
            <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    @if(in_array('side_listar_padrinos',$permisos))
                    <li><a href="{{ URL::to('padrinos/list_padrinos') }}"><i class="fa fa-list fa-fw"></i> Listar Padrinos</a></li>
                    @endif
                    @if(in_array('side_aprobar_padrinos',$permisos))
                    <li><a href="{{ URL::to('padrinos/list_prepadrinos') }}"><i class="fa fa-check fa-fw"></i> Aprobar Padrinos</a></li>
                    @endif
                    @if(in_array('side_nuevo_reporte_padrinos',$permisos))
                    <li><a href="{{ URL::to('padrinos/create_reporte_padrinos') }}"><i class="fa fa-file-o fa-fw"></i> Crear Reporte a Padrinos</a></li>
                    @endif
                    @if(in_array('side_listar_reportes_padrinos',$permisos))
                    <li><a href="{{ URL::to('padrinos/list_reporte_padrinos') }}"><i class="fa fa-files-o fa-fw"></i> Listar Reportes Creados</a></li>
                    @endif
                    @if(in_array('side_calendario_pagos',$permisos))
                    <li><a href="{{ URL::to('padrinos/view_calendario_pagos') }}"><i class="fa fa-calendar-o fa-fw"></i> Calendario de Pagos</a></li>
                    @endif
                    @if(in_array('side_reporte_pagos',$permisos))
                    <li><a href="{{ URL::to('padrinos/reporte_pagos_padrinos') }}"><i class="fa fa-bar-chart-o fa-fw"></i> Reporte de Pagos</a></li>
                    @endif
                    @if(in_array('side_registrar_pago',$permisos))
                    <li><a href="{{ URL::to('#') }}"><i class="fa fa-thumb-tack fa-fw"></i> Registrar Pago</a></li>
                    @endif
                    @if(in_array('side_reporte_pagos',$permisos))
                    <li><a href="{{ URL::to('padrinos/list_aprobar_pagos') }}"><i class="fa fa-check fa-fw"></i> Aprobar Pagos</a></li>
                    @endif
                    @if(in_array('side_mis_reportes',$permisos))
                    <li><a href="{{ URL::to('padrinos/list_mis_reportes') }}"><i class="fa fa-paperclip fa-fw"></i> Mis Reportes</a></li>
                    @endif
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        </nav>
        <div id="page-wrapper">
            @yield('content')
        </div>
    </div>
</body>
</html>