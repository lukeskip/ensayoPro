@extends('layouts.reyapp.main')
@section('body_class', 'dashboard')
@section('content')
	<div class="row">
		<div class="large-12 columns">
			<h1>{{$company->name}}</h1>
		</div>
		
	</div>
	<div class="row">
		<div class="large-9 columns reservations">
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

							<span class="hastooltip" title="Este es un tool tip">
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
				
		</div>
		<div class="large-3 columns">
			<a class="button expanded green" href="/company/dashboard/calendar" target="_blank">
				Ir a agenda
			</a>
			<div class="incomings">
				<div class="text">
					Ingresos 
					<span><i class="fa fa-question-circle hastooltip" aria-hidden="true" title="Este mes vía la plataforma"></i></span>
				</div>
				<div class="number">20,000</div>
			</div>

			<div class="hours">
				<div class="number">156</div>
				<div class="text">
					Horas Reservadas 
					<span><i class="fa fa-question-circle hastooltip" aria-hidden="true" title="Este mes vía la plataforma"></i></span>
				</div>
			</div>
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

