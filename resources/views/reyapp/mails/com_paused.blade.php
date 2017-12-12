@extends('layouts.reyapp.mail')
@section('image')
<br><br>
<h1><img src="{{asset('img/logo_ensayo.png')}}" alt="EnsayoPro"></h1>
@endsection

@section('content')
  	<h1>Tu cuenta ha sido pausada</h1>
  	<p>Debido a que notamos que no te has conectado a EnsayoPro en 48 horas, hemos pausado tu cuenta para evitar malos entendidos con los reservantes en caso de que por alguna razón no estes utilizando la plataforma para generar las reservaciones.</p>
	<p>

	<p>Para reactivar tu cuenta solo tienes que logearte</p>

	<br><br>

	<a href="{{url('/')}}/login" style="background: #2FAB31;color:white;padding: 15px; text-align: center; border-radius: 10px; text-decoration: none;font-size: 20px;">
		Login
	</a>

	</p>
	
	<br><br>


@endsection