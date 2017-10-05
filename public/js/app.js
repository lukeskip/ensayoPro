room_images = [];
$(document).foundation();
$(document).ready(function(){

	// STARTS: Forms
	if($('.chosen-select').length > 0){
		$('.chosen-select').chosen();
	}	
	

	$(".colorpicker").on("change.color", function(event, color){
			$(this).css('background-color', color);
			
	});

	if($(".colorpicker").length > 0){
		$(".colorpicker").colorpicker({
			hideButton: true,
			history: false,
			defaultPalette:'web'
		});
	}

	

	// Cargamos los archivos antes de hacer submit al completarlos se enviar el formulario
	if($('#uploader').length > 0){
		$('#uploader').fineUploader({
			debug:false,
			request: {
				endpoint: '/uploader/upload',
				params: {
				base_directory: 'completed',
				sub_directory: null,
				optimus_uploader_allowed_extensions: [],
				optimus_uploader_size_limit: 0,
				optimus_uploader_thumbnail_height: 100,
				optimus_uploader_thumbnail_width: 100,
				}
			},
			autoUpload: false,
			callbacks: {
				onComplete: function(id,name,responseJSON) {
					room_images.push({
						'name'  :responseJSON.name,
						'path'	:'uploader/completed'
					});
				},
				onAllComplete: function(succeeded){
					register_room();
				}
			}
		});
	}
	// ENDS: Forms
	

	// clonamos el markup que agrega un input más de miembro.
	$('body').on('click', '.add.member', function() {
		$('.input_band_member_clone').clone().removeClass( "input_band_member_clone" ).appendTo('#paste');
	});


	// $('body').on('click', '.register_room', function(e) {
	// 	// register_room_prepare ();
	// });

	

	// Mostramos tooltips
	$('.hastooltip').hover(function(){
			// Hover over code
			var title = $(this).attr('title');
			$(this).data('tipText', title).removeAttr('title');
			$('<p class="tooltip"></p>')
			.text(title)
			.appendTo('body')
			.fadeIn('slow');
	}, function() {
			// Hover out code
			$(this).attr('title', $(this).data('tipText'));
			$('.tooltip').remove();
	}).mousemove(function(e) {
			var mousex = e.pageX + 20; //Get X coordinates
			var mousey = e.pageY + 10; //Get Y coordinates
			$('.tooltip')
			.css({ top: mousey, left: mousex })
	});
	
});

// Función que maneja el registro de la banda del usuario
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

	conection('POST',data,'/bandas','/dashboard');
}

// cargamos las imágenes en FineUploader antes de enviar el formulario ya validado
function register_room_prepare (){	
	$('#uploader').fineUploader('uploadStoredFiles');

}

// 
function register_room (){
	data = $("#form_rooms").serialize()+'&images='+JSON.stringify(room_images);
	conection('POST',data,'/salas');
}

// controlador de mensajes
function show_message(type,title,message,link,color = '#CF2832'){
	swal({ 
		title: title,
		text: message,
		type: type,
		confirmButtonText: 'OK',
		confirmButtonColor: color 
	},
	function(){
		if(link){
		window.location.replace(link);	
		}
	});

}


// pool de conexiones
function conection (method,fields,link,redirect){

	$.ajax({
		header:{
			'Content-Type':'application/x-www-form-urlencoded',
			'Accept':'application/json'
		},
		method:method,
	  url: APP_URL+link,
	  dataType:'json',
	  data:fields,
	})
	.done(function(data) {
	
		if(data.success == true){
			if(redirect){
				window.location.replace(redirect);
			}else{
				show_message('success','¡Listo!',data.message);
			}
		}else{
			show_message('error','¡Error!',data.message);
		}
	  
	  
	}).fail(function(jqXHR, exception){
		msg =  get_error(jqXHR.status);
		show_message('error','Error en el servidor!',msg);
	});

}

function get_error(code){
	if (code === 0) {
		return 'Not connect.\n Verify Network.';
	} else if (code == 401) {
		window.location.replace('/login');
	} else if (code == 404) {
		return 'Requested page not found. [404]';
	} else if (code == 500) {
		return 'Internal Server Error [500].';
	} 
}





