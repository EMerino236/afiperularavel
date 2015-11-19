$( document ).ready(function(){
	
	var aprobacion = $("input[type=hidden][name=aprobacion]").val();
	if(aprobacion==0||aprobacion==2){ 
		$("input[name=gastoreal]").prop('readonly',true);
	}

	var detalle_register = true;
	$("#submit-detalle-proyecto").click(function(e){
		e.preventDefault();
		if(detalle_register){
			detalle_register = false;
			var selected = [];
			//$("input[type=checkbox][name=loans]:checked").each(function(){
			//	selected.push($(this).val());
			//});
			//msj('Error','No es valido');
			var titulo = $("input[name=titulo]").val();
			var presupuesto = $("input[name=presupuesto]").val();
			var gasto_real = $("input[name=gastoreal]").val();			
			var confirmation=1;
			var validTitulo=1;
			var validPresupuesto =1;
			var validGasto = 1;
			var decimal=  /^\d+\.\d{0,2}$/; 
			var tituloerror ="";
			var presupuestoerror ="";
			var gastoerror ="";
			if(presupuesto.length ==0){
				confirmation=0;
				validPresupuesto=0;
			}			
			if(titulo.length<2 || titulo.length>100){
				confirmation=0;
				validTitulo=0;
				tituloerror = 'El campo "Título" se encuentra vacío o no es válido\n';
			}
			if(presupuesto){
				if(!decimal.test(presupuesto)&& isNaN(presupuesto))   
				{   
					validPresupuesto = 0;
					presupuestoerror = 'El campo "Presupuesto" no es válido\n';
				}
			}else { presupuestoerror = 'El campo "Presupuesto" se encuentra vacío\n';}
			if(gasto_real){
				if(!decimal.test(gasto_real)&&isNaN(gasto_real))   
				{   
					validGasto = 0;
					gastoerror = 'El campo "Gasto Real" no es válido';
				}
			}
			if(validTitulo ==0 || validPresupuesto ==0 || validGasto ==0){
				confirmation =0;
				//alert(tituloerror + presupuestoerror + gastoerror)
				BootstrapDialog.alert({
                  title: 'Alerta',
                  message: tituloerror + presupuestoerror + gastoerror, 
                  type: BootstrapDialog.TYPE_INFO
                });
			}
			if(gasto_real=="") gasto_real = undefined;
			if(confirmation){
				var idproyectos = $("input[type=hidden][name=idproyectos]").val();
				$.ajax({
					url: inside_url+'concursos/detalle_register_ajax',
					type: 'POST',
					data: { 'titulo' : titulo ,'presupuesto' : presupuesto, 'gasto_real':gasto_real, 'idproyectos':idproyectos},
					beforeSend: function(){
						$("#submit-detalle-proyecto").addClass("disabled");
						//$("#submit-fase-concurso").hide();
						$(".loader_container").show();
					},
					complete: function(){
						$(".loader_container").hide();
						$("#submit-detalle-proyecto").removeClass("disabled");
						//$("#submit-detalle-proyecto").show();
						detalle_register = true;
					},
					success: function(response){
						if(response.success){
							location.reload();
						}else{
							//alert('La petición no se pudo completar, inténtelo de nuevo.');
							BootstrapDialog.alert({
                              title: 'Alerta',
                              message: 'La petición no se pudo completar, inténtelo de nuevo.', 
                              type: BootstrapDialog.TYPE_INFO
                            });
						}
					},
					error: function(){
						//alert('La petición no se pudo completar, inténtelo de nuevo.');
						BootstrapDialog.alert({
                          title: 'Alerta',
                          message: 'La petición no se pudo completar, inténtelo de nuevo.', 
                          type: BootstrapDialog.TYPE_INFO
                        });
					}
				});
			}else{
				detalle_register = true;
			}
			
		}
	});


	var detalle_delete = true;
	$(".delete-detalle-proyecto").click(function(e){
		e.preventDefault();
		if(detalle_delete){
			detalle_delete = false;
			var selected = [];
			//$("input[type=checkbox][name=loans]:checked").each(function(){
			//	selected.push($(this).val());
			//});
			//msj('Error','No es valido');
			
			var confirmation = 1;
			if(confirmation){
				var detalle_id = $(this).data('detalle');
				$.ajax({
					url: inside_url+'concursos/detalle_delete_ajax',
					type: 'POST',
					data: { 'iddetalle' : detalle_id },
					beforeSend: function(){
						//$("#delete-fase-concurso").addClass("disabled");
						//$("#delete-fase-concurso").hide();
						$(".loader_container").show();
					},
					complete: function(){
						//$(".loader_container").hide();
						//$("#delete-fase-concurso").removeClass("disabled");
						$("#delete-detalle-proyecto").show();
						detalle_delete = true;
					},
					success: function(response){
						if(response.success){
							location.reload();
						}else{
							//alert('La petición no se pudo completar, inténtelo de nuevo.');
							BootstrapDialog.alert({
	                          title: 'Alerta',
	                          message: 'La petición no se pudo completar, inténtelo de nuevo.', 
	                          type: BootstrapDialog.TYPE_INFO
	                        });
						}
					},
					error: function(){
						//alert('La petición no se pudo completar, inténtelo de nuevo.');
						BootstrapDialog.alert({
                          title: 'Alerta',
                          message: 'La petición no se pudo completar, inténtelo de nuevo.', 
                          type: BootstrapDialog.TYPE_INFO
                        });
					}
				});
			}else{
				detalle_delete = true;
			}
			
		}
	});	

	
	//Editar Detalle


	$(".submit-edit-detalle").click(function(e){
		var iddetalle = $(this).data('detalle');
		var titulo = $(this).data('titulo');
		var presupuesto = $(this).data('presupuesto');
		var gasto_real = $(this).data('gastoreal');
		var aprobacion = $(this).data('aprobacion');
		open_detalle_modal(e,iddetalle,titulo, presupuesto,gasto_real,aprobacion);
	});


	var submit_detalle = true;
	$("#submit-edit-detalle-form").click(function(e){
		e.preventDefault();
		if(submit_detalle){
			submit_detalle = false;
			var iddetalle = $("input[type=hidden][name=iddetalle]").val();
			var titulo_detalle = $("input[name=titulo_detalle]").val();
			var presupuesto_detalle = $("input[name=presupuesto_detalle]").val();
			var gasto_real_detalle = $("input[name=gasto_real_detalle]").val();
			var confirmation=1;
			var validTitulo=1;
			var validPresupuesto =1;
			var validGasto = 1;
			var decimal=  /^\d+\.\d{0,2}$/; 
			var tituloerror ="";
			var presupuestoerror ="";
			var gastoerror ="";
			if(presupuesto_detalle.length ==0){
				confirmation=0;
				validPresupuesto=0;
			}			
			if(titulo_detalle.length<2 || titulo.length>100){
				confirmation=0;
				validTitulo=0;
				tituloerror = 'El campo "Título" se encuentra vacío o no es válido\n';
			}
			if(presupuesto_detalle){
				if(!decimal.test(presupuesto_detalle)&& isNaN(presupuesto_detalle))   
				{   
					validPresupuesto = 0;
					presupuestoerror = 'El campo "Presupuesto" no es válido\n';
				}
			}else { presupuestoerror = 'El campo "Presupuesto" se encuentra vacío\n';}
			if(gasto_real_detalle){
				if(!decimal.test(gasto_real_detalle)&& isNaN(gasto_real_detalle))   
				{   
					validGasto = 0;
					gastoerror = 'El campo "Gasto Real" no es válido';
				}
			}
			if(validTitulo ==0 || validPresupuesto ==0 || validGasto ==0){
				confirmation=0;
				//alert(tituloerror + presupuestoerror + gastoerror)
				BootstrapDialog.alert({
                  title: 'Alerta',
                  message: tituloerror + presupuestoerror + gastoerror, 
                  type: BootstrapDialog.TYPE_INFO
                });
			}
			if(gasto_real_detalle == "") gasto_real_detalle =undefined;
			if( confirmation ){
				$.ajax({
					url: inside_url+'concursos/edit_detalle_ajax',
					type: 'POST',
					data: { 'iddetalle' : iddetalle, 'titulo_detalle' : titulo_detalle, 'presupuesto_detalle' : presupuesto_detalle, 'gasto_real_detalle' : gasto_real_detalle },
					beforeSend: function(){
						$("a#submit-edit-detalle-form").hide();
						$(".loader_container").show();
					},
					complete: function(){
						$(".loader_container").hide();
						$("a#submit-edit-detalle-form").show();
						submit_detalle = true;
						$("div#edit-detalle-form").modal('hide');
					},
					success: function(response){
						if(response.success){
							
							//alert('Se guardó correctamente el detalle.');
							BootstrapDialog.alert({
			                  title: 'Mensaje',
			                  message: 'Se guardó correctamente el detalle.', 
			                  type: BootstrapDialog.TYPE_INFO,
			                   callback: function(result){
				                  if(result) {
				                  	location.reload();
				                  }
				              }
			                });
							//location.reload();
						}else{
							//alert('La petición no se pudo completar, inténtelo de nuevo.');
							BootstrapDialog.alert({
	                          title: 'Alerta',
	                          message: 'La petición no se pudo completar, inténtelo de nuevo.', 
	                          type: BootstrapDialog.TYPE_INFO
	                        });
						}
					},
					error: function(){
						//alert('La petición no se pudo completar, inténtelo de nuevo.');
						BootstrapDialog.alert({
                          title: 'Alerta',
                          message: 'La petición no se pudo completar, inténtelo de nuevo.', 
                          type: BootstrapDialog.TYPE_INFO
                        });
					}
				});
			}else{
				submit_detalle = true;				
			}			
		}
	});
	

});

function open_detalle_modal(e,iddetalle,titulo,presupuesto,gasto_real,aprobacion)
{
	e.preventDefault();
	
	$("input[name=titulo_detalle]").val(titulo);
	$("input[name=presupuesto_detalle]").val(presupuesto);
	$("input[name=gasto_real_detalle]").val(gasto_real);
	$("input[name=iddetalle]").val(iddetalle);
	if(aprobacion==1) $("input[name=gasto_real_detalle]").prop('readonly',false);
	$("div#edit-detalle-form").modal('show');
		
	
}

function msj(titulo, cuerpo, funcion, FuncionOpen) {

        if (titulo == "" || titulo == undefined) {
            titulo = "MENSAJE";
        }

        //mostrar mensaje modal
        $("<div title=" + titulo + " style='word-wrap:break-word;display:block;opacity:0;font-family:Arial;font-size:11px;' > " + cuerpo + " </div>").dialog({
            resizable: false,
            modal: true,
            width: 'auto',
            open: function (event, ui) {
                if (typeof FuncionOpen == 'function') {
                    FuncionOpen.call(this, $(this));
                }
            },
            buttons:
            {
                OK: function () {
                    $(this).dialog("close");
                    if (typeof funcion == 'function') {
                        funcion.call(this, $(this));
                    } 
                    else if (funcion != "" && funcion != undefined) { setTimeout(funcion, 0); }
                }
            },
            ////show: { effect: "bounce", duration: 1000 },
            //hide: { effect: "fade", duration: 200 }
        }).animate({ "opacity": "1" }, 0);
    }