@extends('layouts.reyapp.main')

@section('content')
	<div class="checkout">
		<div class="header">
			<h1>{{$room->companies->name}}</h1>
			<h2>{{$room->name}}</h2>
		</div>
		<div class="content row no-margin">
			{{-- STARTS: Column left --}}
			<div class="large-12 columns ">
				<br>
				<h2>Resumen</h2>
				
				<ul>	
					@foreach($events as $event)
						<li class="list-item {{$event['status']}}">
							<div class="icon-date">
								<span class="day">{{$event['day']}}</span>
								<div class="month">{{$event['month']}}</div>
							</div>
							<div class="info">
								<span class="start_time time">{{$event['start_time']}}hrs.</span> a
								<span class="end_time time">{{$event['end_time']}}hrs.</span> <br>
								<span class="title">
									Se enviará invitación a {{$event['title']}}
								</span>
							</div>
							
						</li>
					@endforeach
				</ul>
		</div>

	</div>

	<div class="row">
		<div class="large-12 columns">
			<br><hr>
		</div>
		<div class="large-4 columns">
				<div class="medium-12 columns">
					<h3>Resumen de costo</h3>
					<div class="price-info">
						<div><label>Horas totales:</label>{{$hours}}</div>
						<div><label>Precio Unitario:</label>${{$room->price}}</div>
						<div><label>Descuento:</label>-20%</div>
						<hr>
						<div><label>Total a pagar:</label> ${{$price}}</div>
						
					</div>
				</div>
		</div>
		<div class="large-8 columns">
			
			<div class="medium-12 columns">
				
				<form method="POST" action="/checkout">
					<input name="hours" type="hidden" value="{{$hours}}">
					<input name="price" type="hidden" value="{{$price}}">
					<select name="payment_method" id="" class="payment_method">
						<option value="">Elige el método de pago</option>
						<option value="credit_card">Tarjeta de Crédito o débito</option>
						<option value="oxxo">Pago en Oxxo</option>

					</select>
				</form>
			</div>
			
			{{-- STARTS: Card form --}}
			<div class="credit_card method">
					<form action="/card" method="POST" id="card-form">
					
						{{-- <label>Sala:</label> 
						<input name="room" type="text" size="20" value="sala 12"> --}}
						<div class="large-6 columns">
							<label>Precio:</label>
							<input name="price" type="text" size="20" value="{{$price}}">
						</div>

						<div class="large-6 columns">
							<label>Cantidad:</label>
							<input name="quantity" type="text" size="20" value="{{$hours}}">
						</div>

						<div class="large-6 columns">
							<label>Nombre:</label>
							<input name="name" type="text" size="20" value="John Spencer" data-conekta="card[name]">
						</div>
						<div class="large-6 columns">
							<label># Tarjeta:</label> 
							<input type="text" size="20" value="5555555555554444" data-conekta="card[number]">
						</div>

						<div class="large-6 columns">
							<label>CVC:</label>
							<input type="text" size="4" value="123" data-conekta="card[cvc]">
						</div>
						
						<div class="large-6 columns">
							<label>Fecha de expiración (MM/AAAA)</label>
							<input type="text" size="2" value="05" data-conekta="card[exp_month]">
							<input type="text" size="4" value="2018" data-conekta="card[exp_year]">
						</div>
						
						{{-- <div class="large-6 columns">
							<input name="tel" type="text" size="20" value="+5213353319758">
						</div>

						<div class="large-6 columns">
							<input name="email" type="text" size="20" value="email@email.com">
						</div> --}}
						<div class="large-12 columns">
							<button class="button green expanded">Pagar</button>
						</div>	 
						
					</form>
			</div>
			{{-- ENDS: Card form --}}


			{{-- STARTS: Oxxo form --}}

			<div class="oxxo method">
				<form action="/oxxo" method="POST">
					<div class="large-6 columns">
						<label for="">Sala:</label>
						<input name="room" type="text" size="20" value="sala 12">
					</div>
					
					<div class="large-6 columns">
						<label for="">Costo:</label>
						<input name="price" type="text" size="20" value="10000">
					</div>
					
					<div class="large-6 columns">
						<label for="">Cantidad</label>
						<input name="quantity" type="text" size="20" value="3">
					</div>
					
					<div class="large-6 columns">	
						<label for="">Nombre:</label>
						<input name="name" type="text" size="20" value="John Spencer">
					</div>
					
					<div class="large-6 columns">
						<label for="">Teléfono</label>
						<input name="tel" type="text" size="20" value="+5213353319758">
					</div>
					
					<div class="large-6 columns">	
						<label for="">Email:</label>
						<input name="email" type="text" size="20" value="email@email.com">
						
					</div>

					<div class="large-12 columns">
						<button class="button green expanded">Pagar</button>
					</div>
					</form>
				</div>
			{{-- ENDS: Oxxo form --}}
		
		</div>
	</div>

		
	

{{-- Reveals --}}
<div class="reveal" id="card" data-reveal>
  <h1>Awesome. I Have It.</h1>
  				<form action="/card" method="POST" id="card-form">
				
					<label>Sala:</label> 
					<input name="room" type="text" size="20" value="sala 12">
					<div class="large-6 columns">
						<label>Precio:</label>
						<input name="price" type="text" size="20" value="{{$price}}">
					</div>

					<div class="large-6 columns">
						<label>Cantidad:</label>
						<input name="quantity" type="text" size="20" value="{{$hours}}">
					</div>

					<div class="large-6 columns">
						<label>Nombre:</label>
						<input name="name" type="text" size="20" value="John Spencer" data-conekta="card[name]">
					</div>
					<div class="large-6 columns">
						<label># Tarjeta:</label> 
						<input type="text" size="20" value="5555555555554444" data-conekta="card[number]">
					</div>

					<div class="large-6 columns">
						<label>CVC:</label>
						<input type="text" size="4" value="123" data-conekta="card[cvc]">
					</div>
					
					<div class="large-6 columns">
						<label>Fecha de expiración (MM/AAAA)</label>
						<input type="text" size="2" value="05" data-conekta="card[exp_month]">
						<input type="text" size="4" value="2018" data-conekta="card[exp_year]">
					</div>
					
					<div class="large-6 columns">
						<input name="tel" type="text" size="20" value="+5213353319758">
					</div>

					<div class="large-6 columns">
						<input name="email" type="text" size="20" value="email@email.com">
					</div>
						 
					<button class="button green expanded">Pagar</button>
				</form>
  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="reveal" id="oxxo" data-reveal>
  <h1>Awesome. I Have It.</h1>
  <p class="lead">Your couch. It is mine.</p>
  <p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>
  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
				
@endsection
@section('scripts')
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
<script type="text/javascript" >
  Conekta.setPublishableKey("{{env('CONEKTA_PUBLIC_KEY')}}");

  var conektaSuccessResponseHandler = function(token) {
	var $form = $("#card-form");
	//Inserta el token_id en la forma para que se envíe al servidor
	$form.append($('<input type="hidden" name="token" id="conektaTokenId">').val(token.id));
	$form.get(0).submit(); //Hace submit
  };
  var conektaErrorResponseHandler = function(response) {
	var $form = $("#card-form");
	$form.find(".card-errors").text(response.message_to_purchaser);
	$form.find("button").prop("disabled", false);
  };

  //jQuery para que genere el token después de dar click en submit
  $(function () {
	$("#card-form").submit(function(event) {
	  var $form = $(this);
	  // Previene hacer submit más de una vez
	  $form.find("button").prop("disabled", true);
	  Conekta.token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
	  return false;
	});
  });

  $(document).ready(function(){
  	$( ".payment_method" ).change(function() {
  		if($(this).val()== 'credit_card'){
  			$('.credit_card').fadeIn('slow');
  			$('.oxxo').fadeOut('fast');
  		}else if($(this).val()== 'oxxo'){
  			$('.oxxo').fadeIn('slow');
  			$('.credit_card').fadeOut('fast');
  		}
	});
  })
</script>

	
@endsection