$( document ).ready(function(){
	

	var date = new Date();
    date.setDate(date.getDate());
    date.setHours(0,0,0,0);
    var hoy = new Date();
    var ayer = new Date();
  	ayer.setDate(hoy.getDate()-1);
	$("#datetimepicker1").datetimepicker({			
		useCurrent: false,
	    defaultDate: false,
	    format: 'DD-MM-YYYY',
	    ignoreReadonly: true,
	    minDate: ayer,
	    disabledDates: [ayer]
	});


	var fase_register = true;
	$("#submit-fase-concurso").click(function(e){
		e.preventDefault();
		if(fase_register){
			fase_register = false;
			var selected = [];
			//$("input[type=checkbox][name=loans]:checked").each(function(){
			//	selected.push($(this).val());
			//});
			var titulo = $("input[name=titulo]").val();
			var descripcion = $("#descripcion").val();
			var fecha_limite = $("input[name=fecha_limite]").val();
			var dateFecha = moment(fecha_limite,"DD-MM-YYYY");
			var confirmation=1;
			var validTitulo=1;
			var validFecha =1;
			if(fecha_limite.length ==0){
				confirmation=0;
				validFecha=0;
			}			
			if(titulo.length<2 || titulo.length>100){
				confirmation=0;
				validTitulo=0;
			}
			if(dateFecha.toDate() < date){
				confirmation=0;
				validFecha=0;
			}
			if(validTitulo ==0 && validFecha==0){
				alert('El campo "Título" se encuentra vacío o no es válido\n' +
					   'El campo "Fecha Límite" se encuentra vacío o no es válido');	
			}			
			if(validTitulo ==0 && validFecha==1){
				alert('El campo "Título" se encuentra vacío o no es válido\n');
			}						
			if(validTitulo ==1 && validFecha==0){
				alert('El campo "Fecha Límite" se encuentra vacío o no es válido');
			}					
			if(confirmation){
				var idconcursos = $("input[type=hidden][name=idconcursos]").val();
				$.ajax({
					url: inside_url+'concursos/fase_register_ajax',
					type: 'POST',
					data: { 'titulo' : titulo ,'descripcion' : descripcion, 'fecha_limite':fecha_limite, 'idconcursos':idconcursos},
					beforeSend: function(){
						//$("#submit-fase-concurso").addClass("disabled");
						//$("#submit-fase-concurso").hide();
						$(".loader_container").show();
					},
					complete: function(){
						//$(".loader_container").hide();
						//$("#submit-fase-concurso").removeClass("disabled");
						$("#submit-fase-concurso").show();
						fase_register = true;
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
				fase_register = true;
			}
			
		}
	});


	var fase_delete = true;
	$(".delete-fase-concurso").click(function(e){
		e.preventDefault();
		if(fase_delete){
			fase_delete = false;
			var selected = [];
			//$("input[type=checkbox][name=loans]:checked").each(function(){
			//	selected.push($(this).val());
			//});
			
			
			var confirmation = 1;
			if(confirmation){
				var fase_id = $(this).data('fase');
				$.ajax({
					url: inside_url+'concursos/fase_delete_ajax',
					type: 'POST',
					data: { 'idfase' : fase_id },
					beforeSend: function(){
						//$("#delete-fase-concurso").addClass("disabled");
						//$("#delete-fase-concurso").hide();
						$(".loader_container").show();
					},
					complete: function(){
						//$(".loader_container").hide();
						//$("#delete-fase-concurso").removeClass("disabled");
						$("#delete-fase-concurso").show();
						fase_delete = true;
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
				fase_delete = true;
			}
			
		}
	});


});