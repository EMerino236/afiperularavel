$( document ).ready(function(){ 

  $("input[name=seleccionar-todos-precolegios]").change(function(){
    if($(this).is(':checked')){
      $(".checkbox-aprobacion").prop('checked',true);
      $(".hidden-aprobacion").val('1');
    }else{
      $(".checkbox-aprobacion").prop('checked',false);
      $(".hidden-aprobacion").val('0');
    }
  });
  
  var aprobar_edit = true;
  $("#submit-create").click(function(e){
    e.preventDefault();
    if(aprobar_edit){
      aprobar_edit = false;
      console.log(1);
      BootstrapDialog.confirm({
        title: 'Mensaje de Confirmación',
        message: '¿Está seguro que desea realizar esta acción?', 
        type: BootstrapDialog.TYPE_INFO,
        btnCancelLabel: 'Cancelar', 
              btnOKLabel: 'Aceptar', 
        callback: function(result){
                if(result) {
                    document.getElementById("form-create").submit();
                }
                else{
                  aprobar_edit = true;
                }
            }
      });
    }
  });

  var aprobar_delete = true;
  $("#submit-delete").click(function(e){
    e.preventDefault();
    if(aprobar_delete){
      aprobar_delete = false;
      BootstrapDialog.confirm({
        title: 'Mensaje de Confirmación',
        message: 'El colegio será eliminado ¿Está seguro que desea realizar esta acción?', 
        type: BootstrapDialog.TYPE_INFO,
        btnCancelLabel: 'Cancelar', 
              btnOKLabel: 'Aceptar', 
        callback: function(result){
                if(result) {
                    document.getElementById("submitDelete").submit();
                }
                else{
                  aprobar_delete = true;
                }
            }
      });
    }
  });

  var aprobar_enable = true;
  $("#submit-enable").click(function(e){
    e.preventDefault();
    if(aprobar_enable){
      aprobar_enable = false;
      BootstrapDialog.confirm({
        title: 'Mensaje de Confirmación',
        message: 'El colegio será habilitado ¿Está seguro que desea realizar esta acción?', 
        type: BootstrapDialog.TYPE_INFO,
        btnCancelLabel: 'Cancelar', 
              btnOKLabel: 'Aceptar', 
        callback: function(result){
                if(result) {
                    document.getElementById("submitEnable").submit();
                }
                else{
                  aprobar_enable= true;
                }
            }
      });
    }
  });


  var aprobar_delete = true;
  $("#submit-delete-ninho").click(function(e){
    e.preventDefault();
    if(aprobar_delete){
      aprobar_delete = false;
      BootstrapDialog.confirm({
        title: 'Mensaje de Confirmación',
        message: 'El niño será eliminado del sistema ¿Está seguro que desea realizar esta acción?', 
        type: BootstrapDialog.TYPE_INFO,
        btnCancelLabel: 'Cancelar', 
              btnOKLabel: 'Aceptar', 
        callback: function(result){
                if(result) {
                    document.getElementById("submitDeleteNinho").submit();
                }
                else{
                  aprobar_delete = true;
                }
            }
      });
    }
  });

  var aprobar_enable = true;
  $("#submit-enable-ninho").click(function(e){
    e.preventDefault();
    if(aprobar_enable){
      aprobar_enable = false;
      BootstrapDialog.confirm({
        title: 'Mensaje de Confirmación',
        message: 'El niño será habilitado nuevamente ¿Está seguro que desea realizar esta acción?', 
        type: BootstrapDialog.TYPE_INFO,
        btnCancelLabel: 'Cancelar', 
              btnOKLabel: 'Aceptar', 
        callback: function(result){
                if(result) {
                    document.getElementById("submitEnableNinho").submit();
                }
                else{
                  aprobar_enable= true;
                }
            }
      });
    }
  });


  var aprobar_precolegios = true;
  $("#submit-aprobar-precolegios").click(function(e){
    e.preventDefault();
    if(aprobar_precolegios){
      aprobar_precolegios = false;
      var selected = [];
      $("input[type=checkbox][name=aprobacion]:checked").each(function(){
        if(!$(this).val().length==0){
          selected.push($(this).val());
        }
      });
      if(selected.length > 0){
        var confirmation = confirm("¿Está seguro que desea aprobar a los precolegios seleccionados?");
        if(confirmation){
          
          $.ajax({
            url: inside_url+'colegios/submit_aprove_precolegio',
            type: 'POST',
            data: { 'selected_id' : selected },
            beforeSend: function(){
            },
            complete: function(){
              aprobar_precolegios = true;
            },
            success: function(response){
              var url = inside_url + "colegios/list_precolegios";
              if(response.success){
                window.location = url;
              }else{
                alert('La petición no se pudo completar, inténtelo de nuevo.');
              }
            },
            error: function(){
              alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
          });
        }else{
          aprobar_precolegios = true;
        }
      }else{
        aprobar_precolegios = true;
        alert('Seleccione alguna casilla.');
      }
    }
  });

});

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
    title: 'Este punto indica la ubicación del colegio.',
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
      $("input[name=latitud]").val(place.geometry.location.lat());
      $("input[name=longitud]").val(place.geometry.location.lng());
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