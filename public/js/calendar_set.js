$(document).ready(function() {

		// avisamos sobre el tiempo de caducidad de los datos
		show_message('warning','Atención','esta ventana se recargará cada 5 minutos para actualizar los datos');

		var max_time 	= 300;//segundos para recargar la página 
		var event_id 	= 0;
		var total_hours = 0;

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
				editable:true,
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
				event = {'starts':start_time,'ends':end_time,'room_id':room_id};
				$('#calendar').fullCalendar('renderEvent', new_event, true);	 
				
				checkprice();

			}else if (create == true && diff_hours < 2){
				show_message('error','¡Error!','Tienes que reservar al menos 2 horas, puedes hacerlo arrastrando el cursor lentamente');	
			}


			// checkprice();
			
		}

		

		// Damos el tamaño del height del calendario segun tamaño de la pantalla
		// width = $(window).width();
		// height = $(window).height();
		// if(width <= 1024){
		// 	height = 450;
		// }else{
		// 	height = height-40;
		// }	
		
		var window_height = $(window).height()-200;
	

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'month,agendaDay'
			},
			validRange: function(nowDate) {
				return {
					start: nowDate.subtract(1, 'days'),
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
			// defaultDate: '2017-09-12',
			slotLabelFormat:"HH:mm",
			timeFormat: 'H:mm',
			contentHeight: window_height,
			navLinks: true, // can click day/week names to navigate views
			editable: false,
			selectable: true,
			selectOverlap:false,
			eventOverlap: false,
			selectMinDistance:25,
			selectConstraint:{
				start: schedule_start+':00', 
				end: schedule_end+':00', 
				dow: [0, 1, 2, 3, 4, 5, 6 ]
				// days of week. an array of zero-based day of week integers (0=Sunday)
				
			},
			eventResize: function(event, delta, revertFunc) {
				// Revisamos el evento dure al menos 2 horas
				start_time = new Date(event.start);
				end_time   = new Date(event.end);

				diff = end_time - start_time;

				diffSeconds = diff/1000;
				diff_hours = Math.floor(diffSeconds/3600);

				if (create == true && diff_hours < 2){
					revertFunc();
					show_message('error','¡Error!','Tienes que reservar al menos 2 horas, puedes hacerlo arrastrando el cursor lentamente');	
				
				}

				checkprice();
			},
			select: function(start, end, allDay,view) {

				addEvent(start,end);

			},
			events : reservations,
			eventRender: function(event, element, view) {
				if (view.name== 'agendaDay' && event.className =='new-reservation') {
					element.find(".fc-content").prepend('<span class="closeon"><i class="fa fa-window-close" aria-hidden="true"></i></span>');
				}
				
				// Eliminamos la reservación del calendario delete
				element.find(".closeon").on('click', function() {
					$('#calendar').fullCalendar('removeEvents',event.id);
					checkprice();
						
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


		
});





function checkprice(){
	events_array = [];
	events = $('#calendar').fullCalendar( 'clientEvents' );
	$.each(events, function( index, event ) {
		if (event.className != 'occupied' && event.className != 'cancelled'){
			events_array.push({
				'band'  : event.band,
				'title' : event.title,
				'start' : event.start,
				'end' 	: event.end
			});	
		}
		
	});
	events_array = JSON.stringify(events_array);
	conection('POST','room_id='+room_id+'&events='+events_array,'/musico/checkprice',true).then(function(data){	
		
		if(data.success == true){
			
			total_hours 	= data.total_hours;

			if(data.promotion_totals.length != 0){
				total 			= _.first(_.sortBy(data.promotion_totals, 'total'));
				price 			= total.total;
				promotion_id 	= total.promotion_id;
				active			= total.active;

				$( ".promotion" ).each(function( index ) {
  					promotion = $(this).data('id');

  					if(promotion == promotion_id && active){
  						$(this).addClass('active');
  						promotion_id_active = promotion_id;
  					}else{
  						$(this).removeClass('active')
  					}

				});
			}else{

				price = data.total;

			}			

			if(price != 0){
				price = price + user_comission;
			}
			

			$('.total-hours .number').html(total_hours);
			$('.total-price .number').html(price);
			$('.amount').val(total_hours);

			if($(".payment_method option:selected").val() == 'oxxo' && total_hours > max_oxxo){
				$('#oxxo-form').find("button").prop("disabled", true);
				show_message('error','¡Error!','No puedes reservar más de '+max_oxxo+' horas con este método de pago');
			}else if($(".payment_method option:selected").val() == 'oxxo' && too_soon){
				show_message('error','¡Error!','No puedes utilizar este método de pago con menos de  '+min_available_oxxo+' horas antes de tu ensayo');
				$('#oxxo-form').find("button").prop("disabled", true);
			}else{
				$('#oxxo-form').find("button").prop("disabled", false);
			}

			if($(".payment_method option:selected").val() == 'credit_card' && total_hours > max_card){
				$('#credit-form').find("button").prop("disabled", true);
				show_message('error','¡Error!','No puedes reservar más de '+max_card+' horas con este método de pago');
			}else{
				$('#credit-form').find("button").prop("disabled", true);
			}


		}else{
			show_message('warning','Atención',data.message);
		}
	});
	
}

function checkout(){
	events_array = [];
	events = $('#calendar').fullCalendar( 'clientEvents' );
	$.each(events, function( index, event ) {
		if (event.className != 'occupied' && event.className != 'cancelled'){
			events_array.push({
				'band'  : event.band,
				'title' : event.title,
				'start' : event.start,
				'end' 	: event.end
			});	
		}
		
	});

	$('.events').val(JSON.stringify(events_array));
	$('#checkout').submit();
}