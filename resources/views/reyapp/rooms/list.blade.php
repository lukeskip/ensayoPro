@extends('layouts.reyapp.main')
@section('styles')
<link rel="stylesheet" href="{{asset('plugins/bar-rating/themes/fontawesome-stars.css')}}">
@endsection
@section('content')
	<div class="row">
		<form id="order_form" class="search" method="get" action="/salas">
			
			{{-- STARTS:Hidden fields --}}

			@if(request()->has('colonia'))
				<input type="hidden" name="colonia" value="{{request('colonia')}}">
			@endif

			{{-- ENDS:Hidden fields --}}

			<div class="medium-4 columns no-padding padding-right">
				
				<div class="input-group">
					<span class="input-group-label">
						Ciudad:
					</span>
					<select class="input-group-field change_submit" name="ciudad" class="area">
						<option value="">Todas</option>
						@foreach($cities as $city)
							<option @if(request('ciudad') == $city->city) {{'selected'}} @endif value="{{$city->city}}">{{$city->city}}</option>
						@endforeach
					</select>
				</div>
				
			</div>

			<div class="medium-4 columns no-padding">
				
				<div class="input-group">
					<span class="input-group-label">
						Ordernar:
					</span>
					<select class="input-group-field change_submit" name="order" id="order_input">
						<option @if(request('order') == 'quality_up') selected @endif value="quality_up">Calificación ascendente</option>
						<option @if(request('order') == 'quality_down') selected @endif value="quality_down">Calificación descendente</option>
						<option @if(request('order') == 'price_up') selected @endif value="price_up">Precio ascendente</option>
						<option @if(request('order') == 'price_down') selected @endif value="price_down">Precio descendente</option>
						{{-- <option value="discounts">Ofertas</option> --}}
					</select>
				</div>
				
			</div>
		
			
			<div class="medium-4 columns no-padding padding-left">
				
				<div class="input-group">
					<span class="input-group-label">
						Ubicación:
					</span>
					<select class="input-group-field change_submit" name="deleg" class="area">
						<option value="">Todas</option>
						@foreach($deputations as $deputation)
							<option @if(request('deleg') == $deputation->deputation) {{'selected'}} @endif value="{{$deputation->deputation}}">{{$deputation->deputation}}</option>
						@endforeach
					</select>
				</div>
				
			</div>

			

			{{-- <div class="medium-2 columns no-padding padding-left">
				
				    <input type="submit" class="button filter green expanded no-shadow" value="Filtrar">
				 
				
			</div> --}}
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
						@if(!Auth::guest())
							@if ($role == 'admin')
								<a href="/admin/salas/ajustes/{{$room->id}}">{{$room->companies->name}} ({{$room->name}})</a>
							@else
								<a href="/salas/{{$room->id}}">{{$room->companies->name}} ({{$room->name}})</a>
							@endif
						@else
							<a href="/salas/{{$room->id}}">{{$room->companies->name}} ({{$room->name}})</a>
						@endif
						
						<div class="info">
							@if($role == 'admin')
								<a href="/salas/{{$room->id}}" class="green tag">
									Ver
								</a href="#">
							@endif
							<a href="/salas/?ciudad={{$room->city}}" class="city tag green">{{$room->city}}</a href="#">
							<a href="/salas/?colonia={{$room->colony}}" class="colony tag">{{$room->colony}}</a href="#">
							<a href="/salas/?deleg={{$room->deputation}}" class="deputation tag">{{$room->deputation}}</a href="#">
							
							{{-- <a href="#" class="discount">Descuento -20%</a href="#"> --}}
						</div>
						
					</div>
					<div class="medium-3 columns rating_wrapper">
								
						@if($room->ratings > 0)
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

		$( ".change_submit" ).change(function() {
  			$('#order_form').submit();
		});

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

