@extends('layouts.reyapp.main')

@section('styles')
	<link rel="stylesheet" href="{{asset('plugins/lightbox/css/lightbox.min.css')}}">
@endsection

@section('content')
<div class="room-item room-single">
	{{-- <div class="row list-header">
		<div class="medium-12 columns">
			
		</div>
	</div> --}}
	<br>
	<div class="row">
		<div class="medium-4 columns location">
			<div id="map"></div>
		</div>
		
		<div class="medium-8 columns info">
			<h1 class="text-left">{{$room->companies->name}}</h1>
			<h2 class="text-left">{{$room->name}}</h2>
			<div class="price">
				${{$room->price}}/hora
			</div>
			<div class="skillbar clearfix " data-percent="{{$room->score}}%" >
				<div class="skillbar-bar"></div>
			</div>
			<a href="reservando/{{$room->id}}" class="button expanded green">Reservar esta sala</a>
			<div class="tags">
				<span class="colony">{{$room->colony}}</span>
				<span class="deputation">{{$room->deputation}}</span>
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
				{{$room->description}}
			</div>
					
		</div>

	</div>
	<div class="row">
		<div class="medium-12 columns">
			<h3 class="list-header">Equipamiento</h3>
		</div>
	</div>
	<div class="row">

		<div class="medium-4 columns">
			<div class="images">
				@foreach($room->media_items as $image)

					<a class="image" href="{{url('imagenes/'.$image->name)}}" data-lightbox="{{$room->name}}">
						<img src="{{url('imagenes/'.$image->name)}}" />
					</a>
		
				@endforeach
			</div>
		</div>
		<div class="medium-8 columns equipment">
			<ul>
				<li>Cerwin Vega 15″</li>
				<li>Consola Mackie ProFX12 “12 Canales”</li>
				<li>Micrófonos máximo 3 por ensayo.</li>
				<li>Batería Pearl Vision Birch</li>
				<li>Bajo: Fender Rumble 200 “200W”</li>
				<li>Guitarra: Fender Hot Rod Deluxe III Bulbos “40W”</li>
				<li>Guitarra: Fender Hot Rod Deluxe III Bulbos “40W”</li>
			</ul>
			
			
			
			
			
			
			
		</div>
		
	</div>
	
		
	
	
	
</div>
	

@endsection
@section('scripts')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMMiHmdWoL0K5FQPWL_cXBbK0IV-t7l3w"></script>
	<script src="{{asset('plugins/lightbox/js/lightbox-plus-jquery.min.js')}}"></script>
	<script src="{{asset('plugins/gmaps/gmaps.js')}}"></script>
	<script>
	$(document).ready(function(){
		$('.skillbar').each(function(){
			$(this).find('.skillbar-bar').animate({
				width:$(this).attr('data-percent')
			},3000);
		});
		console.log($('.info').height());
		$('#map').height($('.info').height());

		map = new GMaps({
	        div: '#map',
	        lat: -12.043333,
	        lng: -77.028333
      	});

      	map.addMarker({
		  lat: -12.043333,
		  lng: -77.028333,
		  title: 'Lima',
		  click: function(e) {
		    alert('You clicked in this marker');
		  }
		});
	});
	</script>
@endsection