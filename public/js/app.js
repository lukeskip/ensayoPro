
$(document).foundation();
$(document).ready(function(){

	//STARTS: Read More Text

	// Configure/customize these variables.
    var showChar = 150;  

    $('.more').each(function() {
        var content = $(this).html();
        if(content.length > showChar) {
 
            var html = content.substr(0, showChar);  
            $(this).html(html+'...');
        }
    });

    

	//ENDS: Read More Text

	$(document).on('keyup',function(evt) {
	    if (evt.keyCode == 27) {
	       edit_init();
		}
	});

	function edit_init(){
		$('.show-edit-wrapper').each(function(){
			$(this).find('.show').find('.text').css('display','block');
			$(this).find('.edit').css('display','none');
		});
	}

	$('.show-edit-wrapper .show .text').click(function(){
		edit_init();
		$(this).toggle();
		$(this).parent().parent().find('.edit').toggle();
	});

	$(".show-edit-wrapper form").on("submit", function(e){
		e.preventDefault();
		form 			= $(this);
		method 			= form.attr('method');
		action 			= form.attr('action');
		address_mode 	= form.data('address');
		
		if(address_mode == true){
			getLatLongPromise().done(function(data){
				var latitude  = data[0].geometry.location.lat();
				var longitude = data[0].geometry.location.lng();
				data 	= form.serialize()+'&latitude='+latitude+'&longitude='+longitude;
				conection(method,data,action,true).then(function(data){
					if(data.success == true){
						form.parent().toggle();
						form.parent().parent().find('.text').html(data.description);
						form.parent().parent().find('.text').toggle();
						show_message('success','Listo','Los datos fueron guardados correctamente');
					}

				});
			}).fail(function(){
				data = form.serialize();
				conection(method,data,action,true).then(function(data){
					if(data.success == true){
						form.parent().toggle();
						form.parent().parent().find('.text').html(data.description);
						form.parent().parent().find('.text').toggle();
						show_message('warning','Atención','Los datos fueron guardados, sin embargo, la dirección no fue encontrada, por favor arrastra el pin a la ubicación correcta');
					}
				});
			});
		}else{
			data = form.serialize();
			conection(method,data,action,true).then(function(data){
					if(data.success == true){
						form.parent().toggle();
						form.parent().parent().find('.text').html(data.description);
						form.parent().parent().find('.text').toggle();
						show_message('success','Listo','Los datos fueron guardados correctamente');
					}else{
						show_message('error','Error',data[0].name);
					}
			});
		}
		
		
 	});

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
		});
	}
	// ENDS: Forms
	

	// clonamos el markup que agrega un input más de miembro.
	$('body').on('click', '.add.member', function() {
		$('.input_band_member_clone').clone().removeClass( "input_band_member_clone" ).appendTo('#paste');
	});
	

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

	conection('POST',data,'/bandas',true).then(function(data) {
			if(data.success == true){
				window.location.replace('/dashboard');
			}else{
				show_message('error','Error','Algo salió mal en el servidor, por favor inténtalo más tarde','/dashboard');
			}
	});
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

// Pool de conexiones
function conection (method,fields,link,handle = false){

	return $.ajax({
		header:{
			'Content-Type':'application/x-www-form-urlencoded',
			'Accept':'application/json'
		},
		method:method,
	  	url: APP_URL+link,
	 	dataType:'json',
	  	data:fields,
	  	beforeSend: function( xhr ) {
    		$('.loader-wrapper').css('display','block');
  		}
	})
	.done(function(data) {
		// Si handle es true, solo regresamos la respuesta del ajax, si no manejamos el mensaje al usuario desde aquí
		$('.loader-wrapper').fadeOut();
		if(handle){
			return data;
		}else{
			if(data.success == true){
				show_message('success','¡Listo!',data.message);
			}else{
				show_message('error','¡Error!',data.message);
			}
		}	
	  
	}).fail(function(jqXHR, exception){
		$('.loader-wrapper').fadeOut();
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

function resetForm($form) {
    $form.find('input:text, input:hidden, input:password, input:file, select, textarea').val('');
    $form.find('input:radio, input:checkbox')
         .removeAttr('checked').removeAttr('selected');
}








