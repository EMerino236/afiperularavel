@extends('templates/userTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Usuarios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/user/search_user','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
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
			<th>Doc. de identidad</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>E-mail</th>
		</tr>
		@foreach($users_data as $user_data)
		<tr class="@if($user_data->deleted_at) bg-danger @endif">
			<td>
				<a href="{{URL::to('/user/edit_user/')}}/{{$user_data->id}}">{{$user_data->num_documento}}</a>
			</td>
			<td>
				{{$user_data->nombres}}
			</td>
			<td>
				{{$user_data->apellido_pat}} {{$user_data->apellido_mat}}
			</td>
			<td>
				{{$user_data->email}}
			</td>
		</tr>
		@endforeach
	</table>
	@if($search)
		{{ $users_data->appends(array('search' => $search))->links() }}
	@else
		{{ $users_data->links() }}
	@endif
@stop