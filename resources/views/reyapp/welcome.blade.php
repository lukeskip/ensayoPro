@extends('layouts.reyapp.mail')
@section('image')
<img src="{{asset('img/invitation.jpg')}}">
@endsection

@section('content')
  	<h1>Bienvenido a EnsayoPro</h1>
  	<p>Seguramente has estado buscando un lugar para ensayar como se debe, y aquí lo vas a encontrar, pero además te brindaremos las herramientas para que tu banda llegue a donde lo han estado planeando</p>
	<p>

	<p>Estas a un paso de lograrlo, valida tu cuenta</p>

	<br><br>

	<a href="{{url('/')}}/activa_tu_cuenta/{{$token}}" style="background: #2FAB31;color:white;padding: 15px; text-align: center; border-radius: 10px; text-decoration: none;font-size: 20px;">
		Validar cuenta de correo
	</a>

	</p>
	
	<br><br>

	<p><a href="#">Deseo borrar mis datos de esta lista de correos</a></p>

@endsection