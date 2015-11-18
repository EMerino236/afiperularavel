$( document ).ready(function(){
	var hoy = new Date();
	var mañana = new Date();
	var ayer = new Date();
	mañana.setDate(hoy.getDate() +1);
	ayer.setDate(hoy.getDate() -1);
	$("#datetimepicker1").datetimepicker({
		useCurrent: false,
		defaultDate: false,
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		minDate : ayer,
		disabledDates: [ayer]
	});
	$("#datetimepicker2").datetimepicker({
		useCurrent: false,
		defaultDate: false,
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		minDate : hoy,
		disabledDates: [hoy]
	});
	$("input[name=asistencia]").change(function(){
		if($(this).is(':checked')){
			$(this).next().val('1');
		}else{
			$(this).next().val('0');
		}
	});
	$("input[name=aprobacion]").change(function(){
		if($(this).is(':checked')){
			$(this).next().val('1');
		}else{
			$(this).next().val('0');
		}
	});
	$("input[name=seleccionar-todos-asistio]").change(function(){
		if($(this).is(':checked')){
			$(".checkbox-asistencia").prop('checked',true);
			$(".hidden-asistencia").val('1');
		}else{
			$(".checkbox-asistencia").prop('checked',false);
			$(".hidden-asistencia").val('0');
		}
	});
	$("input[name=seleccionar-todos-aprobados]").change(function(){
		if($(this).is(':checked')){
			$(".checkbox-aprobacion").prop('checked',true);
			$(".hidden-aprobacion").val('1');
		}else{
			$(".checkbox-aprobacion").prop('checked',false);
			$(".hidden-aprobacion").val('0');
		}
	});

	var aprobar_postulantes = true;
	$("#submit-aprobacion-postulantes").click(function(e){
		e.preventDefault();
		if(aprobar_postulantes){
			aprobar_postulantes = false;
			BootstrapDialog.confirm({
				title: 'Mensaje de Confirmación',
				message: 'Los postulantes seleccionados serás aprobados y el resto serán desaprobados. ¿Está seguro que desea realizar esta acción?', 
				type: BootstrapDialog.TYPE_INFO,
				btnCancelLabel: 'Cancelar', 
            	btnOKLabel: 'Aceptar', 
				callback: function(result){
		            if(result) {
		                document.getElementById("submitAprobacion").submit();
            		}
            		else{
            			aprobar_postulantes = true;
            		}
        		}
			});
		}
	});

});

function goBack() {
    window.history.back();
}
