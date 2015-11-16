@extends('templates/concursosTemplate')	
@section('content')
	<div class="row">
        <div class="col-lg-12">
        	@if($aprobar ==0)
            	<h3 class="page-header">Lista de Proyectos</h3>
            @endif
            @if($aprobar ==1)
            	<h3 class="page-header">Lista de Proyectos del Concurso: {{$concursos_data->titulo}}</h3>
            @endif
        </div>
        <!-- /.col-lg-12 -->
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

    {{ Form::open(array('url'=>'/concursos/search_proyecto','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
				<div class="search_bar">
					@if($aprobar == 1)
						{{ Form::hidden('idconcursos',$concursos_data->idconcursos) }}
					@endif
					@if($aprobar ==0)
						{{ Form::hidden('idconcursos',0) }}
					@endif
					{{ Form::hidden('aprobar',$aprobar) }}
					{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
					{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
				</div>	
			</div>
		</div>
	{{ Form::close() }}</br>
	<?php
		if($aprobar==0){
			$id = 0;
		}
		else{
			$id = $concursos_data->idconcursos;
		}
	 ?>
	<table class="table" style ="width:100%;word-wrap:break-word;table-layout: fixed;">
		<tr class="info">			
			<th>@if ($sortby == 'nombre' && $order == 'asc') {{
                        link_to_action(
                            'ConcursosController@search_proyecto',
                            'Nombre Proyecto',
                            array(
                            	'idconcursos'=>$id,
                            	'aprobar' => $aprobar,
                            	'search' => $search,
                                'sortby' => 'nombre',
                                'order' => 'desc'
                            )
                        )
                    }}
                    @else {{              
                    	link_to_action(
                            'ConcursosController@search_proyecto',
                            'Nombre Proyecto',
                            array(
                            	'idconcursos'=>$id,
                            	'aprobar' => $aprobar,
                            	'search' => $search,
                                'sortby' => 'nombre',
                                'order' => 'asc'
                            )
                        )
                    }}
                    @endif
            </th>
			<th>Concurso Asociado</th>
			<th>Jefe Proyecto</th>
			<th>Detalle</th>
			<th>Documentos</th>
			<th class="text-center">Estado</th>
		</tr>
		@foreach($proyectos_data as $proyecto_data)
		<tr class="@if($proyecto_data->deleted_at) bg-danger @endif">			
			<td>
				<a href="{{URL::to('/concursos/edit_proyecto/')}}/{{$proyecto_data->idproyectos}}">{{$proyecto_data->nombre}}</a>
			</td>			
			<td>
				{{$proyecto_data->titulo}}
			</td>
			<td>
				{{$proyecto_data->jefe_proyecto}}
			</td>	
			<td>
				<a href="{{URL::to('/concursos/detalle_proyecto/')}}/{{$proyecto_data->idproyectos}}">Detalle</a>
			</td>
			<td>
				<a href="{{URL::to('/concursos/upload_file_proyecto/')}}/{{$proyecto_data->idproyectos}}">Documentos</a>
			</td>		
			<td class="text-center" style="vertical-align:middle">
			
				@if($proyecto_data->aprobacion == 0)
					@if($aprobar==0)									
						{{ Form::hidden('aprobaciones[]', $proyecto_data->aprobacion,array('class'=>'hidden-aprobacion')) }}
						Pendiente							
					@endif
					@if($aprobar==1)
						{{Form::hidden('idconcursos',$concursos_data->idconcursos)}}
						<input type="checkbox" name="aprobacion" class="checkbox-aprobacion" value="{{$proyecto_data->idproyectos}}"  @if($proyecto_data->deleted_at) checked @endif>
						
					@endif
				@endif
				@if($proyecto_data->aprobacion === 2)					
					{{ Form::hidden('aprobaciones[]', -1) }}
					No Aprobado
				@endif
				@if($proyecto_data->aprobacion === 1)					
					{{ Form::hidden('aprobaciones[]', -1) }}
					Aprobado
				@endif
			</td>
		</tr>
		@endforeach
	</table>	
	@if($proyectos_data)
		{{ $proyectos_data->links() }}
	@endif
	@if($aprobacion)
		@if($aprobacion->aprobacion==0)
			<div class="loader_container" style="display:none;">
				{{ HTML::image('img/loading.gif') }}
			</div>
			{{ HTML::link('','Aprobar',array('id'=>'submit-aprobar-proyecto', 'class'=>'btn btn-primary')) }}
		@endif
	@endif
@stop