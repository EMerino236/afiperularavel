$( document ).ready(function(){

	var eliminar_empresa = true;
	$("#submit-delete").click(function(e){
		e.preventDefault();
		if(eliminar_empresa){
			eliminar_empresa = false;
			BootstrapDialog.confirm({
				title: 'Mensaje de Confirmación',
				message: '¿Está seguro que desea realizar esta acción?', 
				type: BootstrapDialog.TYPE_INFO,
				btnCancelLabel: 'Cancelar', 
            	btnOKLabel: 'Aceptar', 
				callback: function(result){
		            if(result) {
		                document.getElementById("submitDelete").submit();
            		}
            		else{
            			eliminar_empresa = true;
            		}
        		}
			});
		}
	});
});

