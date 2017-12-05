@extends('layouts.reyapp.mail')
@section('image')
<br><br>
<h1><img src="{{asset('img/logo_ensayo.png')}}" alt="EnsayoPro"></h1>
@endsection

@section('content')
	 <h1>Reinicia tu contraseña</h1>
	Recibiste este correo porque pediste reiniciar tu contraseña, si no fue así ignora este correo.

	<a href="{{url(config('app.url').route('password.reset', $this->token, false))}}" style="background: #2FAB31;color:white;padding: 15px; text-align: center; border-radius: 10px; text-decoration: none;font-size: 20px;">
			Reinicia tu contraseña
	</a>


@endsection