@extends('layouts.reyapp.main')
@section('body_class', 'company_calendar')
@section('styles')
	<link rel="stylesheet" href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/swal-forms.css')}}">
@endsection
@section('content')
<div class="timer_bar_wrapper">
	<div class="timer_bar"></div>
	<div class="timer_bar_text">Esta ventana se recargará cada 5 minutos</div>
</div>
<div id='calendar'></div>

@endsection
@section('scripts')
	<script src="{{asset('plugins/fullcalendar/lib/moment.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/locale/es.js')}}"></script>
	<script src="{{asset('plugins/underscore/underscore-min.js')}}"></script>
	<script src="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.js')}}"></script>
  	<script src="{{asset('plugins/swal-forms-master/swal-forms.js')}}"></script>

	<script>
		var reservations = [];
		var options = [];
	

		// Construimos un objeto con las reservaciones de otros usuarios y que se hicieron por la base de datos
		@foreach($reservations as $reservation)
			
			 
			reservations.push({
					'id' 		: '{{$reservation->code}}',
					'title' 	: '{!! nl2br(htmlspecialchars($reservation->description)) !!}',
					'start' 	: '{{$reservation->starts}}',
					'end'   	: '{{$reservation->ends}}',
					'className' : 'reservation {{$reservation->class}}', 
					'updated'	: '{{$reservation->updated}}'
			});

		@endforeach

		@foreach($events as $event)
			@if($reservations->has("bands"))
				var title = '{{$event->bands->name}}';
			@else
				var title = '{{$event->description}}';
			@endif
			 
			reservations.push({
				'title' 	: '{{$event->description}}',
				'start' 	: '{{$event->starts}}',
				'end'   	: '{{$event->ends}}',
				'className' : 'event', 
				'id'		: '{{$event->id}}',
			});
		@endforeach

		@if($bands->first())
			@foreach($bands as $band)
				options.push({
					'value' : '{{$band->id}}',
					'text' 	: '{{$band->name}}',
				});
			@endforeach
		@else 
			options.push({
				'value' : '',
				'text' 	: 'No tienes banda registrada',
			});
		@endif
		

		// avisamos sobre las bondades de la agenda una vez por sesión
		if (sessionStorage.getItem('agendamsg') !== 'true') {
			show_message('success','Bienvenido','En esta sección te aparecerán las reservaciones que hayas hecho y, adicionalmente, manejar tus eventos para tener mejor organizada a tu banda');
			sessionStorage.setItem('agendamsg','true');
		}
	</script>
	<script src="{{asset('js/calendar_set_musician.js')}}"></script>
	
	
@endsection