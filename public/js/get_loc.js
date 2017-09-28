$(document).ready(function(){

		$( ".get_loc" ).change(function() {
  			getLatLong();
		});

		var initMarker = {lat: 19.4326018, lng: -99.13320490000001};
		var map;
		var marker;

		function initialize() {

			var mapOptions = {
				center: initMarker,
				zoom: 11,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};

			map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

			marker = new google.maps.Marker({
				map: map,
				draggable:true,
				position: initMarker
			});

			// Obtenemos la longitud y latitud las asignamos a fields hidden
			google.maps.event.addListener(marker, 'dragend', function (event) {
			    $('.latitude').val(this.getPosition().lat());
		      	$('.longitude').val(this.getPosition().lng());
			});

		}

		google.maps.event.addDomListener(window, 'load', initialize);

		
		// Obtenemos la longitud y latitud de google y las asignamos a fields hidden
		function getLatLong() {
			console.log($('.address').val());
			var addressInput = $('.address').val()+', '+$('.colony').val()+', '+$('.deputation').val()+', '+$('.postal_code').val()+', '+$('.city').val()+', '+$('.country').val()
			console.log(addressInput);
			var geocoder = new google.maps.Geocoder();

			geocoder.geocode({address: addressInput}, function(results, status) {

				if (status == google.maps.GeocoderStatus.OK) {

		      		$('.latitude').val(results[0].geometry.location.lat());
		      		$('.longitude').val(results[0].geometry.location.lng());

		      		var position = results[0].geometry.location;
					
					marker.setPosition(position);

					map.setCenter(position);

					map.setZoom(17);

					
				}
			});

		}

		

		// Escondemos parte la sección de dirección se coincide con la de la compañía
		$('body').on('click', '#company_address', function() {
			if ($(this).is(':checked')) {
				$('.new_address').css('display','none');
    		}else{
    			$('.new_address').css('display','block');
    		}

		});
    		
	});