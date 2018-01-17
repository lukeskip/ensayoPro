@extends('layouts.reyapp.main')
@section('styles')
<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.css')}}">
<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/swal-forms.css')}}">
@endsection
@section('body_class', 'dashboard')
@section('content')
	<div class="form_wrapper">
		<form action="">
			<div class="row">
				<div class="medium-4 columns no-padding padding-right end">
					
					<label for="">Buscar</label>
					<input class="input-group-field" type="text" name='buscar' value="{{request('buscar')}}">
					

				</div>

				<div class="medium-4 columns no-padding padding-right end">
					
					<label for="">Monto</label>
					<div id="slider-range"></div>
					<input type="text" id="amount" class="slider_number" readonly style="border:0;background: none; color:#FFFFFF; font-weight:bold;box-shadow:none;text-align: center">
					

				</div>

				<div class="medium-4 columns no-padding padding-right end">
					
					<label for="">Fecha</label>
					<div class="medium-6 columns no-padding">
						<input type="text" id="from" name="from" placeholder="Desde"> 	
					</div>
					<div class="medium-6 columns no-padding">
						<input type="text" id="to" name="to" placeholder="Hasta">	
					</div>
					
					
					

				</div>

				<div class="medium-12 columns no-padding padding-right end">
					
					<button type="submit" class="button expanded green">Buscar</button>
					

				</div>
			</div>
		</form>
	</div>

	<div class="row">
		
		{{-- STARTS: Comentarios --}}
		<div class="large-12 columns">
				<div class="row list-header">
					<div class="medium-12-columns">
						<h3>Pagos</h3>
					</div>
					<div class="large-3 columns show-for-large">
						Fecha
					</div>
					<div class="large-2 columns show-for-large">
						Método
					</div>
					<div class="large-2 columns show-for-large">
						Monto
					</div>
					<div class="large-3 columns show-for-large">
						Order Id
					</div>
					<div class="large-2 columns show-for-large">
						Status
					</div>
				</div>
				@foreach($payments as $payment)
					<div class="row list-item ">
						<div class="large-3 columns ">
							<a href="/admin/pagos/{{$payment->order_id}}">{{$payment->date}}</a>
						</div>
						<div class="large-2 columns ">
							{{$payment->method}}
						</div>
						<div class="large-2 columns ">
							${{$payment->total}}
						</div>
						<div class="large-3 columns ">
							{{$payment->order_id}}
						</div>
						<div class="large-2 columns status">

							@if($payment->status == 'paid')
								<i class="fa fa-check-circle-o confirmed hastooltip" title="Aprobado" aria-hidden="true"></i>
							@elseif($payment->status == 'pending_payment')
								<i class="fa fa-clock-o hastooltip pending" aria-hidden="true" title="Pendiente"></i>
							@elseif($payment->status == 'rejected')
								<i class="fa fa-times-circle-o hastooltip cancelled" title="Rechazado" aria-hidden="true"></i>
							@endif

						</div>

					</div>
				@endforeach
				
		</div>
	
		{{-- ENDS: Comentarios --}}

	</div>

	<div class="row">
		<div class="large-12 columns">
			{!! $payments->appends(Request::capture()->except('page'))->render() !!}
		</div>
	</div>
	

	
@endsection

@section('scripts')
<script src="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.js')}}"></script>
<script src="{{asset('plugins/swal-forms-master/swal-forms.js')}}"></script>

<script>
	$( function() {
	    $( "#slider-range" ).slider({
	      range: true,
	      min: 0,
	      max: {{$max}},
	      step: 50,
	      // values: [ {{request('from')}}, {{request('to')}} ],
	      slide: function( event, ui ) {
	        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
	      }
	    });
	    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
	      " - $" + $( "#slider-range" ).slider( "values", 1 ) );

		var dateFormat = "mm/dd/yy",
		from = $( "#from" )
			.datepicker({
			  defaultDate: "+1w",
			  changeMonth: true,
			  numberOfMonths: 1
			})
			.on( "change", function() {
			  to.datepicker( "option", "minDate", getDate( this ) );
			}),
			to = $( "#to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1
			})
			.on( "change", function() {
			from.datepicker( "option", "maxDate", getDate( this ) );
			});

			function getDate( element ) {
			var date;
			try {
			date = $.datepicker.parseDate( dateFormat, element.value );
			} catch( error ) {
			date = null;
			}

			return date;
		}

  } );


</script>
	
@endsection

