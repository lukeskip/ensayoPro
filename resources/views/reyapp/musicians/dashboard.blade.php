@extends('layouts.reyapp.main')
@section('body_class', 'dashboard')
@section('content')
	<div class="row">
		<div class="large-12 columns">
			<h1>Bienvenido</h1>
		</div>
		{{-- STARTS: reservaciones --}}
		<div class="large-12 columns reservations end">
				<div class="row list-header">
					<div class="medium-12-columns">
						<h3>Últimas reservaciones</h3>
					</div>
					<div class="medium-3 columns show-for-medium">
						Fecha 
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
				@if(!$reservations->isEmpty())
					@foreach($reservations as $reservation)
						<div class="row list-item">
							<div class="medium-3 columns">

								{{$reservation->date}}
								
							</div>
							<div class="medium-3 columns ">
								@if($reservation->band_id)
									{{$reservation->bands->name}}
								@elseif($reservation->description!='')
									Sin banda
								@else
									{{'Sin banda'}}
								@endif
							</div>
							<div class="medium-2 columns ">
								{{$reservation->rooms->name}}
							</div>
							<div class="medium-2 columns price">
								${{$reservation->payments['amount']}}
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
				@else
					<div class="row list-item">
						<div class="large-12 columnsaa">
							Aún no tienes reservaciones
						</div>
					</div>
				@endif
				

		<div class="row">
			<div class="large-12 columns">
				{!! $reservations->appends(Request::capture()->except('page'))->render() !!}
			</div>
		</div>
				
		</div>
		
	</div>
	
	
@endsection

