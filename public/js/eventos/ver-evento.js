$( document ).ready(function(){
});

function initMap() {
  var geocoder = new google.maps.Geocoder();
  var myLatlng = {lat: -12.0693537, lng: -77.0800482};
  var zoom = 12;
  var bounds = new google.maps.LatLngBounds();
  var puntos_reunion_markers = new Array();

  if($("input[name=latitud]").val()){
    zoom = 16;
    myLatlng = {lat: parseFloat($("input[name=latitud]").val()), lng: parseFloat($("input[name=longitud]").val())};
  }

  var map = new google.maps.Map(document.getElementById('map-eventos'), {
    zoom: zoom,
    center: myLatlng
  });

  var marker = new google.maps.Marker({
    position: myLatlng,
    map: map,
    title: 'Lugar donde se llevará a cabo el evento.',
    animation:google.maps.Animation.BOUNCE
  });
  bounds.extend(marker.position);

  /*
  google.maps.event.addListener(map, 'click', function(event) {
    marker.setPosition(event.latLng);
    $("input[name=latitud]").val(event.latLng.lat);
    $("input[name=longitud]").val(event.latLng.lng);
    geocoder.geocode({ 'latLng': event.latLng }, function (results, status) {
      if (status == google.maps.GeocoderStatus.OK)
        if (results)
          $("input[name=direccion]").val(results[1].formatted_address);
    });
  });
  */


  $(".puntos-reunion-evento").each(function(){
    if($(this).is(':checked')){
      var punto_reunion = new google.maps.Marker({
        position: {lat: $(this).data('latitud'), lng: $(this).data('longitud')},
        map: map,
        icon: 'http://maps.google.com/intl/en_us/mapfiles/ms/micons/purple.png',
        title: $(this).data('direccion')
      });
      bounds.extend(punto_reunion.position);
      puntos_reunion_markers[$(this).val()] = punto_reunion;
      map.fitBounds(bounds);
    }
  });
}