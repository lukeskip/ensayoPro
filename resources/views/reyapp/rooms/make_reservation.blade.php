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
					4 
				</div>
				<div class="text">Horas reservadas</div>
			</div>
			<div class="total-price display">
				<div class="text">Costo total</div>
				<div class="number">
					$400
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
		   	event_id = event_id + 1;
			var eventObject = {
				title: 'Noche de Quiz',
				start: start,
				end: end,
				id: event_id,
				color:'#2FAB31',
			};

		    $('#calendar').fullCalendar('renderEvent', eventObject, true);
		    counting_hours(start,end);
		    return eventObject;
		}

		function isOverlapping(event){
		   var array = calendar.fullCalendar('clientEvents');
		   for(i in array){
		       if(array[i]._id != event._id){
		           if(!(array[i].start.format() >= event.end.format() || array[i].end.format() <= event.start.format())){
		               return true;
		           }
		       }
		    }
		        return false;
		}

		function counting_hours(start,end){
			var start_actual_time  =  start;
			var end_actual_time    =  end;

			start_actual_time = new Date(start_actual_time);
			end_actual_time = new Date(end_actual_time);

			var diff = end_actual_time - start_actual_time;

			var diffSeconds = diff/1000;
			var HH = Math.floor(diffSeconds/3600);

			var price = HH * {{$room->price}};

			$('.total-hours .number').html(HH);
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
			selectMinDistance:30,
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

            	console.log(view);
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
					start: '2017-09-29T16:00:00',
					overlap: false,
					className: "occupied",
				},
			],
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

		// detenemos la barra y la reiniciamos
		function stop_timer_bar(){
			$(".timer_bar").stop();
			$(".timer_bar").clearQueue().css({"width":100+"%"});
		}

		
	});

</script>
	
	
@endsection