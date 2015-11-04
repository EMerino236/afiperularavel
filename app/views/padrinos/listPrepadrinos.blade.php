@extends('templates/padrinosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Padrinos Pendientes de Aprobación</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <table class="table">
		<tr class="info">
			<th>DNI</th>
			<th>Nombres</th>
			<th>Apellido Paterno</th>
			<th>Apellido Materno</th>			
		</tr>
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
@stop