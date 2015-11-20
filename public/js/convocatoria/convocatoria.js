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
	$("#datetimepicker1_edit").datetimepicker({
		useCurrent: false,
		defaultDate: false,
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		minDate : ayer,
		disabledDates: [ayer]
	});
	$("#datetimepicker2_edit").datetimepicker({
		useCurrent: false,
		defaultDate: false,
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		minDate : hoy,
		disabledDates: [hoy]
	});
	$("input[name=asistencia]").change(function(){
		if($(this).is(':checked')){
			$(this).parent().find(".hidden-asistencia").val('1');
			$(this).parent().find(".checkbox-no-asistencia").prop("checked",false);
			$(this).parent().find(".hidden-no-asistencia").val('0');
			$(this).parent().closest("tr").find(".checkbox-aprobacion").prop("disabled",false);
			if(!$(this).parent().closest("tr").find(".checkbox-no-aprobacion").is(":checked")){
				$(this).parent().closest("tr").find(".checkbox-aprobacion").prop("checked",true);
				$(this).parent().closest("tr").find(".hidden-aprobacion").val('1');
			}
		}else{
			$(this).parent().find(".hidden-asistencia").val('0');
			$(this).parent().closest("tr").find(".checkbox-aprobacion").prop("checked",false);
			$(this).parent().closest("tr").find(".hidden-aprobacion").val('0');
			$(this).parent().closest("tr").find(".checkbox-no-aprobacion").prop("checked",false);
			$(this).parent().closest("tr").find(".hidden-no-aprobacion").val('0');
		}
	});
	$("input[name=no-asistencia]").change(function(){
		if($(this).is(':checked')){
			$(this).parent().find(".hidden-no-asistencia").val('1');
			$(this).parent().find(".checkbox-asistencia").prop("checked",false);
			$(this).parent().find(".hidden-asistencia").val('0');
			$(this).parent().closest("tr").find(".checkbox-aprobacion").prop("checked",false);
			$(this).parent().closest("tr").find(".checkbox-aprobacion").prop("disabled",true);
			$(this).parent().closest("tr").find(".hidden-aprobacion").val('0');
			$(this).parent().closest("tr").find(".checkbox-no-aprobacion").prop("checked",true);
			$(this).parent().closest("tr").find(".hidden-no-aprobacion").val('1');
		}else{
			$(this).parent().find(".hidden-no-asistencia").val('0');
			$(this).parent().closest("tr").find(".checkbox-aprobacion").prop("checked",false);
			$(this).parent().closest("tr").find(".hidden-aprobacion").val('0');
			$(this).parent().closest("tr").find(".checkbox-aprobacion").prop("disabled",false);
			$(this).parent().closest("tr").find(".checkbox-no-aprobacion").prop("checked",false);
			$(this).parent().closest("tr").find(".hidden-no-aprobacion").val('0');
		}
	});
	$("input[name=aprobacion]").change(function(){
		if($(this).is(':checked')){
			$(this).parent().find(".hidden-aprobacion").val('1');
			$(this).parent().find(".checkbox-no-aprobacion").prop("checked",false);
			$(this).parent().find(".hidden-no-aprobacion").val('0');
			$(this).parent().closest("tr").find(".checkbox-asistencia").prop("checked",true);
			$(this).parent().closest("tr").find(".checkbox-asistencia").prop("disabled",true);
			$(this).parent().closest("tr").find(".hidden-asistencia").val('1');
			$(this).parent().closest("tr").find(".checkbox-no-asistencia").prop("checked",false);
			$(this).parent().closest("tr").find(".checkbox-no-asistencia").prop("disabled",true);
			$(this).parent().closest("tr").find(".hidden-no-asistencia").val('0');
		}else{
			$(this).parent().find(".hidden-aprobacion").val('0');
			$(this).parent().closest("tr").find(".checkbox-asistencia").prop("checked",false);
			$(this).parent().closest("tr").find(".checkbox-asistencia").prop("disabled",false);
			$(this).parent().closest("tr").find(".hidden-asistencia").val('0');
			$(this).parent().closest("tr").find(".checkbox-no-asistencia").prop("disabled",false);
			$(this).parent().closest("tr").find(".hidden-no-asistencia").val('0');

		}
	});
	$("input[name=no-aprobacion]").change(function(){
		if($(this).is(':checked')){
			$(this).parent().find(".hidden-no-aprobacion").val('1');
			$(this).parent().find(".checkbox-aprobacion").prop("checked",false);			
			$(this).parent().find(".hidden-aprobacion").val('0');
			$(this).parent().closest("tr").find(".checkbox-asistencia").prop("checked",true);
			$(this).parent().closest("tr").find(".checkbox-asistencia").prop("disabled",false);
			$(this).parent().closest("tr").find(".hidden-asistencia").val('1');
			$(this).parent().closest("tr").find(".checkbox-no-asistencia").prop("disabled",false);
			$(this).parent().closest("tr").find(".hidden-no-asistencia").val('0');
		}else{
			$(this).parent().find(".hidden-no-aprobacion").val('0');
			$(this).parent().find(".checkbox-aprobacion").prop("disabled",false);
			$(this).parent().closest("tr").find(".checkbox-asistencia").prop("checked",false);
			$(this).parent().closest("tr").find(".checkbox-asistencia").prop("disabled",false);
			$(this).parent().closest("tr").find(".hidden-asistencia").val('0');
			$(this).parent().closest("tr").find(".checkbox-no-asistencia").prop("checked",false);
			$(this).parent().closest("tr").find(".checkbox-no-asistencia").prop("disabled",false);
			$(this).parent().closest("tr").find(".hidden-no-asistencia").val('0');
		}
	});
	$("input[name=seleccionar-todos-asistio]").change(function(){
		if($(this).is(':checked')){
			$(".checkbox-asistencia").prop('checked',true);
			$(".hidden-asistencia").val('1');
			$(".checkbox-no-asistencia").prop('checked',false);
			$(".hidden-no-asistencia").val('0');
			$(".checkbox-todos-no-asistio").prop('checked',false);
			if(!$(".checkbox-no-aprobacion").is(":checked")){
				$(".checkbox-aprobacion").prop('checked',true);
				$(".hidden-aprobacion").val('1');
				$(".checkbox-todos-aprobados").prop('checked',true);
			}
		}else{
			$(".checkbox-asistencia").prop('checked',false);
			$(".hidden-asistencia").val('0');
			$(".checkbox-aprobacion").prop('checked',false);
			$(".hidden-aprobacion").val('0');
			$(".checkbox-todos-aprobados").prop('checked',false);
			$(".checkbox-no-aprobacion").prop('checked',false);
			$(".hidden-no-aprobacion").val('0');
			$(".checkbox-todos-no-aprobados").prop('checked',false);
			$(".checkbox-asistencia").prop('disabled',false);
			$(".checkbox-no-asistencia").prop('disabled',false);
			$(".checkbox-aprobacion").prop('disabled',false);
			$(".checkbox-no-aprobacion").prop('disabled',false);
		}
	});
	$("input[name=seleccionar-todos-no-asistio]").change(function(){
		if($(this).is(':checked')){
			$(".checkbox-no-asistencia").prop('checked',true);
			$(".checkbox-no-asistencia").prop('disabled',false);
			$(".hidden-no-asistencia").val('1');
			$(".checkbox-asistencia").prop('checked',false);
			$(".hidden-asistencia").val('0');
			$(".checkbox-todos-asistio").prop('checked',false);
			$(".checkbox-no-aprobacion").prop('checked',true);
			$(".hidden-no-aprobacion").val('1');
			$(".checkbox-todos-no-aprobados").prop('checked',true);
			$(".checkbox-aprobacion").prop('checked',false);
			$(".hidden-aprobacion").val('0');
			$(".checkbox-todos-aprobados").prop('checked',false);
		}else{
			$(".checkbox-no-asistencia").prop('checked',false);
			$(".hidden-no-asistencia").val('0');
			$(".checkbox-aprobacion").prop('checked',false);
			$(".hidden-aprobacion").val('0');
			$(".checkbox-todos-aprobados").prop('checked',false);
			$(".checkbox-no-aprobacion").prop('checked',false);
			$(".hidden-no-aprobacion").val('0');
			$(".checkbox-todos-no-aprobados").prop('checked',false);
			$(".checkbox-asistencia").prop('disabled',false);
			$(".checkbox-no-asistencia").prop('disabled',false);
			$(".checkbox-aprobacion").prop('disabled',false);
			$(".checkbox-no-aprobacion").prop('disabled',false);
		}
	});
	$("input[name=seleccionar-todos-aprobados]").change(function(){
		if($(this).is(':checked')){
			$(".checkbox-aprobacion").prop('checked',true);
			$(".checkbox-aprobacion").prop('disabled',false);
			$(".hidden-aprobacion").val('1');
			$(".checkbox-no-aprobacion").prop('checked',false);
			$(".hidden-no-aprobacion").val('0');
			$(".checkbox-todos-no-aprobados").prop('checked',false);
			$(".checkbox-asistencia").prop('checked',true);
			$(".hidden-asistencia").val('1');
			$(".checkbox-todos-asistio").prop('checked',true);
		}else{
			$(".checkbox-aprobacion").prop('checked',false);
			$(".hidden-aprobacion").val('0');
			$(".checkbox-asistencia").prop('checked',false);
			$(".hidden-asistencia").val('0');
			$(".checkbox-todos-asistio").prop('checked',false);
			$(".checkbox-no-asistencia").prop('checked',false);
			$(".hidden-no-asistencia").val('0');
			$(".checkbox-todos-no-asistio").prop('checked',false);
			$(".checkbox-asistencia").prop('disabled',false);
			$(".checkbox-no-asistencia").prop('disabled',false);
			$(".checkbox-aprobacion").prop('disabled',false);
			$(".checkbox-no-aprobacion").prop('disabled',false);
		}
	});
	$("input[name=seleccionar-todos-no-aprobados]").change(function(){
		if($(this).is(':checked')){
			$(".checkbox-no-aprobacion").prop('checked',true);
			$(".hidden-no-aprobacion").val('1');
			$(".checkbox-aprobacion").prop('checked',false);
			$(".hidden-aprobacion").val('0');
			$(".checkbox-todos-aprobados").prop('checked',false);
			$(".checkbox-asistencia").prop('checked',true);
			$(".hidden-asistencia").val('1');
			$(".checkbox-todos-asistio").prop('checked',true);
		}else{
			$(".checkbox-no-aprobacion").prop('checked',false);
			$(".hidden-no-aprobacion").val('0');
			$(".checkbox-asistencia").prop('checked',false);
			$(".hidden-asistencia").val('0');
			$(".checkbox-todos-asistio").prop('checked',false);
			$(".checkbox-no-asistencia").prop('checked',false);
			$(".hidden-no-asistencia").val('0');
			$(".checkbox-todos-no-asistio").prop('checked',false);
			$(".checkbox-asistencia").prop('disabled',false);
			$(".checkbox-no-asistencia").prop('disabled',false);
			$(".checkbox-aprobacion").prop('disabled',false);
			$(".checkbox-no-aprobacion").prop('disabled',false);
		}
	});

	var aprobar_postulantes = true;
	$("#submit-aprobacion-postulantes").click(function(e){
		var cant = $("#cantidad_postulantes").val();
		if(cant>=1){
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
			                document.getElementById("submitAprobacion").submit();
	            		}
	            		else{
	            			aprobar_postulantes = true;
	            		}
	        		}
				});
			}
		}
		else{
			 BootstrapDialog.alert({
			 	title: 'Mensaje de Información',
			 	message:'No hay postulantes por aprobar en esta fase de postulación'});
			 return false;
		}
	});
});

function goBack() {
    window.history.back();
}
