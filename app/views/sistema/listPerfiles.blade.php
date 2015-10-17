@extends('templates/sistemaTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Perfiles</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	<table class="table">
		<tr class="info">
			<th>Perfil</th>
			<th>Descripción</th>
		</tr>
		@foreach($perfiles_data as $perfil_data)
		<tr>
			<td>
				<a href="{{URL::to('/sistema/edit_perfil/')}}/{{$perfil_data->idperfiles}}">{{$perfil_data->nombre}}</a>
			</td>
			<td>
				{{$perfil_data->descripcion}}
			</td>
		</tr>
		@endforeach
	</table>
	{{ $perfiles_data->links() }}
@stop