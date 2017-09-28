@extends('layouts.reyapp.main')

@section('styles')
	<link rel="stylesheet" href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}">
@endsection
@section('content')

<div class="row desktop">
	<div class="large-12 columns no-padding">
		<div class="timer_bar_wrapper">
			<div class="timer_bar"></div>
			<div class="timer_bar_text">Esta ventana se recargará en 5 minutos</div>
		</div>
	</div>
	<div class="large-9 columns no-padding calendar-wrapper">
		<div class="calendar-header">
			<h1>{{$room->companies->name}}</h1>
			<h2>{{$room->name}}</h2>
		</div>
		<div id='calendar'></div>
	</div>

	<div class="large-3 columns no-padding">
		<div class="reservation-desktop">
			<div class="total-hours display">
				
				<div class="number">
					0 
				</div>
				<div class="text">Horas reservadas</div>
			</div>
			<div class="total-price display">
				<div class="text">Costo total</div>
				<div class="number">
					$0
				</div>
			</div>
			<div class="clarification display">
				<button class='button green expanded'>Checkout</button>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
		
	</div>
	
</div>
@endsection
@section('scripts')
	<script src="{{asset('plugins/fullcalendar/lib/moment.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/locale/es.js')}}"></script>

	<script>

	$(document).ready(function() {

		// avisamos sobre el tiempo de caducidad de los datos
		show_message('warning','Atención','esta ventana se recargará cada 5 minutos para actualizar los datos');

		var max_time 	= 300;//segundos para recargar la página 
		var event_id = 0;

		function addEvent( start, end) {
			update = false;
			
			// Contruimos el objeto del nuevo evento
			event_id = event_id + 1;
			var new_event = {
				title: 'Noche de Quiz',
				className: 'new-reservation',
				start: start,
				end: end,
				id: event_id,
				color:'#2FAB31',
			};
			
			// Revisamos el evento dure al menos 2 horas
			start_time = new Date(new_event.start);
			end_time   = new Date(new_event.end);

			diff = end_time - start_time;

			diffSeconds = diff/1000;
			diff_hours = Math.floor(diffSeconds/3600);

			if(diff_hours < 2){
				new_event.end.add(1, 'h');
			}


			// Buscamos eventos contiguos, si existen los pegamos
			events = $('#calendar').fullCalendar( 'clientEvents' );
			$.each(events, function( index, event ) {
  	
  				old_end   = new Date(event.end);
  				new_start = new Date(new_event.start);
 
  				if( old_end.getTime() == new_start.getTime() && event.className == 'new-reservation'){
  					event.end = new_event.end; 
  					$('#calendar').fullCalendar('updateEvent', event);

  					update = true;
  				}
  				
			});

			if(update == false){
				$('#calendar').fullCalendar('renderEvent', new_event, true);
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
			

			var price = total_hours * {{$room->price}};

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
			minTime: "{{$room->schedule_start}}:00:00",
			maxTime: "{{$room->schedule_end}}:00:00",
			defaultDate: '2017-09-12',
			slotLabelFormat:"HH:mm",
			contentHeight: 450,
			navLinks: true, // can click day/week names to navigate views
			editable: false,
			selectable: true,
			eventOverlap:false,
			selectOverlap:false,
			selectMinDistance:25,
			selectConstraint:{
				start: '{{$room->schedule_start}}:00', // a start time (10am in this example)
				end: '{{$room->schedule_end}}:00', // an end time (6pm in this example)
				dow: [0, 1, 2, 3, 4, 5, 6 ]
				// days of week. an array of zero-based day of week integers (0=Sunday)
				
			},
			eventResize: function(event, delta, revertFunc) {

				alert(event.title + " end is now " + event.end.format());

				if (!confirm("is this okay?")) {
					revertFunc();
				}

			},
			select: function(start, end, allDay,view) {

				addEvent(start,end);




			},
			eventDrop: function(event, delta, revertFunc) {
				if (checkOverlap(event)) {
					console.log('isOverlapping')
				}	
			},
			events: [
				{
					id: 999,
					title: 'Ocupado',
					start: '2017-09-29T10:00:00',
					end: '2017-09-29T12:00:00',
					overlap: false,
					className: "occupied",
				},
			],
			eventRender: function(event, element, view) {
				if (view.name== 'agendaDay' && event.className =='new-reservation') {
					element.find(".fc-content").prepend('<span class="closeon"><i class="fa fa-window-close" aria-hidden="true"></i></span>');
				}
				
				// Eliminamos la reservación del calendario delete
				element.find(".closeon").on('click', function() {
					$('#calendar').fullCalendar('removeEvents',event.id);
					counting_hours();	
				});
			},	
			dayClick: function(date, jsEvent, view) {

				$('#calendar').fullCalendar('changeView', 'agendaDay', date);  

			}
   
			
		});

		// Barra de tiempo para recargar la página
		start_timer_bar();
		function start_timer_bar(){
			console.log("se ejecuto");
			$(".timer_bar").stop();
			$(".timer_bar").clearQueue();

			$(".timer_bar").animate({"width":100+"%"},max_time*1000, function() {
				location.reload();	
			});
		
		}

		
	});

</script>
	
	
@endsection