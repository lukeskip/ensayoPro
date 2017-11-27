@extends('layouts.reyapp.mail')
@section('image')
<img src="{{asset('img/invitation.jpg')}}">
@endsection

@section('content')
	<h1>{{$status}}</h1>
  	<p style="font-size: 20px;">Fuiste invitado por  como parte de a <strong>EnsayoPro</strong> una plataforma creada por <strong>Rey Decibel</strong>, que les ayudará a profesionarlizarse como banda, podrán llevar un calendario de actividades y reservar sus ensayos en las principales Salas de tu Ciudad.</p>
  	<p style="font-size: 20px;">Para unirte solo necesitas completar tu registro.</p>
	<br><br>
	
	
	
	<br><br>

	<p><a href="#">Deseo borrar mis datos de esta lista de correos</a></p>

@endsection