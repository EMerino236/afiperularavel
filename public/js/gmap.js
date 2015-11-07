function initMap() {
  var geocoder = new google.maps.Geocoder();
  var myLatlng = {lat: -12.0693537, lng: -77.0800482};
  var zoom = 12;
  if($("input[name=latitud]").val()){
    zoom = 16;
    myLatlng = {lat: parseFloat($("input[name=latitud]").val()), lng: parseFloat($("input[name=longitud]").val())};
  }

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: zoom,
    center: myLatlng
  });

  var marker = new google.maps.Marker({
    position: myLatlng,
    map: map,
    title: 'Este punto indica tu vivienda.',
    animation:google.maps.Animation.BOUNCE
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
    markers = [];

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

      // Create a marker for each place.
      marker.setPosition(place.geometry.location);
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

  google.maps.event.addListener(map, 'click', function(event) {
    marker.setPosition(event.latLng);
    $("input[name=latitud]").val(event.latLng.lat);
    $("input[name=longitud]").val(event.latLng.lng);
    /*
    geocoder.geocode({ 'latLng': event.latLng }, function (results, status) {
      if (status == google.maps.GeocoderStatus.OK)
        if (results)
          $("input[name=direccion]").val(results[1].formatted_address);
    });
    */
  });
}