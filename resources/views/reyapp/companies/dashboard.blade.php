@extends('layouts.reyapp.main')
@section('body_class', 'dashboard')
@section('content')
	@if($company)	
		<div class="row">
			<div class="large-12 columns">
				<h1>{{$company->name}}</h1>
			</div>
			
		</div>
		<div class="row">
			<div class="large-9 columns reservations">
					<div class="row list-header">
						<div class="medium-12-columns">
							<h3>Reservaciones esta semana</h3>
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
							Estatus
						</div>
					</div>
					@if(!$reservations->isEmpty())
						@foreach($reservations as $reservation)
							<div class="row list-item">
								<div class="medium-3 columns">
									<span class="hastooltip" title="{{$reservation->hours}} horas">
										{{$reservation->date}}
									</span>
								</div>
								<div class="medium-3 columns">
									{{substr($reservation->description,0,0)}}
									@if($reservation->bands)
										{{$reservation->bands->first()->name}}
									@elseif($reservation->description!='')
										<span class="hastooltip" title="{{$reservation->description}} {{$reservation->payments->order_id}}">{{substr($reservation->description." ".$reservation->payments->order_id,0,10)}}...</span>
									@else
										{{'Sin banda'}}
									@endif
									

								</div>
								<div class="medium-2 columns ">
									{{$reservation->rooms->name}}
								</div>
								<div class="medium-2 columns price">
									${{number_format($reservation->total)}}
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
			<div class="large-3 columns">
				<a class="button expanded green" href="/company/agenda" target="_blank">
					Ir a agenda
				</a>
				<div class="incomings">
					<div class="text">
						Ingresos 
						<span><i class="fa fa-question-circle hastooltip" aria-hidden="true" title="Esta semana vía la plataforma"></i></span>
					</div>
					<div class="number">{{$incomings}}</div>
				</div>

				<div class="hours">
					<div class="number">{{$hours}}</div>
					<div class="text">
						Horas Reservadas 
						<span><i class="fa fa-question-circle hastooltip" aria-hidden="true" title="Esta semana vía la plataforma"></i></span>
					</div>
				</div>
			</div>
		</div>
	@else
	<div class="row">
		<div class="large-12 columns text-center">
			<h1 style="text-align: center">Aún no tienes registrada una compañía</h1>
			<a href="/company/registro/" class="button green">Registrar compañía</a>
		</div>
	</div>
	
	@endif
	
@endsection

@section('scripts')
<script>
	@if($company)
		$(document).ready(function(){
			if (sessionStorage.getItem('company_inactive') !== 'true') {
				if('{{$company->status}}' == 'inactive'){
					show_message('warning','Atención','Los datos de tu compañía están siendo validados, por lo que aún no está activa');
					sessionStorage.setItem('company_inactive','true');
				}
			}
			
		});
	@endif;
</script>
	
@endsection

