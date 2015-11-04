@extends('templates/padrinosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Padrinos</h3>
            <h3 class="page-header">Lista de Padrinos Pendientes de Aprobación</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/padrinos/search_padrino','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
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
    <table class="table">
		<tr class="info">
			<th>Doc. de identidad</th>
			<th>DNI</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>E-mail</th>
			<th>Periodo de Pago</th>
			<th>Apellido Paterno</th>
			<th>Apellido Materno</th>			
		</tr>
		@foreach($padrinos_data as $padrino_data)
		<tr class="@if($padrino_data->deleted_at) bg-danger @endif">
			<td>
				<a href="{{URL::to('/padrinos/edit_padrino/')}}/{{$padrino_data->id}}">{{$padrino_data->num_documento}}</a>
			</td>
			<td>
				{{$padrino_data->nombres}}
			</td>
			<td>
				{{$padrino_data->apellido_pat}} {{$padrino_data->apellido_mat}}
			</td>
			<td>
				{{$padrino_data->email}}
			</td>
			<td>
				{{$padrino_data->nombre}}
			</td>
		@foreach($prepadrinos_data as $prepadrino_data)
		<tr class="@if($prepadrino_data->deleted_at) bg-danger @endif">
			@if(!$prepadrino_data->deleted_at)
				<td>
					<a href="{{URL::to('/padrinos/edit_prepadrino/')}}/{{$prepadrino_data->idprepadrinos}}">{{$prepadrino_data->dni}}</a>
				</td>
				<td>
					{{$prepadrino_data->nombres}}
				</td>
				<td>
					{{$prepadrino_data->apellido_pat}}
				</td>
				<td>
					{{$prepadrino_data->apellido_mat}}
				</td>				
			@endif
		</tr>
		@endforeach
	</table>
	@if($search)
		{{ $padrinos_data->appends(array('search' => $search))->links() }}
	@else
		{{ $padrinos_data->links() }}
	@endif
@stop