$( document ).ready(function(){	

	$("input[name=seleccionar-todos-aprobados]").change(function(){
		if($(this).is(':checked')){
			$(".checkbox-aprobacion").prop('checked',true);
			$(".hidden-aprobacion").val('1');
		}else{
			$(".checkbox-aprobacion").prop('checked',false);
			$(".hidden-aprobacion").val('0');
		}
	});
	

	var aprobar_pagos = true;
	$("#submit-aprobar-pagos").click(function(e){
		e.preventDefault();
		if(aprobar_pagos){
			aprobar_pagos = false;
			var selected = [];
			$("input[type=checkbox][name=aprobacion]:checked").each(function(){
				if(!$(this).val().length==0){
					selected.push($(this).val());
				}
			});
			if(selected.length > 0){
				//var confirmation = confirm("¿Está seguro que desea aprobar los pagos seleccionados?");
				var confirmation =0;
	         BootstrapDialog.confirm({
	            title: 'Mensaje de Confirmación',
	            message: '¿Está seguro que desea aprobar los pagos seleccionados?', 
	            type: BootstrapDialog.TYPE_INFO,
	            btnCancelLabel: 'Cancelar', 
	            btnOKLabel: 'Aceptar', 
	            callback: function(result){
					if(result){
						
						$.ajax({
							url: inside_url+'padrinos/aprobar_pago_ajax',
							type: 'POST',
							data: { 'selected_id' : selected },
							beforeSend: function(){
								$("#submit-aprobar-pagos").addClass("disabled");
								$("#submit-aprobar-pagos").hide();
								$(".loader_container").show();
							},
							complete: function(){
								$(".loader_container").hide();
								$("#submit-aprobar-pagos").removeClass("disabled");
								$("#submit-aprobar-pagos").show();
								aprobar_pagos = true;
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
						aprobar_pagos = true;
					}

				}
	        });
			}else{
				aprobar_pagos = true;
				//alert('Seleccione alguna casilla.');
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