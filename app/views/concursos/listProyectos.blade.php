@extends('templates/concursosTemplate')	
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Proyectos</h3>
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
					{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
					{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
				</div>	
			</div>
		</div>
	{{ Form::close() }}</br>

	<table class="table" style ="width:100%;word-wrap:break-word;table-layout: fixed;">
		<tr class="info">
			<th>@if ($sortby == 'nombre' && $order == 'asc') {{
                        link_to_action(
                            'ConcursosController@search_proyecto',
                            'Nombre Proyecto',
                            array(
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
                            	'search' => $search,
                                'sortby' => 'nombre',
                                'order' => 'asc'
                            )
                        )
                    }}
                    @endif
            </th>
			<th>Reseña</th>
			<th>Concurso</th>
			<th>Jefe Proyecto</th>
			<th>Fecha Creación</th>
			<th>Estado</th>
		</tr>
		@foreach($proyectos_data as $proyecto_data)
		<tr class="@if($proyecto_data->deleted_at) bg-danger @endif">			
			<td>
				<a href="{{URL::to('/concursos/edit_proyecto/')}}/{{$proyecto_data->idproyectos}}">{{$proyecto_data->nombre}}</a>
			</td>
			<td>
				{{$proyecto_data->resenha}}
			</td>
			<td>
				{{$proyecto_data->titulo}}
			</td>
			<td>
				{{$proyecto_data->jefe_proyecto}}
			</td>
			<td>
				{{date('d/m/Y - H:i',strtotime($proyecto_data->created_at))}}
			</td>
			<td>
				@if($proyecto_data->aprobacion === 0)					
					{{ Form::hidden('aprobaciones[]', $proyecto_data->aprobacion,array('class'=>'hidden-aprobacion')) }}
					Pendiente
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
@stop