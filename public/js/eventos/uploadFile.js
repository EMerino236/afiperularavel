$( document ).ready(function(){
	var aprobar_postulantes = true;
	$(".eliminar").click(function(e){
		var id = $(this).data("id");
		e.preventDefault();
		if(aprobar_postulantes){
			aprobar_postulantes = false;
			BootstrapDialog.confirm({
				title: 'Mensaje de Confirmación',
				message: '¿Está seguro que desea realizar esta acción?', 
				type: BootstrapDialog.TYPE_INFO,
				btnCancelLabel: 'Cancelar', 
            	btnOKLabel: 'Aceptar', 
				callback: function(result){
		            if(result) {
		                document.getElementById("form-eliminar-"+id).submit();
            		}
            		else{
            			aprobar_postulantes = true;
            		}
        		}
			});
		}
	});

	$(".label_visualizaciones").click(function(e){
		var id = $(this).data("id");
		if($("#table"+id).is(":visible")){
            $("#table"+id).slideToggle();
            $("#label"+id).text("Ver visualizaciones")
        }
        else{
            $("#table"+id).slideToggle();
            $("#label"+id).text("Ocultar visualizaciones")
        }
	});
});