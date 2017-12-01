@extends('layouts.reyapp.main')
@section('styles')
<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.css')}}">
<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/swal-forms.css')}}">
@endsection
@section('body_class', 'dashboard')
@section('content')
	
	
	<div class="row">
		
		{{-- STARTS: Comentarios --}}
		<div class="large-12 columns">
				<div class="row list-header">
					<div class="medium-12-columns">
						<h3>Pagos</h3>
					</div>
					<div class="medium-3 columns show-for-medium">
						Fecha
					</div>
					<div class="medium-2 columns show-for-medium">
						Método
					</div>
					<div class="medium-2 columns show-for-medium">
						Monto
					</div>
					<div class="medium-3 columns show-for-medium">
						Order Id
					</div>
					<div class="medium-2 columns show-for-medium">
						Status
					</div>
				</div>
				@foreach($payments as $payment)
					<div class="row list-item ">
						<div class="medium-3 columns ">
							<a href="/admin/pagos/{{$payment->order_id}}">{{$payment->date}}</a>
						</div>
						<div class="medium-2 columns ">
							{{$payment->method}}
						</div>
						<div class="medium-2 columns ">
							${{$payment->amount}}
						</div>
						<div class="medium-3 columns ">
							{{$payment->order_id}}
						</div>
						<div class="medium-2 columns status">

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
	
@endsection

