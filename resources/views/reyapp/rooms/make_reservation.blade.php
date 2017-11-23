@extends('layouts.reyapp.main')

@section('styles')
	<link rel="stylesheet" href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}">
@endsection
@section('content')

<div class="row desktop">
	<div class="large-12 columns no-padding">
		<div class="timer_bar_wrapper">
			<div class="timer_bar"></div>
			<div class="timer_bar_text">Esta ventana se recargará en 5 minutos</div>
		</div>
	</div>
	<div class="large-9 columns no-padding calendar-wrapper">
		<div class="calendar-header">
			<h1>{{$room->companies->name}}</h1>
			<h2>{{$room->name}} (${{$room->price}}/Hora)</h2>
		</div>
		<div id='calendar'></div>
	</div>

	<div class="large-3 columns no-padding">
		<div class="reservation-desktop">
			<div class="total-hours display">
				
				<div class="number">
					0 
				</div>
				<div class="text">Horas reservadas</div>
			</div>
			<div class="total-price display">
				<div class="text">Costo total</div>
				<div class="number">
					$0
				</div>
			</div>
			<div class="clarification display">
					@if($user->bands->count() > 1)
						<label for="">
							Elige tu banda <i class="fa fa-question-circle hastooltip" aria-hidden="true" title="Le llegará un aviso a los miembros de tu banda"></i>
						</label>
						<select  name="band" class="band" id="" >
							<option value="">Banda...</option>
							@foreach($bands as $band)
								<option selected value="{{$band->id}}">{{$band->name}}</option>
							@endforeach
						</select>
					@endif
					<label for="">Método de pago</label>
					<select name="payment_method" id="" class="payment_method">
						<option value="">Método de pago</option>
						<option value="credit_card">Tarjeta de Crédito o débito</option>
						<option value="oxxo">Pago en Oxxo</option>

					</select>

					{{-- STARTS: Oxxo form --}}
					<div class="oxxo method">
						<form id="oxxo-form" action="/oxxo" method="POST">
							{{ csrf_field() }}
						
							<input type="hidden" name="events" class="events">
							<input type="hidden" name="room_id" class="room_id" value="{{$room->id}}">

							<input type="hidden" name="amount" class="amount" value="">

							<label for="">Nombre </label>
							<input name="name" type="text" size="20" value="{{$user->name}} {{$user->lastname}}">
							
							<label for="">Teléfono</label>
							<input name="phone" type="text" size="20" value="{{$user->phone}}">
								
							<label for="">Email:</label>
							<input name="email" type="text" size="20" value="{{$user->email}}">
								
							<button type="submit" class="button green expanded">Reservar</button>
							
						</form>
					</div>
					{{-- ENDS: Oxxo form --}}
					
					{{--STARTS: Form CARD --}}
					<div class="credit_card method">
						<form action="/card" method="POST" id="card-form">
							{{ csrf_field() }}

							<input type="hidden" name="events" class="events">
							<input type="hidden" name="room_id" class="room_id" value="{{$room->id}}">
							<input type="hidden" name="amount" class="amount" value="">

							<label>
								Nombre <i class="fa fa-question-circle hastooltip" aria-hidden="true" title="Como aparece en la tarjeta"></i>
							</label>
							<input name="name" type="text" size="20" value="{{$user->name}} {{$user->lastname}}" data-conekta="card[name]">
					
							<label for="">Teléfono</label>
							<input name="phone" type="text" size="20" value="{{$user->phone}}">
								
							<label for="">Email:</label>
							<input name="email" type="text" size="20" value="{{$user->email}}">

							<label>
								Número de Tarjeta <i class="fa fa-question-circle hastooltip" aria-hidden="true" title="16 dígitos"></i>
							</label>
							<input type="text" size="20" value="" data-conekta="card[number]" name="card_number">
							
							<label>
								CVC
								<i class="fa fa-question-circle hastooltip" aria-hidden="true" title="3 dígitos que aparecen en el reverso"></i>
							</label>
							<input type="text" size="4" value="123" data-conekta="card[cvc]" name="cvc">
							
							<label>Fecha de expiración (MM/AAAA)</label>
							<div class="large-6 columns no-padding">
								<select data-conekta="card[exp_month]" name="month" id="">
									<option value="">Mes</option>
									<option value="01">Enero</option>
									<option value="02">Febrero</option>
									<option value="03">Marzo</option>
									<option value="04">Abril</option>
									<option value="05">Mayo</option>
									<option value="06">Junio</option>
									<option value="07">Julio</option>
									<option value="08">Agosto</option>
									<option value="09">Septiembre</option>
									<option value="10">Octubre</option>
									<option value="11">Noviembre</option>
									<option value="12">Diciembre</option>
								</select>	
							</div>
							<div class="large-6 columns no-padding">
								<select data-conekta="card[exp_year]" name="year" id="">
									<option value="">Año</option>
									<option value="2017">2017</option>
									<option value="2018">2018</option>
									<option value="2019">2019</option>
									<option value="2020">2020</option>
									<option value="2021">2021</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
									<option value="2025">2025</option>
									<option value="2026">2026</option>
									<option value="2027">2027</option>
									<option value="2028">2028</option>
									<option value="2029">2029</option>
								</select>
							</div>
							
								
							<input name="tel" type="hidden" size="20" value="+5213353319758">
							<input name="email" type="hidden" size="20" value="email@email.com">
							<br style="clear: both">
							<button type="submit" class="checkout button green expanded">Reservar</button>
						</form>
						

						
					
				</div>
				{{--ENDS: Form CARD --}}
					
				
			</div>
		</div>
		
	</div>
	
</div>
@endsection
@section('scripts')
	<script src="{{asset('plugins/fullcalendar/lib/moment.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
	<script src="{{asset('plugins/fullcalendar/locale/es.js')}}"></script>
	<script src="{{asset('plugins/underscore/underscore-min.js')}}"></script>
	<script src="{{asset('plugins/validation/jquery.validate.min.js')}}"></script>
	<script src="{{asset('plugins/validation/messages.js')}}"></script>
	<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>

	<script src="{{asset('js/calendar_set.js')}}"></script>

	<script>
		var schedule_start = {{$room->schedule_start}};
		var schedule_end   = {{$room->schedule_end}};
		var room_price 	   = {{$room->price}};
		var room_id		   = {{$room->id}};
		var reservations   = [];
		var hidden		   = [];
		var days = [0,1, 2, 3, 4, 5, 6];

		@if($user->bands->count() < 1)
			title = '{{$user->name}} {{$user->lastname}}';
 		@endif

		hidden = _.difference(days,[{{$room->days}}]);

		@foreach($reservations as $reservation)
			reservations.push({
					'id'    	: {{$reservation->id}},
					'title' 	: 'Ocupado',
					'start' 	: '{{$reservation->starts}}',
					'end'   	: '{{$reservation->ends}}',
					'className' : 'occupied', 
			});
		@endforeach  
	
		Conekta.setPublishableKey("{{env('CONEKTA_PUBLIC_KEY')}}");

		var conektaSuccessResponseHandler = function(token) {
			var $form = $("#card-form");
			//Inserta el token_id en la forma para que se envíe al servidor
			$form.append($('<input type="hidden" name="token" id="conektaTokenId">').val(token.id));
			
			checkout();
			data = $form.serialize();
			conection('POST',data,'/card',true).then(function(answer){
				if(answer.success == true){
					window.location.replace("/confirmacion/"+answer.code);
					
				}else{
					
					show_message('error','¡Error!',answer.message);
				}
    		});
		};
		var conektaErrorResponseHandler = function(response) {
			var $form = $("#card-form");
			$form.find(".card-errors").text(response.message_to_purchaser);
			$form.find("button").prop("disabled", false);
		};

		
		

		$(document).ready(function(){
			$( ".payment_method" ).change(function() {
				if($(this).val()== 'credit_card'){
					$('.credit_card').fadeIn('slow');
					$('.oxxo').fadeOut('fast');
				}else if($(this).val()== 'oxxo'){
					$('.oxxo').fadeIn('slow');
					$('.credit_card').fadeOut('fast');
				}else if($(this).val()== ''){
					$('.oxxo').fadeOut('fast');
					$('.credit_card').fadeOut('fast');
				}
			});
		});

		$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
		$("#card-form").validate({
			rules:{
				name:'required',
				card_number:{
					required:true,
					digits:true,
					minlength: 16,
					maxlength:16
				},
				cvc:{
					required:true,
					digits:true,
					minlength: 3,
					maxlength: 4,
				},
				month:'required',
				year:'required',
				amount: 'required'
			},
			submitHandler: function(form) {
    			
				$('.loader-wrapper').css('display','block');
				Conekta.token.create(form, conektaSuccessResponseHandler, conektaErrorResponseHandler);

  			},
  			
		});

		$("#oxxo-form").validate({
			rules:{
				name:'required',
				phone:{
					required:true,
					minlength:10
				},
				email:{
					email:true,
					required:true
				},
				amount: 'required'
			},
			submitHandler: function(form) {
    			$('.loader-wrapper').css('display','block');
    			checkout();
    			data = $(form).serialize();
				conection('POST',data,'/oxxo',true).then(function(answer){
					if(answer.success == true){
						window.location.replace("/confirmacion/"+answer.code);
					
					}else{
						console.log(answer.message[0]['errorStack']);
						show_message('error','¡Error!',answer.message[0]['errorStack']);
					}
    			});


  			},
  			
		});
</script>
	
	
@endsection