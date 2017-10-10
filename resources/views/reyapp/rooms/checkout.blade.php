@extends('layouts.reyapp.main')

@section('styles')
	<link rel="stylesheet" href="{{asset('plugins/lightbox/css/lightbox.min.css')}}">
@endsection

@section('content')
	<div class="checkout">
		<div class="header">
			<h1>{{$room->companies->name}}</h1>
			<h2>{{$room->name}}</h2>
		</div>
		<div class="content row">
			<div class="large-8 columns no-padding">
				<ul>	
					@foreach($events as $event)
						<li class="list-item">
							{{$event['status']}}
						</li>
					@endforeach
				</ul>
			</div>
			<div class="large-4 columns">
				<form action="">
					<button class="button green expanded">Continuar</button>
				</form>
			</div>
			
		</div>
	
	</div>
@endsection
@section('scripts')
	
@endsection