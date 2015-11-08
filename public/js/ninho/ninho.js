$( document ).ready(function(){
	var hoy = new Date();
	$("#datetimepicker1").datetimepicker({
		defaultDate: false,
		format: 'YYYY-MM-DD',
		ignoreReadonly: true,
		maxDate: hoy
	});
});