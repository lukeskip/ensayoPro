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
							@if($reservation->bands->count() > 0)
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
		
	</div>
	
	
@endsection

