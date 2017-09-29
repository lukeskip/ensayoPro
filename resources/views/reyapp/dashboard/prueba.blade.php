@extends('layouts.reyapp.landing')
@section('body_class', 'company_calendar')
@section('styles')
	<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/swal-forms.css')}}">
@endsection
@section('content')
<h2>Check dev console to see data retrieved from the form when closing the modal.</h2>
  <button id='sample1'>Sample 1</button>
  <button id='sampleWithPromises'>Sample using promises</button>
  <button id='complex'>Complex</button>
  <button id='lotsOfFields'>Lots of fields</button>
@endsection
@section('scripts')
	
	<script src="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.js')}}"></script>
  	<script src="{{asset('plugins/swal-forms-master/swal-forms.js')}}"></script>
  	<script src="{{asset('plugins/swal-forms-master/live-demo/live-demo.js')}}"></script>
	
	
@endsection