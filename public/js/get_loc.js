

$( ".get_loc" ).change(function() {
		getLatLong();
});

var map;
var marker;

function initialize() {

	var mapOptions = {
		center: initMarker,
		zoom: 18,
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

      	if(editmode ==true){
      		data = {'latitude':this.getPosition().lat(),'longitude':this.getPosition().lng()}
      		conection('PUT',data,action,true).then(function(data){
				if(data.success == true){
					show_message('success','Muy bien','Los datos fueron cambiados con éxito');
				}
			});
      	}
	});

}

google.maps.event.addDomListener(window, 'load', initialize);


// Obtenemos la longitud y latitud de google y las asignamos a fields hidden
function getLatLong() {
	
	var addressInput = $('.address').val()+', '+$('.colony').val()+', '+$('.deputation').val()+', '+$('.postal_code').val()+', '+$('.city').val()+', '+$('.country').val();
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

	return true;

}

function getLatLongPromise() {
	$('.loader-wrapper').css('display','block');
	var deferred = $.Deferred();      
    var addressInput = $('.address').val()+', '+$('.colony').val()+', '+$('.deputation').val()+', '+$('.postal_code').val()+', '+$('.city').val()+', '+$('.country').val();
	var geocoder = new google.maps.Geocoder();

	geocoder.geocode({address: addressInput}, function(results, status) {  
        console.log(status);
        if (status === 'OK') {

          	$('.latitude').val(results[0].geometry.location.lat());
      		$('.longitude').val(results[0].geometry.location.lng());

      		var position = results[0].geometry.location;
			
			marker.setPosition(position);

			map.setCenter(position);

			map.setZoom(17);

           deferred.resolve(results);
         } else {
           deferred.reject(status);
         }          
     });             

     return deferred.promise();

}



// Escondemos parte la sección de dirección se coincide con la de la compañía

address_company();

$('body').on('click', '#company_address', function() {
	address_company();
});

function address_company(){
	if ($('#company_address').is(':checked')) {
		$('.new_address').css('display','none');
	}else{
		$('.new_address').css('display','block');
	}
}
    		
	