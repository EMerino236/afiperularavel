@extends('templates/colegiosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Colegios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	{{ Form::open(array('url'=>'/colegios/search_colegio','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
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
			<th>Nombre</th>
			<th>Dirección</th>
			<th>Nombre contacto</th>
		</tr>
		@foreach($colegios_data as $colegio_data)
		<tr class="@if($colegio_data->deleted_at) bg-danger @endif">
			<td>
				<a href="{{URL::to('/colegios/edit_colegio/')}}/{{$colegio_data->idcolegios}}">{{$colegio_data->nombre}}</a>
			</td>
			<td>
				{{$colegio_data->direccion}}
			</td>
			<td>
				{{$colegio_data->nombre_contacto}}
			</td>
		</tr>
		@endforeach
	</table>
@stop