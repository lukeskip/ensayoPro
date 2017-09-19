
$(document).foundation();
$(document).ready(function(){

	// sweetAlert("Así es...", "...aún estamos en fase beta!, si tienes algún problema repórtalo al Rey contacto@reydecibel.com.mx", "warning");
	owl = $(".owl-carousel");
	owl.owlCarousel({
	 	'items'		: 1,
	 	'mouseDrag'	: false,
	 	'touchDrag'	: false,
	 });

	owl.on('changed.owl.carousel', function(event) {
		var current  = event.item.index+1;
    	// var slide_id = $(event.target).find(".owl-item").eq(current).find("div:first-child").data("id");
    	$( ".steps .step" ).each(function( index ) {
  			$(this).removeClass("active");
		});
		$(".step_"+current).addClass("active");
    	console.log(current);
	})
	
	$('body').on('click', '.next', function() {
		owl.trigger('next.owl.carousel');
	});

	$('textarea').keyup(updateCount);
	$('textarea').keydown(updateCount);

	function updateCount() {
		var limit 	= $(this).parent().find('.counter').data("limit")
	    var cs 		= $(this).val().length;

	   	$(this).parent().find('.counter').text(cs+" / "+limit);
	}
	

});





