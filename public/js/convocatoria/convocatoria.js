$( document ).ready(function(){
	$("#datetimepicker1").datetimepicker({
		defaultDate: false,
		format: 'DD-MM-YYYY',
		ignoreReadonly: true
	});
	$("#datetimepicker2").datetimepicker({
		defaultDate: false,
		format: 'DD-MM-YYYY',
		ignoreReadonly: true
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
		$(".checkbox-asistencia").prop('checked',$(this).prop("checked"));
	});
	$("input[name=seleccionar-todos-aprobados]").change(function(){
		$(".checkbox-aprobacion").prop('checked',$(this).prop("checked"));
	});
});