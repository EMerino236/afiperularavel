@extends('templates/eventosTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Puntos de Reunión</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
	<div id="map-puntos-reunion"></div>
<script src="{{ asset('js/eventos/puntos-reunion.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
@stop