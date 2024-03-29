$(document).ready(function() {

		// avisamos sobre el tiempo de caducidad de los datos solo una vez por sesión
		if (sessionStorage.getItem('refreshmsg') !== 'true') {
			show_message('warning','Atención','esta ventana se recargará cada 5 minutos para actualizar los datos');
			sessionStorage.setItem('refreshmsg','true');
		}

		var max_time 	= 300;//segundos para recargar la página 
		var event_id = 0;

		var window_height = $(window).height()-200;

		console.log(window_height);

		function addEvent(id,start, end , color = '#2FAB31',title) {
			
			// Contruimos el objeto del nuevo evento
			event_id = event_id + 1;
			var new_event = {
				title: title,
				className: 'event',
				start: start,
				end: end,
				id: id,
				color:color,
			};
			
			$('#calendar').fullCalendar('renderEvent', new_event, true);
			
		}

		

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'month,agendaDay'
			},
			validRange: function(nowDate) {
				// return {
				// 	start: nowDate.clone().add(-2, 'months'),
				// 	end: nowDate.clone().add(6, 'months')
				// };
			},
			// hiddenDays: hidden,
			allDaySlot: false,
			lang:'es',
			slotEventOverlap:false,
			slotDuration: '00:60:00',
			slotMinutes: 60,
			timezone: 'America/Mexico_City',
			minTime: "6:00:00",
			maxTime: "24:00:00",
			slotLabelFormat:"HH:mm",
			contentHeight: window_height,
			navLinks: true, 
			editable: false,
			selectable: true,
			selectOverlap:true,
			eventDurationEditable:false,
			displayEventEnd: 'true',
			axisFormat: 'H:mm',
			timeFormat: 'H:mm',
			selectConstraint:{
				start: '06:00', 
				end: '24:00',
				dow: [0, 1, 2, 3, 4, 5, 6 ]
			},
			select: function(start, end, allDay,view) {
				open_form(start,end);
			},
			events: reservations,
			eventRender: function(event, element, view) {


				// Agregamos el botón para eliminar la reservación
				if (view.name== 'agendaDay' && event.className.includes('cancel') && event.updated == 0) {
					element.find(".fc-content").append('<span class="cancel_reservation hastooltip" title="Cancelar reservación"><i class="fa fa-window-close" aria-hidden="true"></i></span>');
					
				}

				// Agregamos el botón para eliminar la reservación
				if (view.name== 'agendaDay' && event.className =='event') {
					// $(element).css('max-width','80%');
					element.find(".fc-content").prepend('<span class="closeon"><i class="fa fa-window-close" aria-hidden="true"></i></span>');
				}
				
				// Eliminamos el evento del calendario 
				element.find(".closeon").on('click', function() {
					delete_reservation(event.id,event.title);
				});

				// Se cancela la reservación
				element.find(".cancel_reservation").on('click', function() {
					cancel_reservation(event.id,event.title);
				});


				element.find('.hastooltip').on({
				    mouseenter: function () {
						// Hover over code
						var title = $(this).attr('title');
						$(this).data('tipText', title).removeAttr('title');
						$('<p class="tooltip"></p>')
						.text(title)
						.appendTo('body')
						.fadeIn('slow');
				    },
				    mouseleave: function () {
						// Hover out code
						$(this).attr('title', $(this).data('tipText'));
						$('.tooltip').remove();
				    },
				    mousemove: function(e){
						var mousex = e.pageX + 20; //Get X coordinates
						var mousey = e.pageY + 10; //Get Y coordinates
						$('.tooltip')
						.css({ top: mousey, left: mousex })
				    } 

				});

	
			},	
			dayClick: function(date, jsEvent, view) {

				$('#calendar').fullCalendar('changeView', 'agendaDay', date);  

			},
			eventClick:function (calEvent, jsEvent, view){
				$('#calendar').fullCalendar('changeView', "agendaDay",calEvent.start);
			}
   
			
		});

		// Barra de tiempo para recargar la página
		start_timer_bar();
		function start_timer_bar(){
			$(".timer_bar").stop();
			$(".timer_bar").clearQueue();

			$(".timer_bar").animate({"width":100+"%"},max_time*1000, function() {
				location.reload();	
			});
		
		}


		function delete_reservation (id,title){
			swal({
			  title: '¿Estás Seguro?',
			  text: "¿Seguro que quieres borrar la entrada  '"+title+"?' Ya no podrás deshacer está acción",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#C73536',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Borrar',
			  cancelButtonText: 'No, cancelar!',
			},function () {
				return new Promise(function (resolve, reject) {
					conection('DELETE','','/musico/eventos/'+id,true).then(function(data) {
  						if(data.success == true){
							show_message('success','Se eliminó', title);
							$('#calendar').fullCalendar('removeEvents',id);
						}else{
							show_message('error','Hubo un error','Hubo un error en el servidor');
						}
					});

				});
			})
		}

		function cancel_reservation (code){
			swal({
			  title: '¿Estás Seguro?',
			  text: "¿Seguro que quieres cancelar esta reservación? Sólo podrás reagendar pero no tener el dinero de vuelta.",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#C73536',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Entiendo, continuar',
			  cancelButtonText: 'No',
			},function () {
				return new Promise(function (resolve, reject) {
					window.location.replace('/salas/reservacion/edicion/'+code);

				});
			})
		}

		function open_form(start,end){

			save_start = $.fullCalendar.formatDate(start , "YYYY-MM-DD HH:mm:SS");
			save_end   = $.fullCalendar.formatDate(end, "YYYY-MM-DD HH:mm:SS");

			swal.withFormAsync({
			    title: 'Entrada de Agenda',
			    text: 'Escribe el nombre de la banda o usuario',
			    showCancelButton: true,
			    confirmButtonColor: '#2FAB31',
			    confirmButtonText: 'Guardar',
			    closeOnConfirm: true,
			    formFields: [
			      { id: 'band_id',
			        type: 'select',
			        options:options
			      },
			      { id: 'description', placeholder: 'Título de la entrada' },
			      { id: 'start', type: 'hidden', value : save_start},
			      { id: 'end', type: 'hidden', value : save_end},

			    ]
			  }).then(function (context) {
			  	if(context._isConfirm){
			  		conection('POST',context.swalForm,'/musico/eventos',true).then(function(data) {
  						if(data.success == true){
						  addEvent(data.id,start,end,data.color,data.title);
						}else{
							show_message('error','¡Error!',data.message);
						}
					});
	
			  	}
			    
			  });
		}

		
});

function checkout(){
	events_array = [];
	events = $('#calendar').fullCalendar( 'clientEvents' );
	$.each(events, function( index, event ) {
		events_array.push({
			'start' : event.start,
			'end' 	: event.end 
		});
	});

	$('.events').val(JSON.stringify(events_array));
	$('#checkout').submit();
}