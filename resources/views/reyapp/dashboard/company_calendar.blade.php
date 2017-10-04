@extends('layouts.reyapp.landing')
@section('body_class', 'company_calendar')
@section('styles')
	<link rel="stylesheet" href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}">
@endsection
@section('content')
<div class="timer_bar_wrapper">
	<div class="timer_bar"></div>
	<div class="timer_bar_text">Esta ventana se recargará cada 5 minutos</div>
</div>
<div id='calendar'></div>
<div class="room-keys">
	<div class="title"> Código de colores</div>
	@foreach($rooms as $room)
		<div class="room-item">
			<div class="open">></div>
			<div class="color" style="background: {{$room->color}}"></div>
			<div class="text">{{$room->name}}</div>
		</div>
	@endforeach
	
</div>

@endsection
@section('scripts')
	<script src="{{asset('plugins/fullcalendar/lib/moment.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/locale/es.js')}}"></script>

	<script>
		var schedule_start = 8;
		var schedule_end   = 20;
		var room_price 	   = 200;
		var room_id		   = 1;

		// Agregamos la información de cada una de las salas a una variable que ocuparemos en la función de SweetAlert
		var rooms 	     = [];
		var reservations = [];
		
		// Construimos un objeto con la información de los Rooms para después pasarselo al Sweet Alert con que se elije el usuario y la sala
		@foreach($rooms as $room)
			rooms.push({
					'value' :{{$room->id}},
					'text' : '{{$room->name}}' 
			});
		@endforeach

		// Construimos un objeto con las reservaciones del usuario compañía en la base de datos
		@foreach($company_reservations as $reservation)
			reservations.push({
					'id' 		: {{$reservation->id}},
					'title' 	: '{{$reservation->description}}',
					'start' 	: '{{$reservation->starts}}',
					'end'   	: '{{$reservation->ends}}',
					'color' 	: '{{$reservation->rooms->color}}',  
					'className' : 'company-reservation' 
			});
		@endforeach

		// Construimos un objeto con las reservaciones de otros usuarios y que se hicieron por la base de datos
		@foreach($app_reservations as $reservation)
			reservations.push({
					'id'    	: {{$reservation->id}},
					'title' 	: '{{$reservation->description}}',
					'start' 	: '{{$reservation->starts}}',
					'end'   	: '{{$reservation->ends}}',
					'color' 	: '{{$reservation->rooms->color}}',
					'className' : 'app-reservation', 
			});
		@endforeach
		
		// Mostramos el código de colores de las salas
		$(document).ready(function(){
			$('.room-keys').css('left','-200px');
			room_keys = false;
			$('.room-keys .open').click(function(){
					$('.room-keys .open').html('<');
					if(!room_keys){
						$('.room-keys').animate({
							left:0,
						},function(){
							room_keys = true;
							
						});

					}else{
						$('.room-keys .open').html('>');
						$('.room-keys').animate({
							left:-200,
						},function(){
							room_keys = false;
							
						});
					}	
			});
			
		});



		
		
	</script>
	<script src="{{asset('js/calendar_set_company.js')}}"></script>
	
	
@endsection