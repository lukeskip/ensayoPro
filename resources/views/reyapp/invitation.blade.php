@extends('layouts.reyapp.mail')

@section('content')
  
	<br><br>
	<p>
	<a href="{{url('/')}}/invitation/{{$token}}" style="background: #2FAB31;color:white;padding: 15px; text-align: center; border-radius: 10px; text-decoration: none;font-size: 20px;">
		Sí, pertenezco a esta banda
	</a>

	</p>
	
	<br><br>

	<p><a href="">Deseo borrar mis datos de esta lista de correos</a></p>

@endsection