@extends('layouts.reyapp.mail')
@section('image')
<h1><img src="{{asset('img/logo_ensayo.png')}}" alt="EnsayoPro"></h1>
@endsection

@section('content')
	 <h1>Recordatorio de Ensayo</h1>
	<p style="font-size: 20px;">
		Has generado una reservación en <strong> {{$room_name}} de {{$company}}</strong>.  Recuerda llegar puntual a tu ensayo para que lo aproveches mejor. La dirección y fecha se describen abajo: 
	</p>
	
	<p>
		<br>
		<strong style="font-size: 50px;">{{$starts}} a {{$ends}} hrs.</strong><br>
		<strong style="font-size: 30px">{{$date}}</strong>
	</p>
	<p>
		Ubicación: {{$address}}, {{$latitude}}, {{$longitude}}
	</p>
	<p>
		<br><br>
		<a href="https://www.google.com.mx/maps/dir/{{$latitude}},{{$longitude}}" style="background: #2FAB31;color:white;padding: 15px; text-align: center; border-radius: 10px; text-decoration: none;font-size: 20px;">
			Ubicación de {{$room_name}}.
		</a>

	</p>

	<br><br>
	<p style="font-size: 15px;">
		Este ensayo fue generado manualmente por el administrador de {{$company}}, por lo que EnsayoPro y Rey Decibel no se hacen responsables del cumplimiento del mismo, cualquier aclaración o queja deberá tratarse directamente con {{$company}}.
	</p>
	
	<br><br>


@endsection