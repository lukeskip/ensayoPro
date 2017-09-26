@extends('layouts.reyapp.main')

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
				<div class="input-group">
				  <div class="input-group-button">
				    <input type="submit" class="button green expanded no-shadow" value="Filtrar">
				  </div>
				</div>
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
							<a href="#" class="colony">{{$room->colony}}</a href="#">
							<a href="#" class="deputation">{{$room->deputation}}</a href="#">
							{{-- <a href="#" class="discount">Descuento -20%</a href="#"> --}}
						</div>
						
					</div>
					<div class="medium-3 columns ">
						@if($room->opinions > 0)
							<div class="skillbar clearfix " data-percent="{{$room->score}}%" >
								<div class="skillbar-bar"></div>
							</div>
							<div class="text-center">
								 {{$room->opinions}} calificaciones
							</div>
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
<script>
	$(document).ready(function(){
		$('.skillbar').each(function(){
			$(this).find('.skillbar-bar').animate({
				width:$(this).attr('data-percent')
			},3000);
		});
	});
</script>
	
@endsection

