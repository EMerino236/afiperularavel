function initMap() {
  var geocoder = new google.maps.Geocoder();
  var myLatlng = {lat: -12.0693537, lng: -77.0800482};
  var zoom = 12;
  var bounds = new google.maps.LatLngBounds();

  if($("input[name=latitud]").val()){
    zoom = 16;
    myLatlng = {lat: parseFloat($("input[name=latitud]").val()), lng: parseFloat($("input[name=longitud]").val())};
  }

  var map = new google.maps.Map(document.getElementById('map-puntos-reunion'), {
    zoom: zoom,
    center: myLatlng
  });

  $.ajax({
    url: inside_url+'eventos/list_puntos_reunion_ajax',
    type: 'GET',
    beforeSend: function(){
    },
    complete: function(){
    },
    success: function(response){
      var marker;
      var infowindow;
      if(response.puntos_reunion.length > 0){
        for(var i=0;i<response.puntos_reunion.length;i++){
          marker = new google.maps.Marker({
            position: {lat:parseFloat(response.puntos_reunion[i].latitud),lng:parseFloat(response.puntos_reunion[i].longitud)},
            map: map,
            icon: 'http://maps.google.com/intl/en_us/mapfiles/ms/micons/purple.png',
            title: String(response.puntos_reunion[i].idpuntos_reunion),
            content: response.puntos_reunion[i].direccion,
          });
          infowindow = new google.maps.InfoWindow();
          google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent('<strong>Dirección:</strong><br><span>'+this.content+'</span><br><a href="" onclick="eliminar_punto_reunion(event,'+this.title+')">Eliminar</a>');
            infowindow.open(marker.get('map'), this);
          });
          bounds.extend(marker.position);
        }
        map.fitBounds(bounds);
      }else{
        $("h3.page-header").parent().append('<span class="campos-obligatorios">No tienes puntos de reunión registrados.</span>');
      }
    },
    error: function(){
    }
  });


  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };
      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
  // [END region_getplaces]
}

function eliminar_punto_reunion(e,id){
  e.preventDefault();
  if(confirm('¿Está seguro de eliminar el punto seleccionado?')){
    $.ajax({
      url: inside_url+'eventos/submit_disable_puntos_reunion_ajax',
      type: 'POST',
      data: { 'idpuntos_reunion' : id },
      beforeSend: function(){
      },
      complete: function(){
      },
      success: function(response){
        if(response.success){
          alert('Se eliminó correctamente el punto de reunión');
          location.reload();
        }else{
          alert('No se pudo eliminar el punto de reunión debido a que hay eventos asociados a este');
        }
      },
      error: function(){
          alert('Ocurrió un error');
      }
    });
  }else{

  }
}