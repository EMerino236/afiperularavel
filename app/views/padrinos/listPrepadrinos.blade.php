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
			<th>Seleccionar <input type="checkbox" name="seleccionar-todos-prepadrinos" value="0"></th>
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
				<td class="text-center" style="vertical-align:middle">
					<input type="checkbox" name="aprobacion" class="checkbox-aprobacion" value="{{$prepadrino_data->idprepadrinos}}"  @if($prepadrino_data->deleted_at) checked @endif>
				</td>
			@endif
		</tr>
		@endforeach
	</table>
	<div class="row">
		<div class="form-group col-xs-8">
			<span>*Contraseñas serán autogeneradas y enviadas a los email ingresados.</span>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="row">
			<div class="form-group col-xs-8">	
			@if(!$prepadrinos_data->isEmpty())
				<div class="loader_container" style="display:none;">
					{{ HTML::image('img/loading.gif') }}
				</div>					
				{{ HTML::link('','Aprobar',array('id'=>'submit-aprobar-prepadrinos', 'class'=>'btn btn-primary')) }}
			@endif
			</div>
		</div>
	</div>
@stop