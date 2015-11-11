$( document ).ready(function(){
	$(".calificacion").rating({
		'showCaption' : false,
		'showClear' : false,
	});
	$("input[name=asistio]").change(function(){
		var dataid = $(this).data("id");
		if($(this).is(':checked')){
			$(this).next().val('1');
			$("tr."+dataid+" .star-rating").show();
			$("textarea."+dataid).prop('disabled', false);
		}else{
			$(this).next().val('0');
			$("tr."+dataid+" .star-rating").hide();
			$("textarea."+dataid).prop('disabled', true);
			$("textarea."+dataid).val("");
		}
	});
	$("input[name=seleccionar-todos-asistio]").change(function(){
		if($(this).is(':checked')){
			$(".checkbox-asistio").prop('checked',true);
			$(".hidden-asistencia").val('1');
		}else{
			$(".checkbox-asistio").prop('checked',false);
			$(".hidden-asistencia").val('0');
		}
	});
});