@extends('layouts.reyapp.mail')
@section('image')
<br><br>
<h1><img src="{{asset('img/logo_ensayo.png')}}" alt="EnsayoPro"></h1>
@endsection

@section('content')
	 <h1>Comprobante de Ensayo(s)</h1>
	<p style="font-size: 20px;">
		Has generado una reservación en <strong> {{$room_name}} de {{$company}}</strong>.  Recuerda llegar puntual a tu ensayo para que lo aproveches mejor. La dirección y fecha se describen abajo: 
	</p>
	
	<p>
		<br>
		@foreach($reservations as $reservation)
			<div>
				<strong style="font-size: 50px;">{{$reservation->mail_time}}</strong><br>
				<strong style="font-size: 30px">{{$reservation->mail_date}}</strong>
			</div>
			<hr>
		@endforeach
	</p>
	<p>
		Ubicación: {{$address}}
	</p>
	<p>
		<br><br>
		<a href="https://www.google.com.mx/maps/dir/{{$latitude}},{{$longitude}}" style="background: #2FAB31;color:white;padding: 15px; text-align: center; border-radius: 10px; text-decoration: none;font-size: 20px;">
			Ubicación de {{$room_name}}
		</a>

	</p>
	<br>
	<h3>Instrucciones</h3>
	<p>
		{{$instructions}}
	</p>
	<br><hr>
	<p style="font-size: 20px;">
		Recuerda calificar tu ensayo y comentar tu experiencia en {{$company}}, así ayudarás a otras bandas a encontrar el espacio ideal.
	</p>
	
	<br><br>


@endsection