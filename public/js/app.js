
$(document).foundation();
$(document).ready(function(){
	

	// clonamos el markup que agrega un input más de miembro.
	$('body').on('click', '.add.member', function() {
		$('.input_band_member_clone').clone().removeClass( "input_band_member_clone" ).appendTo('#paste');
	});

	// al click ejecutamos register_band
	$('body').on('click', '.register_band', function() {
		register_band ();
	});

	// función que maneja el registro de la banda del usuario
	function register_band (){
		// declaramos nuestro array
		var members = [];

		// Guardamos la información de los members en el array declarado
		$( "input.member" ).each(function( index ) {
			email = $(this).val();
			if(email !=""){
				members.push({
					'name'  :'noche',
					'email' : email 
				});
			}	
		});

		// armamos una variable que utilizaremos en nuestro pool de conexiones
		data = $("#band_data").serialize()+"&members="+JSON.stringify(members);

		conection('POST',data,'/bandas');
	}
	
});


// controlador de mensajes
function show_message(type,title,message,link,color = '#CF2832'){

	swal({
	  title: title,
	  text: message,
	  type: type,
	  confirmButtonText: 'OK',
	  confirmButtonColor: color
	}).then(function (result) {
		if(link){
			window.location.replace(link);	
		}
		
	});
}


// pool de conexiones
function conection(method,fields,link,redirect){
	$.ajax({
		header:{
			'Content-Type':'application/x-www-form-urlencoded',
			'Accept':'application/json'
		},
		method:method,
	  url: APP_URL+link,
	  dataType:'json',
	  data:fields,
	}).done(function(data) {
	  console.log(data);
	}).fail(function(jqXHR, textStatus){
		if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 401) {
            window.location.replace('/login');
        } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
        } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500].';
        } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
            msg = 'Time out error.';
        } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
        } else {
            msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }
  		show_message('error','Error en el servidor!',msg);
	});

}



