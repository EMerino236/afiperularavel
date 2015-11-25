@extends('templates/concursosTemplate')	
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Concursos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

    {{ Form::open(array('url'=>'/concursos/search_concurso','method'=>'get' ,'role'=>'form', 'id'=>'search-form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Título, Reseña')) }}
				</div>	
				<div class="col-md-2">
					{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
				</div>
			</div>
		</div>
	{{ Form::close() }}</br>

	<table class="table" style ="width:100%;word-wrap:break-word;table-layout: fixed;">
		<tr class="info">
			<th>@if ($sortby == 'titulo' && $order == 'asc') {{
                        link_to_action(
                            'ConcursosController@search_concurso',
                            'Título',
                            array(
                            	'search' => $search,
                                'sortby' => 'titulo',
                                'order' => 'desc'
                            )
                        )
                    }}
                    @else {{              
                    	link_to_action(
                            'ConcursosController@search_concurso',
                            'Título',
                            array(
                            	'search' => $search,
                                'sortby' => 'titulo',
                                'order' => 'asc'
                            )
                        )
                    }}
                    @endif
            </th>
			<th>Reseña</th>
			<th>Fecha Creación</th>
			<th>Fases</th>
			<th>Documentos</th>
			<th>Proyectos</th>
		</tr>
		@foreach($concursos_data as $concurso_data)
		<tr class="@if($concurso_data->deleted_at) bg-danger @endif">			
			<td>
				<a href="{{URL::to('/concursos/edit_concurso/')}}/{{$concurso_data->idconcursos}}">{{$concurso_data->titulo}}</a>
			</td>
			<td>
				{{$concurso_data->resenha}}
			</td>
			<td>
				{{date('d/m/Y - H:i',strtotime($concurso_data->created_at))}}
			</td>
			<td>
				<a href="{{URL::to('/concursos/fases_concurso/')}}/{{$concurso_data->idconcursos}}">Fases</a>
			</td>
			<td>
				<a href="{{URL::to('/concursos/upload_file/')}}/{{$concurso_data->idconcursos}}">Documentos</a>
			</td>
			<td>
				<a href="{{URL::to('/concursos/list_proyectos_asociados/')}}/{{$concurso_data->idconcursos}}">Proyectos</a>
			</td>
		</tr>
		@endforeach
	</table>
	@if($concursos_data)
		{{ $concursos_data->links() }}
	@endif
@stop