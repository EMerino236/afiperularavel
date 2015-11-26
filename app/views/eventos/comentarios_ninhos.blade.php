@extends('templates/eventosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Registro de comentarios sobre los niños</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Comentarios</h3>
		</div>
		<div class="panel-body">
			@if($comentarios->isEmpty())
				<div class="alert alert-danger">Aún no se han registrado comentarios.</div>
			@else	
				<table class="table">
					<tr class="info">
						<th>Voluntario</th>
						<th>Niño</th>
						<th>Calificación</th>
						<th>Comentario</th>
						<th>Fecha de registro de comentario</th>
					</tr>
					@foreach($comentarios as $comentario)
					<tr>
						<td>
							{{$comentario->nombres_persona}} {{$comentario->apellido_pat_persona}} {{$comentario->apellido_mat_persona}}
						</td>
						<td>
							{{$comentario->nombres_ninho}} {{$comentario->apellido_pat_ninho}} {{$comentario->apellido_mat_ninho}}
						</td>
						<td>
							@if($comentario->calificacion == 1)
								<img src="{{ asset('img') }}/feliz.jpg" width="40" title="Feliz"/>
							@else
								<img src="{{ asset('img') }}/triste.jpg" width="40" title="Triste"/>
							@endif
						</td>
						<td>
							{{$comentario->comentario}}
						</td>
						<td>
							{{date('d/m/Y - H:i',strtotime($comentario->created_at))}}
						</td>
					</tr>
					@endforeach
				</table>
			@endif
		</div>
	</div>

    <script src="{{ asset('js/fileinput.min.js') }}"></script>
    <script src="{{ asset('js/eventos/uploadFile.js') }}"></script>
@stop