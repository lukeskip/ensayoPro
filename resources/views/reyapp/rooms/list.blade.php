@extends('layouts.reyapp.main')
@section('styles')
<link rel="stylesheet" href="{{asset('plugins/bar-rating/themes/fontawesome-stars.css')}}">
@endsection
@section('content')
	<div class="row">
		<form id="order_form" class="search" method="get" action="/salas">
			<div class="medium-5 columns no-padding">
				
				<div class="input-group">
					<span class="input-group-label">
						Ordernar:
					</span>
					<select class="input-group-field" name="order" id="order_input">
						<option @if($order == 'quality_up') selected @endif value="quality_up">Calificación ascendente</option>
						<option @if($order == 'quality_down') selected @endif value="quality_down">Calificación descendente</option>
						<option @if($order == 'price_up') selected @endif value="price_up">Precio ascendente</option>
						<option @if($order == 'price_down') selected @endif value="price_down">Precio descendente</option>
						{{-- <option value="discounts">Ofertas</option> --}}
					</select>
				</div>
				
			</div>
		
			
			<div class="medium-5 columns no-padding padding-left">
				
				<div class="input-group">
					<span class="input-group-label">
						Ubicación:
					</span>
					<select class="input-group-field" name="area" class="area">
						<option value="">Selecciona</option>
						<option value="">Centro</option>
						<option value="">Sur</option>
						<option value="">Norte</option>
						<option value="">Oriente</option>
						<option value="">Poniente</option>
					</select>
				</div>
				
			</div>

			<div class="medium-2 columns no-padding padding-left">
				
				    <input type="submit" class="button green expanded no-shadow" value="Filtrar">
				 
				
			</div>
		</form>
		
	</div>
	<div class="row">
		<div class="large-12 columns">
				<div class="row list-header show-for-medium">
					<div class="medium-6 columns">
						Nombre/Marca:
					</div>
					<div class="medium-3 columns">
						Califiación:
					</div>
					<div class="medium-3 columns">
						Precio/Hora:
					</div>
				</div>
				@foreach ($rooms as $room)
				<div class="row list-item room-item">
					<div class="medium-6 columns">

						<a href="/salas/{{$room->id}}">{{$room->companies->name}} ({{$room->name}})</a>
						<div class="info">
							<a href="#" class="colony tag">{{$room->colony}}</a href="#">
							<a href="#" class="deputation tag">{{$room->deputation}}</a href="#">
							{{-- <a href="#" class="discount">Descuento -20%</a href="#"> --}}
						</div>
						
					</div>
					<div class="medium-3 columns rating_wrapper">
								
						@if($room->opinions > 0)
							<select name="" data-score="{{$room->score}}" class="rating">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
							
						@else

							<div class="text-center">
								 Esta sala aún no tiene calificaciones
							</div>
						@endif
						
					</div>
					<div class="medium-3 columns price">
						${{$room->price}}
					</div>

				</div>
				@endforeach
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			{!! $rooms->appends(Request::capture()->except('page'))->render() !!}
		</div>
	</div>
@endsection

@section('scripts')
<script src="{{asset('plugins/bar-rating/jquery.barrating.min.js')}}"></script>
<script>
	$(document).ready(function(){

		$('.rating').each(function() {
	        $(this).barrating({
				theme: 'fontawesome-stars',
				readonly:true,
				initialRating:$(this).data('score'),
				onSelect:function(value, text, event){
					console.log(value);
				}
			});
	    });
	});
</script>
	
@endsection

