@extends('layouts.reyapp.mail')
@section('image')
<img src="{{asset('img/invitation.jpg')}}">
@endsection

@section('content')
  	<p>Fuiste invitado por <strong>{{$name}}</strong> como parte de {{$band}} a <strong>EnsayoPro</strong> una plataforma creada por <strong>Rey Decibel</strong>, que les ayudará a profesionarlizarse como banda, podrán llevar un calendario de actividades y reservar sus ensayos en las principales Salas de tu Ciudad.</p>
  	<p>Para unirte solo necesitas completar tu registro.</p>
	<br><br>
	<p>
	<a href="{{url('/')}}/invitation/{{$token}}" style="background: #2FAB31;color:white;padding: 15px; text-align: center; border-radius: 10px; text-decoration: none;font-size: 20px;">
		Terminar mi registro
	</a>

	</p>
	
	<br><br>

	<p><a href="#">Deseo borrar mis datos de esta lista de correos</a></p>

@endsection