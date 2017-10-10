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
				<form id="checkout" method="POST" action="/salas/reservando/checkout">
				{{ csrf_field() }}
				<input type="hidden" name="events" class="events">
				<input type="hidden" name="room_id" class="room_id" value="{{$room->id}}">
				<div>
					<select  name="band" class="band" id="">
						<option value="">Banda...</option>
						@foreach($bands as $band)
							<option selected value="{{$band->id}}">{{$band->name}}</option>
						@endforeach
						
					</select>
				</div>
				</form>
				
				<button class='button green expanded checkout'>Checkout</button>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur.
			</div>
		</div>
		
	</div>
	
</div>
@endsection
@section('scripts')
	<script src="{{asset('plugins/fullcalendar/lib/moment.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/locale/es.js')}}"></script>

	<script src="{{asset('js/calendar_set.js')}}"></script>

	<script>
		var schedule_start = {{$room->schedule_start}};
		var schedule_end   = {{$room->schedule_end}};
		var room_price 	   = {{$room->price}};
		var room_id		   = {{$room->id}};
		var reservations   = [];
		
		@foreach($reservations as $reservation)
			reservations.push({
					'id'    	: {{$reservation->id}},
					'title' 	: 'Ocupado',
					'start' 	: '{{$reservation->starts}}',
					'end'   	: '{{$reservation->ends}}',
					'className' : 'occupied', 
			});
		@endforeach  

		$('body').on('click', '.checkout', function() {
			checkout();
		});
	</script>
	
	
@endsection