@extends('templates/colegiosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Colegios Pendientes de Aprobación</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <table class="table">
		<tr class="info">
			<th>Nombre</th>
			<th>Dirección</th>
			<th>Nombre contacto</th>
		</tr>
		@foreach($precolegios_data as $precolegio_data)
		<tr class="@if($precolegio_data->deleted_at) bg-danger @endif">
			@if(!$precolegio_data->deleted_at)
				<td>
					<a href="{{URL::to('/colegios/edit_precolegio/')}}/{{$precolegio_data->idprecolegios}}">{{$precolegio_data->nombre}}</a>
				</td>
				<td>
					{{$precolegio_data->direccion}}
				</td>
				<td>
					{{$precolegio_data->nombre_contacto}}
				</td>
			@endif
		</tr>
		@endforeach
	</table>
@stop