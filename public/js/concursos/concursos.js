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
});