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

	var hoy = new Date();
	$(".fecha-log").datetimepicker({
		defaultDate: false,
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		maxDate: hoy
	});

});