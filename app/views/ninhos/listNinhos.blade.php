@extends('templates/colegiosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Niños</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/ninhos/search_ninho','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
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
			<th>DNI</th>
			<th>Nombre</th>
			<th>Edad</th>
			<th>Colegio</th>
			<th>N° Familiares</th>
		</tr>
		
		@foreach($ninhos_data as $ninho_data)
		<tr class="@if($ninho_data->deleted_at) bg-danger @endif">
			<td>
				{{$ninho_data->dni}}
			</td>
			<td>
				{{$ninho_data->nombres}} {{$ninho_data->apellido_pat}} {{$ninho_data->apellido_mat}}
			</td>
			<?php
				$date = DateTime::createFromFormat("Y-m-d", $ninho_data->fecha_nacimiento);
				$year = $date->format('Y');
				$age = date('Y') - $year;
			?>
			<td>
				{{$age}}
			</td>
			<td>
				{{$ninho_data->nombre}}
			</td>
			<td>
				{{$ninho_data->num_familiares}}
			</td>
		</tr>
		@endforeach
	</table>
@stop