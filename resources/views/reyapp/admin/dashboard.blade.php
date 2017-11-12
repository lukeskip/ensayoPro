@extends('layouts.reyapp.main')
@section('body_class', 'dashboard')
@section('content')
	

	
	<div class="row">
		{{-- STARTS: reservaciones --}}
		<div class="large-12 columns reservations">
				<div class="row list-header">
					<div class="medium-12-columns">
						<h3>Últimas reservaciones</h3>
					</div>
					<div class="medium-3 columns show-for-medium">
						Usuario 
					</div>
					<div class="medium-3 columns show-for-medium">
						Banda
					</div>
					<div class="medium-2 columns show-for-medium">
						Sala
					</div>
					<div class="medium-2 columns show-for-medium">
						Total
					</div>
					<div class="medium-2 columns show-for-medium">
						Status
					</div>
				</div>
				@foreach($reservations as $reservation)
					<div class="row list-item">
						<div class="medium-3 columns">

							<span>
								{{$reservation->users->name}} {{$reservation->users->lastname}}
							</span>
							
						</div>
						<div class="medium-3 columns ">
							{{$reservation->description}}
						</div>
						<div class="medium-2 columns ">
							{{$reservation->rooms->name}}
						</div>
						<div class="medium-2 columns price">
							{{$reservation->price}}
						</div>
						<div class="medium-2 columns status">
							@if($reservation->status == 'confirmed')
								<i class="fa fa-check-circle-o confirmed hastooltip" title="Confirmado" aria-hidden="true"></i>
							@elseif($reservation->status == 'pending')
								<i class="fa fa-clock-o hastooltip pending" aria-hidden="true" title="Pendiente"></i>
							@elseif($reservation->status)
								<i class="fa fa-times-circle-o hastooltip cancelled" title="Cancelado" aria-hidden="true"></i>
							@endif
						</div>

					</div>
				@endforeach

			<div class="row">
				<div class="large-12 columns text-center">
					<br>
					<a class="button black" href="/admin/reservaciones">Ver todas</a>
				</div>
			</div>
				
		</div>
	
		{{-- ENDS: reservaciones --}}

		{{-- STARTS: reservaciones --}}
	
		<div class="large-12 columns reservations">
			<div class="row list-header">
				<div class="medium-12-columns">
					<h3>Mejores salas</h3>
				</div>
				<div class="medium-4 columns show-for-medium">
					Sala 
				</div>
				<div class="medium-3 columns show-for-medium">
					Precio
				</div>
				<div class="medium-3 columns show-for-medium">
					Calificación
				</div>
				<div class="medium-2 columns show-for-medium">
					Status
				</div>
			</div>
			@foreach($rooms as $room)
				<div class="row list-item">
					<div class="medium-4 columns">
						<a href="/salas/{{$room->id}}">{{$room->name}}</a>
					</div>
					<div class="medium-3 columns ">
						${{$room->price}}
					</div>
					<div class="medium-3 columns ">
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
					<div class="medium-2 columns status">
						@if($reservation->status == 'confirmed')
							<i class="fa fa-check-circle-o confirmed hastooltip" title="Confirmado" aria-hidden="true"></i>
						@elseif($reservation->status == 'pending')
							<i class="fa fa-clock-o hastooltip pending" aria-hidden="true" title="Pendiente"></i>
						@elseif($reservation->status)
							<i class="fa fa-times-circle-o hastooltip cancelled" title="Cancelado" aria-hidden="true"></i>
						@endif
					</div>

				</div>
			@endforeach
			<div class="row">
				<div class="large-12 columns text-center">
					<br>
					<a class="button black" href="/admin/salas">Ver todas</a>
				</div>
			</div>
		</div>
		{{-- ENDS: reservaciones --}}
	</div>
	

	
@endsection

@section('scripts')
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

