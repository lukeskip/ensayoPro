@extends('layouts.reyapp.mail')
@section('image')
<br><br>
<h1><img src="{{asset('img/logo_ensayo.png')}}" alt="EnsayoPro"></h1>
@endsection

@section('content')
	 <h1>Comprobante de Ensayo(s)</h1>
	<p style="font-size: 20px;">
		Se ha generado algunas reservaciones para la sala <strong> {{$room_name}}</strong>.  Recuerda tener todo listo para que todo salga excelente y te califiquen bien. A partir de ahora estas reservaciones aparecerán en tu calendario.
	</p>
	
	<p>
		<br>
		@for($i=0;$i<count($reservations);$i++){
			<div>
				<strong style="font-size: 50px;">{{$reservations[$i]['mail_time']}}</strong><br>
				<strong style="font-size: 30px">{{$reservations[$i]['mail_date']}}</strong>
			</div>
			<hr>
		@endfor
	</p>
	<br>
	<h3>Estas fueron las instrucciones que le enviamos a las bandas, si algo está mal cambialo en la sección "Mis salas" de EnsayoPro</h3>
	<p>
		{{$instructions}}
	</p>
	<br><hr>
	<p style="font-size: 20px;">
		Muchas gracias por utilizar EnsayoPro.
	</p>
	
	<br><br>


@endsection