$( document ).ready(function(){
	
	delete_concurso = true;
	$("#submit-delete-concurso").click(function(e){
		e.preventDefault();
		if(delete_concurso){

			var idconcursos = $("input[type=hidden][name=idconcursos]").val();

			$.ajax({
				url: inside_url+'concursos/get_proyectos_concursos',
				type: 'POST',
				data: { 'idconcursos' : idconcursos },
				beforeSend: function(){
					//$("#submit-delete-concurso").addClass("disabled");
					//$("#submit-delete-concurso").hide();
					$(".loader_container").show();
				},
				complete: function(){
					//$(".loader_container").hide();
					//$("#submit-delete-concurso").removeClass("disabled");
					//$("#submit-delete-concurso").show();
					delete_concurso = true;
				},
				success: function(response){
					if(response.success){
						if(!response.proyectos){
							 BootstrapDialog.confirm({
					            title: 'Mensaje de Confirmación',
					            message: '¿Está seguro que desea eliminar el concurso?', 
					            type: BootstrapDialog.TYPE_INFO,
					            btnCancelLabel: 'Cancelar', 
					            btnOKLabel: 'Aceptar', 
					            callback: function(result){
					            	if(result){
										document.getElementById("submitDeleteConcurso").submit();
									}
								}
							});
						}
						else{
							BootstrapDialog.alert({
		                      title: 'Alerta',
		                      message: 'Existen proyectos asociados al concurso, debe eliminar dichos proyectos para poder eliminar el concurso', 
		                      type: BootstrapDialog.TYPE_INFO
		                    });
						}
					}else{
						//alert('La petición no se pudo completar, inténtelo de nuevo.');
						BootstrapDialog.alert({
	                      title: 'Alerta',
	                      message: 'La petición no se pudo completar, inténtelo de nuevo1.', 
	                      type: BootstrapDialog.TYPE_INFO
	                    });
					}
				},
				error: function(){
					//alert('La petición no se pudo completar, inténtelo de nuevo.');
					BootstrapDialog.alert({
	                  title: 'Alerta',
	                  message: 'La petición no se pudo completar, inténtelo de nuevo2.', 
	                  type: BootstrapDialog.TYPE_INFO
	                });
				}
			});
		}
	});

	//Delete Proyecto

	delete_proyecto = true;
	$("#submit-delete-proyecto").click(function(e){
		e.preventDefault();
		if(delete_proyecto){

			var idproyectos = $("input[type=hidden][name=proyecto_id]").val();

			$.ajax({
				url: inside_url+'concursos/get_proyecto_aprobado',
				type: 'POST',
				data: { 'idproyectos' : idproyectos },
				beforeSend: function(){
					//$("#submit-delete-concurso").addClass("disabled");
					//$("#submit-delete-concurso").hide();
					$(".loader_container").show();
				},
				complete: function(){
					//$(".loader_container").hide();
					//$("#submit-delete-concurso").removeClass("disabled");
					//$("#submit-delete-concurso").show();
					delete_proyecto = true;
				},
				success: function(response){
					if(response.success){
						if(response.aprobacion==0||response.aprobacion==2){
							 BootstrapDialog.confirm({
					            title: 'Mensaje de Confirmación',
					            message: '¿Está seguro que desea eliminar el proyecto?', 
					            type: BootstrapDialog.TYPE_INFO,
					            btnCancelLabel: 'Cancelar', 
					            btnOKLabel: 'Aceptar', 
					            callback: function(result){
					            	if(result){
										document.getElementById("submitDeleteProyecto").submit();
									}
								}
							});
						}
						else{
							BootstrapDialog.alert({
		                      title: 'Alerta',
		                      message: 'El proyecto no se puede eliminar porque se encuentra aprobado', 
		                      type: BootstrapDialog.TYPE_INFO
		                    });
						}
					}else{
						//alert('La petición no se pudo completar, inténtelo de nuevo.');
						BootstrapDialog.alert({
	                      title: 'Alerta',
	                      message: 'La petición no se pudo completar, inténtelo de nuevo1.', 
	                      type: BootstrapDialog.TYPE_INFO
	                    });
					}
				},
				error: function(){
					//alert('La petición no se pudo completar, inténtelo de nuevo.');
					BootstrapDialog.alert({
	                  title: 'Alerta',
	                  message: 'La petición no se pudo completar, inténtelo de nuevo2.', 
	                  type: BootstrapDialog.TYPE_INFO
	                });
				}
			});
		}
	});
});