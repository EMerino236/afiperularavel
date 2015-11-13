$( document ).ready(function(){


	$(".calificacion").rating({
		starCaptions: function(val) {
                if (val <= 5) {
                    return val;
                } else {
                    return 'high';
                }
            },
		'showCaption' : true,
		'showClear' : false
	});

	$("#submit_asistencia_excel_button").click(function(e){
		e.preventDefault();
		$("form#submit_asistencia_excel").submit();
	});

});