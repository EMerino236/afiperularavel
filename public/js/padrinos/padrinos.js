$( document ).ready(function(){	

	var hoy = new Date();
	$(".fecha-busqueda").datetimepicker({
	    defaultDate: false,
	    format: 'DD-MM-YYYY',
	    ignoreReadonly: true,
	    maxDate: hoy
	});


	$("input[name=seleccionar-todos-prepadrinos]").change(function(){
		if($(this).is(':checked')){
			$(".checkbox-aprobacion").prop('checked',true);
			$(".hidden-aprobacion").val('1');
		}else{
			$(".checkbox-aprobacion").prop('checked',false);
			$(".hidden-aprobacion").val('0');
		}
	});
	
	var aprobar_prepadrinos = true;
	$("#submit-aprobar-prepadrinos").click(function(e){
		e.preventDefault();
		if(aprobar_prepadrinos){
			aprobar_prepadrinos = false;
			var selected = [];
			$("input[type=checkbox][name=aprobacion]:checked").each(function(){
				if(!$(this).val().length==0){
					selected.push($(this).val());
				}
			});
			if(selected.length > 0){
				//var confirmation = confirm("¿Está seguro que desea aprobar a los prepadrinos seleccionados?");
				BootstrapDialog.confirm({
	            title: 'Mensaje de Confirmación',
	            message: '¿Está seguro que desea aprobar los pagos seleccionados?', 
	            type: BootstrapDialog.TYPE_INFO,
	            btnCancelLabel: 'Cancelar', 
	            btnOKLabel: 'Aceptar', 
	            callback: function(result){
					if(result){
				//if(confirmation){
					
						$.ajax({
							url: inside_url+'padrinos/aprobar_prepadrino_ajax',
							type: 'POST',
							data: { 'selected_id' : selected },
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
							success: function(response){
								if(response.success){
									location.reload();
								}else{
									BootstrapDialog.alert({
		                              title: 'Alerta',
		                              message: 'La petición no se pudo completar, inténtelo de nuevo.', 
		                              type: BootstrapDialog.TYPE_INFO
		                            });
								}
							},
							error: function(){
								BootstrapDialog.alert({
		                              title: 'Alerta',
		                              message: 'La petición no se pudo completar, inténtelo de nuevo.', 
		                              type: BootstrapDialog.TYPE_INFO
		                            });
							}
						});
					}else{
						aprobar_prepadrinos = true;
					}
				}
			});
			}else{
				aprobar_prepadrinos = true;
				BootstrapDialog.alert({          
		          size: BootstrapDialog.SIZE_SMALL,
		          title: 'Alerta',
		          message: 'Seleccione alguna casilla', 
		          type: BootstrapDialog.TYPE_INFO
		        });
			}
		}
	});

});