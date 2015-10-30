@extends('templates/concursosTemplate')	
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Concursos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/concursos/search_concurso','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
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

	<table class="table">
		<tr class="info">
			<th>Titulo</th>
			<th>Reseña</th>
			<th>Fecha Creación</th>
			<th>Documentos</th>
		</tr>
		@foreach($concursos_data as $concurso_data)
		<tr class="@if($concurso_data->deleted_at) bg-danger @endif">			
			<td>
				{{$concurso_data->titulo}}
			</td>
			<td>
				{{$concurso_data->resenha}}
			</td>
			<td>
				{{date('d/m/Y - H:i',strtotime($concurso_data->created_at))}}
			</td>
			<td>
				<a href="{{URL::to('/concursos/upload_file/')}}/{{$concurso_data->idconcursos}}">Documentos</a>
			</td>
		</tr>
		@endforeach
	</table>
	
@stop