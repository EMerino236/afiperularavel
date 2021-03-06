@extends('templates/colegiosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Colegios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	{{ Form::open(array('url'=>'/colegios/search_colegio','method'=>'get' ,'role'=>'form', 'id'=>'search-form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Nombre, Dirección')) }}
				</div>	
				<div class="col-md-2">
					{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
				</div>	
			</div>
		</div>
	{{ Form::close() }}</br>	

    <table class="table">
		<tr class="info">
			<th>@if ($sortby == 'nombre' && $order == 'asc') {{
                        link_to_action(
                            'ColegiosController@search_colegio',
                            'Nombre',
                            array(
                            	'search' => $search,
                                'sortby' => 'nombre',
                                'order' => 'desc'
                            )
                        )
                    }}
                    @else {{              
                    	link_to_action(
                            'ColegiosController@search_colegio',
                            'Nombre',
                            array(
                            	'search' => $search,
                                'sortby' => 'nombre',
                                'order' => 'asc'
                            )
                        )
                    }}
                    @endif</th>
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