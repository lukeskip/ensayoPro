@extends('layouts.reyapp.payment')

@section('content')

<form action="/your-server-side-code" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="pk_test_6pRNASCoBOKtIshFeQd4XMUh"
    data-amount="999"
    data-name="Stripe.com"
    data-description="Widget"
    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
    data-locale="auto"
    data-zip-code="true">
  </script>
</form>

@endsection

@section('scripts')
<script>
	// Conekta.setPublishableKey("key_JeZAXurkTuQBxPhthGxshLw");
	// var successResponseHandler = function(token) {
	//   	console.log(token);
	// };

	// var errorResponseHandler = function(error) {
	//   console.log(error);
	// };

	// var tokenParams = {
	//   "card": {
	//     "number": "4242424242424242",
	//     "name": "Fulanito Pérez",
	//     "exp_year": "2020",
	//     "exp_month": "12",
	//     "cvc": "123",
	//     "address": {
	//         "street1": "Calle 123 Int 404",
	//         "street2": "Col. Condesa",
	//         "city": "Ciudad de Mexico",
	//         "state": "Distrito Federal",
	//         "zip": "12345",
	//         "country": "Mexico"
	//      }
	//   }
	// };

	// Conekta.token.create(tokenParams, successResponseHandler, errorResponseHandler);

</script>

<script type="text/javascript" >
  Conekta.setPublishableKey('key_JeZAXurkTuQBxPhthGxshLw');

  var conektaSuccessResponseHandler = function(token) {
    var $form = $("#card-form");
    //Inserta el token_id en la forma para que se envíe al servidor
    $form.append($("<input type="hidden" id="conektaTokenId">").val(token.id));
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
@endsection