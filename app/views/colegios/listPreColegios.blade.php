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
			<th>Seleccionar <input type="checkbox" name="seleccionar-todos-precolegios" value="0"></th>
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
				<td class="text-center" style="vertical-align:middle">
					<input type="checkbox" name="aprobacion" class="checkbox-aprobacion" value="{{$precolegio_data->idprecolegios}}"  @if($precolegio_data->deleted_at) checked @endif>
				</td>
			@endif
		</tr>
		@endforeach
	</table>
	<div class="col-md-12">
		<div class="row">
			<div class="form-group col-md-8">	
			@if(!$precolegios_data->isEmpty())
				<div class="loader_container" style="display:none;">
					{{ HTML::image('img/loading.gif') }}
				</div>						
				{{ HTML::link('','Aprobar',array('id'=>'submit-aprobar-precolegios', 'class'=>'btn btn-primary')) }}
			@endif
			</div>
		</div>
	</div>
	@if($precolegios_data)
		{{ $precolegios_data->links() }}
	@endif
@stop