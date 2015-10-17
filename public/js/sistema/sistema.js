$( document ).ready(function(){
	$(".convocatorias-parent").click(function(){
		if($(this).is(':checked')){
			$('.convocatorias-child').prop('checked', true);
		}else{
			$('.convocatorias-child').prop('checked', false);
		}
	});
	$(".eventos-parent").click(function(){
		if($(this).is(':checked')){
			$('.eventos-child').prop('checked', true);
		}else{
			$('.eventos-child').prop('checked', false);
		}
	});
	$(".voluntarios-parent").click(function(){
		if($(this).is(':checked')){
			$('.voluntarios-child').prop('checked', true);
		}else{
			$('.voluntarios-child').prop('checked', false);
		}
	});
	$(".padrinos-parent").click(function(){
		if($(this).is(':checked')){
			$('.padrinos-child').prop('checked', true);
		}else{
			$('.padrinos-child').prop('checked', false);
		}
	});
	$(".concursos-parent").click(function(){
		if($(this).is(':checked')){
			$('.concursos-child').prop('checked', true);
		}else{
			$('.concursos-child').prop('checked', false);
		}
	});
	$(".colegios-parent").click(function(){
		if($(this).is(':checked')){
			$('.colegios-child').prop('checked', true);
		}else{
			$('.colegios-child').prop('checked', false);
		}
	});
	$(".usuarios-parent").click(function(){
		if($(this).is(':checked')){
			$('.usuarios-child').prop('checked', true);
		}else{
			$('.usuarios-child').prop('checked', false);
		}
	});
	$(".sistema-parent").click(function(){
		if($(this).is(':checked')){
			$('.sistema-child').prop('checked', true);
		}else{
			$('.sistema-child').prop('checked', false);
		}
	});

	$(".convocatorias-child").click(function(){
		if($(this).is(':checked'))
			$('.convocatorias-parent').prop('checked', true);
	});
	$(".eventos-child").click(function(){
		if($(this).is(':checked'))
			$('.eventos-parent').prop('checked', true);
	});
	$(".voluntarios-child").click(function(){
		if($(this).is(':checked'))
			$('.voluntarios-parent').prop('checked', true);
	});
	$(".padrinos-child").click(function(){
		if($(this).is(':checked'))
			$('.padrinos-parent').prop('checked', true);
	});
	$(".concursos-child").click(function(){
		if($(this).is(':checked'))
			$('.concursos-parent').prop('checked', true);
	});
	$(".colegios-child").click(function(){
		if($(this).is(':checked'))
			$('.colegios-parent').prop('checked', true);
	});
	$(".usuarios-child").click(function(){
		if($(this).is(':checked'))
			$('.usuarios-parent').prop('checked', true);
	});
	$(".sistema-child").click(function(){
		if($(this).is(':checked'))
			$('.sistema-parent').prop('checked', true);
	});
});