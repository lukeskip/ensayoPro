@extends('layouts.reyapp.main')

@section('styles')
	<link rel="stylesheet" href="{{asset('plugins/lightbox/css/lightbox.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/bar-rating/themes/fontawesome-stars-o.css')}}">
@endsection

@section('content')
<div class="room-item room-single">

	<div class="row">
		
		


		<div class="large-8 columns info">
			
			<h1 class="text-left">{{$room->companies->name}}</h1>
			<h2 class="text-left">
				{{$room->name}}
				<span class="price">
					${{$room->price}}/hora
				</span>
			</h2>

			<div class="tags">
				<span class="colony">{{$room->colony}}</span>
				<span class="deputation">{{$room->deputation}}</span>
			</div>
			<div class="hide-for-large">
				<br><br>
				<div class="text-center">
					<label for="">@if($room->score) Califica esta sala @else Sé el primero en calificar esta sala @endif</label>
					<select name="rating" class="hidden rating">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
				<a href="reservando/{{$room->id}}" class="button expanded green">Reservar esta sala</a>
			</div>
			
			
			<div class="full-address">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
				{{$room->address}},
				{{$room->colony}},
				{{$room->deputation}},
				{{$room->postal_code}},
				{{$room->companies->phone}}
			</div>
			<div class="description">
				<p>{{$room->description}}</p>
			</div>
			
			<div class="equipment">
				<div class="list-header">EQUIPAMIENTO</div class="list-header">
				<ul>
					@foreach($room->equipment as $equipment)
						<li class="list-item">{{$equipment}}</li>
					@endforeach
				</ul>
			</div>

			<div class="comments">
				<div class="list-header">OPINIONES</div class="list-header">
					<div class="comment-form comment">
						@if (!Auth::guest())
	
						
						<form action="">
							<div class="title">Deja una opinión</div>
							<label for="">Título;</label>
							<input type="text" name="title">
							<label for="">Opinión:</label>
							<textarea name="" id=""></textarea>
							<button class="green button small" type="submit">Enviar</button>
						</form>
						@else
						<h3>Logéate para dejar una opinión</h3>
						@endif
					</div>
					<div class="comment">
						<div class="date">12 de septiembre de 2016</div>
						<div class="title">No me gustó esta sala</div>
						<div class="description">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</div>
						<div class="author">Cheko García</div>
					</div>
					<div class="comment">
						<div class="date">12 de septiembre de 2016</div>
						<div class="title">Está chida te atienden bien</div>
						<div class="description">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</div>
						<div class="author">Malena Lara</div>
					</div>
			</div>
			

		</div>

		<div class="large-4 columns location">
			<div class="show-for-large">
				<div class="text-center">
					<label for="">Califica esta sala</label>
					<select name="rating" class="hidden rating">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
				<a href="reservando/{{$room->id}}" class="button expanded green">Reservar esta sala</a>
			</div>
			<h3 class="list-header">Ubicación</h3>
			<div id="map"></div>
			<h3 class="list-header">Imágenes</h3>
			<div class="images">
				@foreach($room->media_items as $image)

					<a class="image" href="{{url('imagenes/'.$image->name)}}" data-lightbox="{{$room->name}}">
						<img src="{{url('imagenes/'.$image->name)}}" />
					</a>
		
				@endforeach
			</div>
			
		</div>

		

	</div>
	
	
	
</div>
	

@endsection
@section('scripts')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMMiHmdWoL0K5FQPWL_cXBbK0IV-t7l3w"></script>
	<script src="{{asset('plugins/lightbox/js/lightbox-plus-jquery.min.js')}}"></script>
	<script src="{{asset('plugins/gmaps/gmaps.js')}}"></script>
	<script src="{{asset('plugins/bar-rating/jquery.barrating.min.js')}}"></script>
	<script>

	$(document).ready(function(){
		
		// creamos el mapa con las coordenadas guardadas
		// $('#map').height($('.info').height());

		map = new GMaps({
	        div: '#map',
	        lat: {{$room->latitude}},
	        lng: {{$room->longitude}}
      	});

      	map.addMarker({
		  lat: {{$room->latitude}},
		  lng: {{$room->longitude}},
		  title: 'Lima',
		  click: function(e) {
		    alert('You clicked in this marker');
		  }
		});


        $('.rating').barrating({
			theme: 'fontawesome-stars-o',
			initialRating:@if($room->score){{$room->score}} @else 0 @endif,
			onSelect:function(value, text, event){
				data = {'score':value,'room_id':{{$room->id}},'description':text };
				conection('POST',data,'/opiniones');
			}
		});


		
	    




		
	});
	</script>
@endsection