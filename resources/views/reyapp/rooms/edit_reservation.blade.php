@extends('layouts.reyapp.main')
@section('body_class', 'full')
@section('styles')
	<link rel="stylesheet" href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}">
@endsection
@section('content')

<div class="row full desktop">
	<div class="large-12 columns no-padding">
		<div class="timer_bar_wrapper">
			<div class="timer_bar"></div>
			<div class="timer_bar_text">Esta ventana se recargará en 5 minutos</div>
		</div>
	</div>
	<div class="medium-8 columns no-padding calendar-wrapper">
		<div class="calendar-header">
			<h1>{{$room->companies->name}}</h1>
			<h2>{{$room->name}} [Modo edición]</h2>
		</div>
		<div id='calendar' class="edit"></div>
	</div>

	<div class="medium-4 columns reservation-desktop">
		<br><br>
		<h3>Modo edición reservación: {{$code}}</h3>
		<h4>Instrucciones</h4>
		<p>El ensayo que deseas editar está en verde, arrástralo a una nueva fecha, si la hora coincide con un horario ocupado, necesitarás primero dar click en tu ensayo y editar su horario, porteriormente regresa a la pantalla 'mes' y modifica su fecha.Al terminar dar click en guardar. Recuerda que sólo puedes editar una vez la fecha de este horario</p>
		<form class="edit_form" action="">
			<input type="hidden" name="events" class="events">
			<input type="hidden" name="starts" class="starts">
			<input type="hidden" name="ends" class="ends">
			<button type="submit" class="button green expaded save">Guardar</button>
		</form>
	</div>



	
</div>

@endsection
@section('scripts')
	<script src="{{asset('plugins/fullcalendar/lib/moment.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/locale/es.js')}}"></script>
	<script src="{{asset('plugins/underscore/underscore-min.js')}}"></script>
	<script src="{{asset('plugins/validation/jquery.validate.min.js')}}"></script>
	<script src="{{asset('plugins/validation/messages.js')}}"></script>
	<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>

	<script src="{{asset('js/calendar_set_edition.js')}}"></script>

	<script>
		var schedule_start = {{$room->schedule_start}};
		var schedule_end   = {{$room->schedule_end}};
		var room_price 	   = {{$room->price}};
		var room_id		   = {{$room->id}};
		var reservations   = [];
		var hidden		   = [];
		var days = [0,1, 2, 3, 4, 5, 6];
		var code = '{{$code}}';


		@if($user->bands->count() < 1)
			title = '{{$user->name}} {{$user->lastname}}';
		@else
			title = '{{$user->bands->first()->name}}'
 		@endif

		hidden = _.difference(days,[{{$room->days}}]);

		@foreach($room->reservations as $reservation)
			if('{{$reservation->code}}' == '{{$code}}'){
				var default_date   = '{{$reservation->starts}}';

				reservations.push({
					'id'    	: {{$reservation->id}},
					'title' 	: '{{$reservation->code}}',
					'start' 	: '{{$reservation->starts}}',
					'end'   	: '{{$reservation->ends}}',
					'className' : 'edit', 
					'editable' 	: true
				});
			}else{
				reservations.push({
					'id'    	: {{$reservation->id}},
					'title' 	: 'Ocupado',
					'start' 	: '{{$reservation->starts}}',
					'end'   	: '{{$reservation->ends}}',
					'className' : 'occupied', 
				});
			}
			

			
		@endforeach  
	
		



		
</script>
	
	
@endsection