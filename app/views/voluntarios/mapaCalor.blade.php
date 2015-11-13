@extends('templates/voluntariosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Mapa de calor</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
	<div class="row">
	    <input id="pac-input" class="controls" type="text" placeholder="Buscar lugares">
		<div id="map-calor"></div>
	</div>
	<script src="{{ asset('js/voluntarios/mapa-calor.js') }}"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places,visualization&callback=initMap" async defer></script>
	
@stop