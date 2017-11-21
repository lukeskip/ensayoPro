@extends('layouts.reyapp.main')

@section('styles')
	<link rel="stylesheet" href="{{asset('plugins/lightbox/css/lightbox.min.css')}}">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
@endsection

@section('content')
	<select name="payment_method" id="sel-type">
		<option value="">--selecciona tu forma de pago--</option>
		<option value="card">Tarjeta de Crédito o débito</option>
		<option value="oxxo">Pago en Oxxo</option>
	</select>

	<div id="card" class="checkout">
		
		<div class="content row no-margin">
			<div class="large-8 columns no-padding">
				<h3>Pago con tarjeta</h3>
			</div>
			<div class="large-4 columns">
			
				<form action="/card" method="POST" id="card-form">
		
					Sala: <input name="room" type="text" size="20" value="sala 12">
				
					Precio: <input name="price" type="text" size="20" value="10000">
					Cantidad: <input name="quantity" type="text" size="20" value="3">
					Nombre: <input name="name" type="text" size="20" value="John Spencer" data-conekta="card[name]">
					# Tarjeta: <input type="text" size="20" value="5555555555554444" data-conekta="card[number]">
					CVC: <input type="text" size="4" value="123" data-conekta="card[cvc]">
					Fecha de expiración (MM/AAAA) <input type="text" size="2" value="05" data-conekta="card[exp_month]"><input type="text" size="4" value="2018" data-conekta="card[exp_year]">
						
						 <input name="tel" type="text" size="20" value="+5213353319758">
						 <input name="email" type="text" size="20" value="email@email.com">
						 
					<button class="button green expanded">Pagar</button>
				</form>
			</div>
			
		</div>
	
	</div>

	<div id="oxxo" class="checkout">
		
		<div class="content row no-margin">
			<div class="large-8 columns no-padding">
				<h3>Pago en oxxo</h3>
			
			</div>
			<div class="large-4 columns">
			
				<form action="/oxxo" method="POST">
					 <input name="room" type="text" size="20" value="sala 12">
					 <input name="price" type="text" size="20" value="10000">
					 <input name="quantity" type="text" size="20" value="3">
					 
					 <input name="name" type="text" size="20" value="John Spencer">
					 <input name="tel" type="text" size="20" value="+5213353319758">
					 <input name="email" type="text" size="20" value="email@email.com">
					<button class="button green expanded">Pagar</button>
				</form>
			</div>
			
		</div>
	
	</div>
@endsection
@section('scripts')
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
</script>
<script type="text/javascript" >
$(document).ready(function() {
	$('.checkout').hide();
	  $('body').on('change', '#sel-type', function(event) {
	  	var item = $(this).val();
	  	$('.checkout').hide();
	  	$('#'+item).show();


	});
});
</script>

	
@endsection