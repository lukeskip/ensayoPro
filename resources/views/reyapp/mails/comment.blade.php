@extends('layouts.reyapp.mail')
@section('image')
<br><br>
<h1><img src="{{asset('img/logo_ensayo.png')}}" alt="EnsayoPro"></h1>
@endsection

@section('content')
	 <h1>Tienes un nuevo comentario en {{$room->name}}</h1>
	<br><br>
	<p style="font-size: 20px; font-weight: 700 ">
		{{$comment->author}} dijo:
	</p>
	<br>
	<p style="font-size: 20px;">
		 {{$comment->description}}
	</p>
	<br>
	<br>
	<p>
	
		<a href="{{url('/')}}/salas/{{$room->id}}?comentario={{$comment->id}}" style="background: #2FAB31;color:white;padding: 15px; text-align: center; border-radius: 10px; text-decoration: none;font-size: 20px;">
				Para contestarlo haz click aquí
		</a>

	</p>


@endsection