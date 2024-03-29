$(document).ready(function() {

		// avisamos sobre el tiempo de caducidad de los datos
		show_message('warning','Atención','esta ventana se recargará cada 5 minutos para actualizar los datos');

		var max_time 	= 300;//segundos para recargar la página 
		var event_id 	= 0;

		$('.band').on('change', function (e) {
			if($(this).val() != ''){
				title = $(this).find("option:selected").text();
			}
		});

		function addEvent( start, end) {
			create = true;
			
			// Contruimos el objeto del nuevo evento
			event_id = 'new_'+event_id + 1;
			var new_event = {
				title: title,
				band:$('.band').val(),
				className: 'new-reservation',
				start: start,
				end: end,
				id: event_id,
				// color:'#2FAB31',
			};
			
			// Revisamos el evento dure al menos 2 horas
			start_time = new Date(new_event.start);
			end_time   = new Date(new_event.end);

			diff = end_time - start_time;

			diffSeconds = diff/1000;
			diff_hours = Math.floor(diffSeconds/3600);

			


			// Buscamos eventos contiguos, si existen los pegamos
			events = $('#calendar').fullCalendar( 'clientEvents' );
			$.each(events, function( index, event ) {
  	
  				old_end   = new Date(event.end);
  				old_start = new Date(event.start);
  				new_start = new Date(new_event.start);
  				new_end   = new Date(new_event.end);
 
  				if( old_end.getTime() == new_start.getTime() && event.className == 'new-reservation' && event.band == $('.band').val()){
  					event.end = new_event.end; 
  					$('#calendar').fullCalendar('updateEvent', event);
  					create = false;
  				}else if(old_start.getTime() == new_end.getTime() && event.className == 'new-reservation'){
  					
  					new_event.end = event.end;
  					$('#calendar').fullCalendar('removeEvents',event.id);					
  				}
  				
			});

			if(create == true && diff_hours >= 2){
				$('#calendar').fullCalendar('renderEvent', new_event, true);

			}else if (create == true && diff_hours < 2){
				show_message('error','¡Error!','Tienes que reservar al menos 2 horas, puedes hacerlo arrastrando el cursor lentamente');	
			}

			counting_hours();
			
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
			$('.amount').val(total_hours);
			
		}

		// Damos el tamaño del height del calendario segun tamaño de la pantalla
		var window_height = $(window).height()-200;
		
	

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'month,agendaDay'
			},
			validRange: function(nowDate) {
				return {
					start: nowDate,
					end: nowDate.clone().add(2, 'months')
				};
			},
			hiddenDays: hidden,
			allDaySlot: false,
			lang:'es',
			slotEventOverlap:false,
			slotDuration: '00:60:00',
			minTime: schedule_start+ ":00:00",
			maxTime: schedule_end+ ":00:00",
			eventDurationEditable:false,
			defaultDate: default_date,
			slotLabelFormat:"HH:mm",
			contentHeight: window_height,
			navLinks: true, // can click day/week names to navigate views
			editable: false,
			selectable: false,
			selectOverlap:false,
			eventOverlap: false,
			selectMinDistance:25,
			selectConstraint:{
				start: schedule_start+':00', // a start time (10am in this example)
				end: schedule_end+':00', // an end time (6pm in this example)
				dow: [0, 1, 2, 3, 4, 5, 6 ]
				// days of week. an array of zero-based day of week integers (0=Sunday)
				
			},
			eventResize: function(event, delta, revertFunc) {

				// alert(event.title + " end is now " + event.end.format());

				// if (!confirm("is this okay?")) {
				// 	revertFunc();
				// }

			},
			eventDrop: function(event, delta, revertFunc) {
				checkout(event.start,event.end);
			},
			select: function(start, end, allDay,view) {

				addEvent(start,end);

			},
			events : reservations,
			eventRender: function(event, element, view) {
				
		
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

		$('.save').click(function(e){
			e.preventDefault()
			data = $('.edit_form').serialize();
			conection('PUT',data,'/salas/reservacion/edicion/'+code,true).then(function(data){
				if(data.success== true){
					show_message('success','¡Listo!','Tu reservación ha sido cambiada');
				}else{
					show_message('error','¡Error!',data.message);
				}

			});
		});


		
});

function checkout(start,end){
	console.log(start);
	events_array = [];
	events = $('#calendar').fullCalendar( 'clientEvents' );
	$.each(events, function( index, event ) {
		if (event.className == 'edit'){
			starts 	= start;
			ends 	= end;	
		}
	});

	$('.starts').val(starts);
	$('.ends').val(ends);
}