@extends('layouts.reyapp.main')
@section('body_class', 'report')
@section('content')
	<h1>
		{{$report->period_starts}} / {{$report->period_ends}} 
	</h1>
	@if($role == 'admin')
		<h2>{{$company}}</h2>
	@endif
	

	<div class="row">
		<div class="large-4 columns">
			<div class="hours">
				{{$report->hours}}
			</div>
			<div class="description">
				Horas sin promocion
			</div>
		</div>
		<div class="large-4 columns">
			<div class="hours">
				{{$report->hours_prom}}
			</div>
			<div class="description">
				Horas con promoción
			</div>
		</div>
		<div class="large-4 columns">
			<div class="hours">
				{{$report->hours_total}}
			</div>
			<div class="description">
				Horas totales
			</div>
		</div>
	</div>	
	<div class="row">
	<div class="large-6 columns large-centered incomings_wrapper">
		<div class="incomings">
			${{$report->company_incomings}}
		</div>
		<div class="description">Ingresos</div>
	</div>
		
	</div>
	
@endsection

@section('scripts')

	
@endsection

