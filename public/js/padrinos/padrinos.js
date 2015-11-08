$( document ).ready(function(){	

	$("input[name=seleccionar-todos-voluntarios]").change(function(){
		$(".checkbox-voluntarios").prop('checked',$(this).prop("checked"));
	});
	
});