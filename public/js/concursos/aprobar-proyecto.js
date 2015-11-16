$( document ).ready(function(){


	$("input:checkbox").on('click', function() {
	  var $box = $(this);
	  if ($box.is(":checked")) {
	    var group = "input:checkbox[name=aprobacion]";
	    $(group).prop("checked", false);
	    $box.prop("checked", true);
	  } else {
	    $box.prop("checked", false);
	  }
	});


	var aprobar_proyecto = true;
  $("#submit-aprobar-proyecto").click(function(e){
    e.preventDefault();
    if(aprobar_proyecto){
      aprobar_proyecto = false;
      var selected = [];
      $("input[type=checkbox][name=aprobacion]:checked").each(function(){
        if(!$(this).val().length==0){
          selected.push($(this).val());
        }
      });
      var idconcursos = $("input[type=hidden][name=idconcursos]").val();
      if(selected.length > 0){
        var confirmation = confirm("¿Está seguro que desea aprobar el proyecto seleccionado?");
        if(confirmation){
          
          $.ajax({
            url: inside_url+'concursos/submit_aprove_proyecto',
            type: 'POST',
            data: { 'selected_id' : selected,'idconcursos':idconcursos},
            beforeSend: function(){
            	$("#dsubmit-aprobar-proyecto").addClass("disabled");
				$("#submit-aprobar-proyecto").hide();
            	$(".loader_container").show();
            },
            complete: function(){
              $(".loader_container").hide();
              $("#submit-aprobar-proyecto").removeClass("disabled");
			  $("#submit-aprobar-proyecto").show();	
              aprobar_proyecto = true;
            },
            success: function(response){
              if(response.success){
               	location.reload();
              }else{
                alert('La petición no se pudo completar, inténtelo de nuevo.');
              }
            },
            error: function(){
              alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
          });
        }else{
          aprobar_proyecto = true;
        }
      }else{
        aprobar_proyecto = true;
        alert('Seleccione alguna casilla.');
      }
    }
  });

	
});