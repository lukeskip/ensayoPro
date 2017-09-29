$(document).ready(function() {

		// avisamos sobre el tiempo de caducidad de los datos
		show_message('warning','Atención','esta ventana se recargará cada 5 minutos para actualizar los datos');

		var max_time 	= 300;//segundos para recargar la página 
		var event_id = 0;

		var window_height = $(window).height()-150;

		function addEvent(start, end , color= '#2FAB31',title) {
			
			// Contruimos el objeto del nuevo evento
			event_id = event_id + 1;
			var new_event = {
				title: title,
				className: 'new-reservation',
				start: start,
				end: end,
				id: event_id,
				color:'#2FAB31',
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
					start: nowDate,
					end: nowDate.clone().add(2, 'months')
				};
			},
			hiddenDays: [ 2, 4 ],
			allDaySlot: false,
			lang:'es',
			slotEventOverlap:false,
			slotDuration: '00:60:00',
			minTime: schedule_start+ ":00:00",
			maxTime: schedule_end+ ":00:00",
			defaultDate: '2017-09-12',
			slotLabelFormat:"HH:mm",
			contentHeight: window_height,
			navLinks: true, // can click day/week names to navigate views
			editable: false,
			selectable: true,
			selectOverlap:false,
			selectMinDistance:25,
			eventDurationEditable:true,
			selectConstraint:{
				start: schedule_start+':00', // a start time (10am in this example)
				end: schedule_end+':00', // an end time (6pm in this example)
				dow: [0, 1, 2, 3, 4, 5, 6 ]
				// days of week. an array of zero-based day of week integers (0=Sunday)
				
			},
			// eventResize: function(event, delta, revertFunc) {

			// 	alert(event.title + " end is now " + event.end.format());

			// 	if (!confirm("is this okay?")) {
			// 		revertFunc();
			// 	}

			// },
			select: function(start, end, allDay,view) {
				open_form(start,end);
				

			},
			events: [
				{
					id: 999,
					title: 'Ocupado',
					start: '2017-09-30T10:00:00',
					end: '2017-09-30T12:00:00',
					overlap: false,
					className: "reyapp",
				},
			],
			eventRender: function(event, element, view) {

				console.log(event.className);
				console.log(view.name);
				// Agregamos el botón para eliminar la reservación
				if (view.name== 'agendaDay' && event.className =='new-reservation') {
					element.find(".fc-content").prepend('<span class="closeon"><i class="fa fa-window-close" aria-hidden="true"></i></span>');
					console.log("Se ejecutaaaa");
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



		function update_reservation(){

		}

		function delete_reservation (id,title){
			swal({
			  title: '¿Estás Seguro?',
			  text: "Seguro que quieres borrar el ensayo de "+title+" Ya no podrás deshacer está acción",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Borrar',
			  cancelButtonText: 'No, cancelar!',
			}).then(function () {
				return new Promise(function (resolve, reject) {
					$.ajax({
						header:{
							'Content-Type':'application/x-www-form-urlencoded',
							'Accept':'application/json'
						},
						method:'DELETE',
						url: APP_URL+'/reservaciones/'+id,
						dataType:'json',
						// data:fields,
					}).done(function(data) {
						console.log(data);
						if(data.success == true){
							show_message('success','Se eliminó', title);
							$('#calendar').fullCalendar('removeEvents',id);
						}else{
							show_message('error','Hubo un error','Hubo un error en el servidor');
						}
					  
					}).fail(function(jqXHR, exception){
						msg =  get_error(jqXHR.status);
							show_message('error','Error en el servidor!',msg);
					});
				});
			})
		}

		function open_form(start,end){
			
			popup.open();
			
			// $.ajax({
			// 	header:{
			// 		'Content-Type':'application/x-www-form-urlencoded',
			// 		'Accept':'application/json'
			// 	},
			// 	method:'POST',
			// 	url: APP_URL+'/reservaciones',
			// 	dataType:'json',
			// 	data:{
			// 		'title':$('#title').val(),
			// 		'room_id':$('room_id').val(),
			// 		'start':start,
			// 		'end':end,
			// 	},
			// }).done(function(data) {
			// 	console.log(data);
			// 	if(data.success == true){
			// 		show_message('success','Se agregó el evento',text);
			// 		addEvent(start,end,'',text);
			// 	}else{
			// 		show_message('error','Hubo un error','Hubo un error en el servidor');
			// 	}
			  
			// }).fail(function(jqXHR, exception){
			// 	msg =  get_error(jqXHR.status);
			// 		show_message('error','Error en el servidor!',msg);
			// });
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