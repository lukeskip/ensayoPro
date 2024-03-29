@extends('layouts.reyapp.main')

@section('styles')
	<link rel="stylesheet" href="{{asset('plugins/lightbox/css/lightbox.min.css')}}">
@endsection

@section('content')
	<div class="checkout">
		<div class="header">
			<h1>{{$payment->companies->name}}</h1>
			<h2>{{$payment->rooms->name}}</h2>
		</div>
		<div class="content row no-margin">
			<br>
			<h2>Resumen de reservaciones</h2>
			<div class="large-12 columns">
				<ul>	
					@foreach($payment->reservations as $reservations)

						<li class="list-item {{$reservations->status}}">
							<div class="icon-date">
								<span class="day">{{$reservations->day}}</span>
								<div class="month">{{$reservations->month}}</div>
							</div>
							<div class="info">
								<span class="start_time time">{{$reservations->starts}}hrs.</span> a
								<span class="end_time time">{{$reservations->ends}}hrs.</span> <br>
								@if($reservations->band_id!='')
									<span class="title">
										Se enviará invitación a {{$reservations->description}}
									</span>
								@endif
							</div>
							
						</li>
					@endforeach
				</ul>
			</div>
			
			<div class="large-5 columns">
				<div class="price-info">
					<h3>Desglose</h3>
					<div class="row">
						<div class="small-8 columns">
							<label class="description">
							Horas
							@if($payment->quantity_prom) 
								sin promoción:
							@endif
							</label>
						</div>
						<div class="small-4 columns">
							{{$payment->quantity}}
						</div>
					</div>

					@if($payment->quantity_prom)
						<div class="row">
							<div class="small-8 columns">
								<label class="description">Horas con promoción:</label>
							</div>
							<div class="small-4 columns">
								{{$payment->quantity_prom}}
							</div>
						</div>
					@endif
					
					<div class="row">
						<div class="small-8 columns">
							<label class="description">Precio Unitario:</label>
						</div>
						<div class="small-4 columns">
							${{$payment->unit_price}}
						</div>
					</div>
					
					@if($payment->unit_price_prom)
						<div class="row">
							<div class="small-8 columns">
								<label class="description">Precio Unitario con promoción:</label>
							</div>
							<div class="small-4 columns">
								${{$payment->unit_price_prom}}
							</div>
						</div>
					@endif
					
					<div class="row">
						<div class="small-8 columns">
							<label class="description">Comisión EnsayoPro</label>
						</div>
						<div class="small-4 columns">
							${{$payment->comission}}
						</div>
					</div>
					
					<hr>
					<div class="row">
						<div class="small-8 columns">
							<label>Importe pagado:</label>
						</div>
						<div class="small-4 columns">
							${{$payment->total}}
						</div>
					</div>
					
				</div>
			</div>
			<div class="large-7 columns no-padding">
				
				
				<div class="instructions">
					
					@if($payment->method == 'oxxo' and $payment->status == 'pending_payment')
						<h3>Instrucciones</h3>
						<p>
							Este pago aún está pendiente por lo que tu reservación aun no está confirmada.
						</p>
						<ol>
							<li>Acude a la tienda OXXO más cercana. <a href="https://www.google.com.mx/maps/search/oxxo/" target="_blank">Encuéntrala aquí</a>.</li>
							<li>Indica en caja que quieres ralizar un pago de <strong>OXXOPay</strong>.</li>
							<li>Dicta al cajero el número de referencia en esta ficha para que tecleé directamete en la pantalla de venta.</li>
							<li>Realiza el pago correspondiente con dinero en efectivo.</li>
							<li>Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
						</ol>
						<p>
							<div class="reference">{{$payment->reference}}</div>
						</p>
					@elseif ('credit')
						<h3>Instrucciones</h3>
						<p>{{$payment->reservations->first()->rooms->instructions}}</p>
					@endif

				</div>
			</div>
			
			
		</div>
	
	</div>
@endsection
@section('scripts')
	
@endsection