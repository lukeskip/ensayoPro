@extends('layouts.reyapp.mail')
@section('image')
<br><br>
<h1><img src="{{asset('img/logo_ensayo.png')}}" alt="EnsayoPro"></h1>
@endsection

@section('content')
	 <h1>Tienes chamba maestro</h1>
	<p style="font-size: 20px;">
		Una nueva compañía se registró, revisa sus datos y apruebala... o no. Se llama {{$company}}
	</p>
	<br><br>
	<p>
		<a href="{{url('/')}}/admin/" style="background: #2FAB31;color:white;padding: 15px; text-align: center; border-radius: 10px; text-decoration: none;font-size: 20px;">
			Trabaja esclavo!
		</a>

	</p>


@endsection