$( document ).ready(function(){
	$(".calificacion").rating({
		'showCaption' : false,
		'showClear' : false,
	});
	$("input[name=asistio]").change(function(){
		if($(this).is(':checked')){
			$(this).next().val('1');
		}else{
			$(this).next().val('0');
		}
	});
	$("input[name=seleccionar-todos-asistio]").change(function(){
		$(".checkbox-asistio").prop('checked',$(this).prop("checked"));
	});
});