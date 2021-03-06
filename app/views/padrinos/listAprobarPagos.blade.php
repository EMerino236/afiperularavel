@extends('templates/padrinosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Pagos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
	    

	<table class="table">
		<tr class="info">
			<th>Número Comprobante</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>Monto</th>
			<th>Fecha de Pago</th>
			<th>Aprobar <input type="checkbox" name="seleccionar-todos-aprobados" value="0"></th>
		</tr>
		@foreach($pagos_data as $pago_data)
			@if($pago_data->num_comprobante!==null)
			<tr class="@if($pago_data->deleted_at) bg-danger @endif">
				<td>					
					<a href="{{URL::to('/padrinos/view_pago/')}}/{{$pago_data->idcalendario_pagos}}">{{$pago_data->num_comprobante}}</a>					
				</td>
				<td>
					{{$pago_data->nombres}}
				</td>
				<td>
					{{$pago_data->apellido_pat}} {{$pago_data->apellido_mat}}
				</td>
				<td>
					{{$pago_data->monto}}
				</td>
				<td>
					{{date('d/m/Y',strtotime($pago_data->fecha_pago))}}
				</td>
				<td class="text-center" style="vertical-align:middle">
						@if($pago_data->aprobacion === null)
							<input type="checkbox"  name="aprobacion" class="checkbox-aprobacion" value="{{$pago_data->idcalendario_pagos}}" @if($pago_data->aprobacion === 1) checked @endif>
							{{ Form::hidden('aprobaciones[]', $pago_data->aprobacion,array('class'=>'hidden-aprobacion')) }}
						@endif
						@if($pago_data->aprobacion === 0)
							<input hidden type="checkbox" name="aprobacion" class="checkbox-aprobacion" value="">
							{{ Form::hidden('aprobaciones[]', -1) }}
							Rechazado
						@endif
						@if($pago_data->aprobacion === 1)
							<input hidden type="checkbox" name="aprobacion" class="checkbox-aprobacion" value="">
							{{ Form::hidden('aprobaciones[]', -1) }}
							Aprobado
						@endif
						
				</td>
			</tr>
			@endif
		@endforeach
	</table>
	<div class="row">
		<div class="form-group col-xs-8">	
			@if($pagos_data)
				@if(!$pagos_data->isEmpty())
					<div class="loader_container" style="display:none;">
						{{ HTML::image('img/loading.gif') }}
					</div>				
					{{ HTML::link('','Aprobar Pagos',array('id'=>'submit-aprobar-pagos', 'class'=>'btn btn-primary')) }}			
				@endif
			@endif
		</div>
	</div>
	{{ $pagos_data->links() }}
	
@stop