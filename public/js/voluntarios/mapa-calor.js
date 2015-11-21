function initMap() {
  var geocoder = new google.maps.Geocoder();
  var myLatlng = {lat: -12.0693537, lng: -77.0800482};
  var zoom = 12;
  if($("input[name=latitud]").val()){
    zoom = 16;
    myLatlng = {lat: parseFloat($("input[name=latitud]").val()), lng: parseFloat($("input[name=longitud]").val())};
  }

  var map = new google.maps.Map(document.getElementById('map-calor'), {
    zoom: zoom,
    center: myLatlng
  });
  var points = [];
  getPoints(points);
console.log(points);
  heatmap = new google.maps.visualization.HeatmapLayer({
    data: getPoints(),
    map: map
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

function getPoints(points) {
    $.ajax({
        url: inside_url+'voluntarios/mapa_calor_ajax',
        type: 'POST',
        beforeSend: function(){
            $("#submit-aprobar-prepadrinos").addClass("disabled");
            $("#submit-aprobar-prepadrinos").hide();
            $(".loader_container").show();
        },
        complete: function(){
            $(".loader_container").hide();
            $("#submit-aprobar-prepadrinos").removeClass("disabled");
            $("#submit-aprobar-prepadrinos").show();
            aprobar_prepadrinos = true;
        },
        success: function(response,points){
            if(response.success){
                //var points = [];
                for(var i=0;i<response.voluntarios.length;i++)
                    if(response.voluntarios[i].latitud != null)
                        points[i] = new google.maps.LatLng(parseFloat(response.voluntarios[i].latitud),parseFloat(response.voluntarios[i].longitud));
                
                return points;
            }else{
                alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
        },
        error: function(){
            alert('La petición no se pudo completar, inténtelo de nuevo.');
        }
    });
}