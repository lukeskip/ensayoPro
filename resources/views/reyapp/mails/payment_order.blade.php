@extends('layouts.reyapp.mail')
@section('image')
<br><br>
<h1><img src="{{asset('img/logo_ensayo.png')}}" alt="EnsayoPro"></h1>
@endsection

@section('content')
	<h1>Orden de pago</h1>
	<p style="font-size: 20px;">
		Has generado una reservación en <strong> {{$room_name}} de {{$company_name}}</strong>. En estos momentos se encuentra pendiente, para confirmala concluye el proceso pagando con la siguiente referencia en tu tienda Oxxo más cercana. 
	</p>

	<div style="font-size: 25px; text-align: center; color:#666;">Por la cantidad de:<br> <span style="font-size: 50px;">${{$amount}}</span></div>
	<br><br>
	
	<div style="font-size: 25px; text-align: center; color:#666;">Tu número de referencia es:<br> <span style="color:#C73536;font-size: 40px;">{{$reference}}</span></div>


@endsection