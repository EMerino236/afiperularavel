@extends('templates/empresasTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Empresas</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	{{ Form::open(array('url'=>'/empresas/search_empresa','method'=>'get' ,'role'=>'form', 'id'=>'search-form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-8">
						{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Razón Social, Representate, E-mail, Sector Empresarial')) }}
					</div>	
					<div class="form-group col-md-4">
						{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}</br>	

    <table class="table">
		<tr class="info">
			<th>Razón Social</th>
			<th>Representante</th>
			<th>E-mail</th>
			<th>Sector Empresarial</th>
			<th>Teléfono de Contacto</th>
		</tr>
		@foreach($empresas_data as $empresa_data)
		<tr class="@if($empresa_data->deleted_at) bg-danger @endif">
			<td>
				<a href="{{URL::to('/empresas/edit_empresa/')}}/{{$empresa_data->idempresas}}">{{$empresa_data->razon_social}}</a>
			</td>
			<td>
				{{$empresa_data->nombre_representante}}
			</td>
			<td>
				{{$empresa_data->email}}
			</td>
			<td>
				{{$empresa_data->sector}}
			</td>
			<td>
				{{$empresa_data->telefono}}
			</td>
		</tr>
		@endforeach
	</table>
@stop