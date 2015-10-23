$( document ).ready(function(){
	$.ajax({
		url: inside_url+'eventos/mis_eventos_ajax',
		type: 'POST',
		//data: {},
		beforeSend: function(){
		},
		complete: function(){
		},
		success: function(response){
			var eventos = {};
			var count_eventos = {}
			for(var i=0;i<response.eventos.length;i++){
				var ev = response.eventos[i];
				if(count_eventos[ev]){
					count_eventos[ev] = count_eventos[ev] + 1;
				}else{
					count_eventos[ev] = 1;
				}
				eventos[ev] = {
					"number": count_eventos[ev], 
      				"badgeClass": "badge-warning", 
					"url" : inside_url+'eventos/mis_eventos/'+ev,
				};
			}
			initialize_calendar(eventos);
		},
		error: function(){
		}
	});
});


function initialize_calendar(eventos){
	$('.responsive-calendar').responsiveCalendar({
    	translateMonths:{0:'Enero',1:'Febrero',2:'Marzo',3:'Abril',4:'Mayo',5:'Junio',6:'Julio',7:'Agosto',8:'Septiembre',9:'Octubre',10:'Noviembre',11:'Diciembre'},
    	events: eventos,
    });
}