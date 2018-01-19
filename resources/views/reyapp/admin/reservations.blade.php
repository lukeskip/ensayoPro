@extends('layouts.reyapp.main')
@section('body_class', 'dashboard')
@section('content')
	<div class="row">
		<form action="">
			<div class="input-group">
				<input name="buscar" class="input-group-field" type="text">
				<div class="input-group-button">
					<input  type="submit" class="button black" value="Buscar">
				</div>
			</div>
		</form>
	</div>
	<div class="row">

		{{-- STARTS: Salas --}}
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
						@if($reservation->bands)
							{{$reservation->bands->first()->name}}
						@elseif($reservation->description!='')
							{{$reservation->description}}
						@else
							{{'Sin banda'}}
						@endif
					</div>
					<div class="medium-2 columns ">
						{{$reservation->rooms->name}}
					</div>
					<div class="medium-2 columns price">
						${{$reservation->payments->amount}}
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
		</div>
		<div class="row">
			<div class="large-12 columns">
				{!! $reservations->appends(Request::capture()->except('page'))->render() !!}
			</div>
		</div>
		{{-- ENDS: Salas --}}
	</div>
	

	
@endsection


