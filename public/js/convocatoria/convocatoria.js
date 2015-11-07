$( document ).ready(function(){
	var hoy = new Date();
	var mañana = new Date();
	mañana.setDate(hoy.getDate() +1);
	$("#datetimepicker1").datetimepicker({
		defaultDate: false,
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		minDate: hoy
	});
	$("#datetimepicker2").datetimepicker({
		defaultDate: false,
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		minDate: mañana
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
});