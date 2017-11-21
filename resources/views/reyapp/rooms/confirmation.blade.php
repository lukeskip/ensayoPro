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
		<div class="content row no-margin">
			<div class="large-8 columns no-padding">
				<h3>Resumen de reservaciones</h3>
				<ul>	
					@foreach($events as $event)
						<li class="list-item {{$event['status']}}">
							<div class="icon-date">
								<span class="day">{{$event['day']}}</span>
								<div class="month">{{$event['month']}}</div>
							</div>
							<div class="info">
								<span class="start_time time">{{$event['start_time']}}hrs.</span> a
								<span class="end_time time">{{$event['end_time']}}hrs.</span> <br>
								<span class="title">
									Se enviará invitación a {{$event['title']}}
								</span>
							</div>
							
						</li>
					@endforeach
				</ul>
			</div>
			<div class="large-4 columns">
				<div class="price-info">
					<div><label>Horas totales:</label>{{$hours}}</div>
					<div><label>Precio Unitario:</label>${{$room->price}}</div>
					{{-- <div><label>Descuento:</label>-20%</div> --}}
					<hr>
					<div><label>Total a pagar:</label> ${{$price}}</div>
					
				</div>
				<form method="POST" action="/checkout">
					<input name="hours" type="hidden" value="{{$hours}}">
					<input name="price" type="hidden" value="{{$price}}">
					<select name="payment_method" id="">
						<option value="card">Tarjeta de Crédito o débito</option>
						<option value="oxxo">Pago en Oxxo</option>

					</select>
					<button class="button green expanded">Proseguir...</button>
				</form>
			</div>
			
		</div>
	
	</div>
@endsection
@section('scripts')
	
@endsection