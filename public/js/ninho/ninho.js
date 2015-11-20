$( document ).ready(function(){
	var ayer = new Date();
	ayer.setDate(new Date().getDate() -1);
	$("#datetimepicker1").datetimepicker({
		useCurrent: false,
		defaultDate: false,
		format: 'DD-MM-YYYY',
		ignoreReadonly: true,
		maxDate: ayer
	});
});

