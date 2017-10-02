@extends('layouts.reyapp.landing')
@section('body_class', 'company_calendar')
@section('styles')
	
	
<link rel="stylesheet" href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}">
@endsection
@section('content')
<h2>Check dev console to see data retrieved from the form when closing the modal.</h2>
  <button id='sample1'>Sample 1</button>
  <button id='sampleWithPromises'>Sample using promises</button>
  <button id='complex'>Complex</button>
  <button id='lotsOfFields'>Lots of fields</button>
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

	<script src="{{asset('js/calendar_set_company.js')}}"></script>


	
	
	
@endsection