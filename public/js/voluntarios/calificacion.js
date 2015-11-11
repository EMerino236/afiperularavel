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

});