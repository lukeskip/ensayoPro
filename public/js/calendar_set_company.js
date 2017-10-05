$(document).ready(function() {

		// avisamos sobre el tiempo de caducidad de los datos solo una vez por sesión
		if (sessionStorage.getItem('refreshmsg') !== 'true') {
			show_message('warning','Atención','esta ventana se recargará cada 5 minutos para actualizar los datos');
			sessionStorage.setItem('refreshmsg','true');
		}

		var max_time 	= 300;//segundos para recargar la página 
		var event_id = 0;

		var window_height = $(window).height()-150;

		function addEvent(id,start, end , color = '#2FAB31',title) {
			
			// Contruimos el objeto del nuevo evento
			event_id = event_id + 1;
			var new_event = {
				title: title,
				className: 'company-reservation',
				start: start,
				end: end,
				id: id,
				color:color,
			};
			
			$('#calendar').fullCalendar('renderEvent', new_event, true);
			
		}

		function counting_hours(){
			var total_hours = 0;
			events = $('#calendar').fullCalendar( 'clientEvents' );
			$.each(events, function( index, event ) {
  				if(event.className == 'new-reservation'){
	  				start_actual_time  =  event.start;
					end_actual_time    =  event.end;

					start_time = new Date(start_actual_time);
					end_time = new Date(end_actual_time);

					diff = end_actual_time - start_actual_time;

					diffSeconds = diff/1000;
					hours = Math.floor(diffSeconds/3600);
	  				total_hours = total_hours + hours;
  				}
	  			
			});
			

			var price = total_hours * room_price;

			$('.total-hours .number').html(total_hours);
			$('.total-price .number').html(price);
		}

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'month,agendaDay'
			},
			validRange: function(nowDate) {
				return {
					start: nowDate.clone().add(-2, 'months'),
					end: nowDate.clone().add(2, 'months')
				};
			},
			hiddenDays: [ 2, 4 ],
			allDaySlot: false,
			lang:'es',
			slotEventOverlap:false,
			slotDuration: '00:60:00',
			slotMinutes: 60,
			timezone: 'America/Mexico_City',
			minTime: schedule_start+ ":00:00",
			maxTime: schedule_end+ ":00:00",
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
				start: schedule_start+':00', 
				end: schedule_end+':00',
				dow: [0, 1, 2, 3, 4, 5, 6 ]
			},
			select: function(start, end, allDay,view) {

				open_form(start,end);
				

			},
			events: reservations,
			eventRender: function(event, element, view) {



				// Agregamos el botón para eliminar la reservación
				if (view.name== 'agendaDay' && event.className =='company-reservation') {
					// $(element).css('max-width','80%');
					element.find(".fc-content").prepend('<span class="closeon"><i class="fa fa-window-close" aria-hidden="true"></i></span>');
				}
				// Eliminamos la reservación del calendario delete
				element.find(".closeon").on('click', function() {
					delete_reservation(event.id,event.title);
	
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
			  text: "Seguro que quieres borrar el ensayo de "+title+" Ya no podrás deshacer está acción",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#C73536',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Borrar',
			  cancelButtonText: 'No, cancelar!',
			},function () {
				return new Promise(function (resolve, reject) {
					conection('DELETE','','/reservaciones/'+id,true).then(function(data) {
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

		function open_form(start,end){

			save_start = $.fullCalendar.formatDate(start , "YYYY-MM-DD HH:mm:SS");
			save_end   = $.fullCalendar.formatDate(end, "YYYY-MM-DD HH:mm:SS");

			swal.withFormAsync({
			    title: 'Reservar',
			    text: 'Escribe el nombre de la banda o usuario',
			    showCancelButton: true,
			    confirmButtonColor: '#2FAB31',
			    confirmButtonText: 'Guardar',
			    closeOnConfirm: true,
			    formFields: [
			      { id: 'room_id',
			        type: 'select',
			        options:rooms
			      },
			      { id: 'name', placeholder: 'Nombre de la banda' },
			      { id: 'email', placeholder: 'Email para envio de comprobante' },
			      { id: 'phone', placeholder: 'Teléfono' },
			      { id: 'start', type: 'hidden', value : save_start},
			      { id: 'end', type: 'hidden', value : save_end},

			    ]
			  }).then(function (context) {
			  	if(context._isConfirm){
			  		conection('POST',context.swalForm,'/reservaciones',true).then(function(data) {
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