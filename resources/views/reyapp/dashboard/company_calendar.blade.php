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


<div id="form" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <form action="" id="reservation_form">
  	<input type="text" name="title">
	<select name="room_id" id="">
	  	@foreach($rooms as $room)
			<option value="{{$room->id}}">{{$room->name}}</option>';
		@endforeach
	</select>
	<button class="button expanded green">Enviar</button>
  </form>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
@endsection
@section('scripts')
	<script src="{{asset('plugins/fullcalendar/lib/moment.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/locale/es.js')}}"></script>

	<script src="{{asset('js/calendar_set_company.js')}}"></script>

	<script>
		var popup = new Foundation.Reveal($('#popup-modal'));
		var schedule_start = 8;
		var schedule_end   = 20;
		var room_price 	   = 200;
		var room_id		   = 1;

		// Agregamos la información de cada una de las salas a una variable que ocuparemos en la función de SweetAlert
		var rooms		   = [];
		
		room_colors  = [
			{
				'id' : '1',
				'color': 'black'
			},
			{
				'id': '2',
				'color':'red'
			},
		]; 
		



		
		
	</script>
	
	
@endsection