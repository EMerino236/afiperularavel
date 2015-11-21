$( document ).ready(function(){
	var eliminar_documento_concurso = true;
	$(".eliminar-concurso").click(function(e){
		var id = $(this).data("id");
		e.preventDefault();
		if(eliminar_documento_concurso){
			eliminar_documento_concurso = false;
			BootstrapDialog.confirm({
				title: 'Mensaje de Confirmación',
				message: '¿Está seguro que desea realizar esta acción?', 
				type: BootstrapDialog.TYPE_INFO,
				btnCancelLabel: 'Cancelar', 
            	btnOKLabel: 'Aceptar', 
				callback: function(result){
		            if(result) {
		                document.getElementById("form-eliminar-docconcurso-"+id).submit();
            		}
            		else{
            			eliminar_documento_concurso = true;
            		}
        		}
			});
		}
	});

	var eliminar_documento_proyecto = true;
	$(".eliminar-proyecto").click(function(e){
		var id = $(this).data("id");
		e.preventDefault();
		if(eliminar_documento_proyecto){
			eliminar_documento_proyecto = false;
			BootstrapDialog.confirm({
				title: 'Mensaje de Confirmación',
				message: '¿Está seguro que desea realizar esta acción?', 
				type: BootstrapDialog.TYPE_INFO,
				btnCancelLabel: 'Cancelar', 
            	btnOKLabel: 'Aceptar', 
				callback: function(result){
		            if(result) {
		                document.getElementById("form-eliminar-docproyecto-"+id).submit();
            		}
            		else{
            			eliminar_documento_proyecto = true;
            		}
        		}
			});
		}
	});
});