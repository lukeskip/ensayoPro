@extends('layouts.reyapp.main')
@section('styles')
<link rel="stylesheet" href="{{asset('plugins/bar-rating/themes/fontawesome-stars.css')}}">
@endsection
@section('metatags')
		<meta property="og:url" content="http://ensayopro.com.mx" />
		<meta property="og:title"              content="EnsayoPro" />
		<meta property="og:description"        content="Renta la sala de ensayo que más te convenga, las mejores opciones en la ciudad de méxico, guadalajara, monterrey" />
		<meta property="og:image"              content="{{asset('img/facebook_share.png')}}" />

		<meta name="csrf-token" content="{{ csrf_token() }}">

		<meta name="description" content="Renta la sala de ensayo que más te convenga en la Ciudad de México, muchas opciones" />
		<meta name="keywords" content="Salas de Ensayo DF, cuartos de ensayo, las mejores salas de ensayo, disqueras independientes" />
		<meta name="author" content="Rey Decibel">
		<meta name="robots" content="index, follow">
		<meta name="revisit-after" content="1 month">
@endsection
@section('content')
	<div class="row">
		<div class="large-10 columns text-center large-centered">
			<img src="{{asset('img/logo_cabeza_ensayo.png')}}" width="500px" alt="">
			<h1 style="font-size:1.5em;">ENCUENTRA LA MEJOR SALA DE ENSAYO PARA TU BANDA INDEPENDIENTE</h1>
			Las disqueras independientes buscan seriedad, profesionaliza tu proyecto con una sala de ensayo, busca tu favorita, por ubicación, equipamiento, calificación o precio, tu banda te lo agradecerá. Regístrate y obtén beneficios exclusivos para tu banda independiente. Si tienes una sala de ensayos y quieres integrarte a esta lista <a href="/unete">da click aquí</a>
			<br><br>
			
		</div>
	</div>
	<form id="order_form" class="search" method="get" action="/salas">
		{{-- <img src="{{asset('img/salas-de-ensayo.png')}}" width="100%" alt=""> --}}
		<div class="row">
			<div class="medium-12 columns no-padding padding-right end">
				<div class="input-group">
				  <input class="input-group-field" type="text" name='buscar' value="{{request('buscar')}}" placeholder="Por equipamiento o nombre">
				  <div class="input-group-button">
				    <input type="submit" class="button green" value="Buscar">
				  </div>
				</div>
			</div>
		</div>
	
		
		<div class="row">
			{{-- STARTS:Hidden fields --}}

			@if(request()->has('colonia'))
				<input type="hidden" name="colonia" value="{{request('colonia')}}">
			@endif

			{{-- ENDS:Hidden fields --}}
			<div class="medium-4 columns no-padding padding-right">
				
				<div class="input-group">
					<span class="input-group-label">
						Ciudad:
					</span>
					<select class="input-group-field change_submit" name="ciudad" class="area">
						<option value="">Todas</option>
						@foreach($cities as $city)
							<option @if(request('ciudad') == $city->city) {{'selected'}} @endif value="{{$city->city}}">{{$city->city}}</option>
						@endforeach
					</select>
				</div>
				
			</div>

			<div class="medium-4 columns no-padding">
				
				<div class="input-group">
					<span class="input-group-label">
						Ordernar:
					</span>
					<select class="input-group-field change_submit" name="order" id="order_input">
						<option @if(request('order') == 'quality_down') selected @endif value="quality_down">Mejores calificados</option>
						<option @if(request('order') == 'quality_up') selected @endif value="quality_up">Peores calificados</option>
						<option @if(request('order') == 'price_up') selected @endif value="price_up">Precio más bajo</option>
						<option @if(request('order') == 'price_down') selected @endif value="price_down">Precio más alto</option>
						{{-- <option value="discounts">Ofertas</option> --}}
					</select>
				</div>
				
			</div>
		
			
			<div class="medium-4 columns no-padding padding-left">
				
				<div class="input-group">
					<span class="input-group-label">
						Ubicación:
					</span>
					<select class="input-group-field change_submit" name="deleg" class="area">
						<option value="">Todas</option>
						@foreach($deputations as $deputation)
							<option @if(request('deleg') == $deputation->deputation) {{'selected'}} @endif value="{{$deputation->deputation}}">{{$deputation->deputation}}</option>
						@endforeach
					</select>
				</div>
				
			</div>
		</div>
	</form>
		
	
	<div class="row">
		<div class="large-12 columns">
				<div class="row list-header show-for-medium">
					<div class="medium-6 columns">
						Nombre/Marca:
					</div>
					<div class="medium-3 columns">
						Califiación:
					</div>
					<div class="medium-3 columns">
						Precio/Hora:
					</div>
				</div>
				@foreach ($rooms as $room)
				<div class="row list-item room-item">
					<div class="medium-6 columns"> 
					@if(!$room->is_admin)
						@if($room->companies->reservation_opt and $room->types->name == "room" and $room->companies->status == "active")
							<span class="tag green">
								<i class="fa fa-calendar hastooltip" title="Esta sala acepta reservaciones en línea"></i>
							</span>
						@endif
						@if(!Auth::guest())
							@if ($role == 'admin')
								<a href="/admin/salas/ajustes/{{$room->id}}"> {{$room->companies->name}} ({{$room->name}})</a>
							@else
								<a href="/salas/{{$room->id}}">{{ $room->companies->name }} ({{$room->name}})</a>
							@endif
						@else
							<a href="/salas/{{$room->id}}">{{ $room->companies->name }} ({{$room->name}})</a>
						@endif
					@else

						@if ($role == 'admin')
							<a href="/admin/salas/ajustes/{{$room->id}}"> {{$room->company_name}} ({{$room->name}})</a>
						@else
							<a href="/salas/{{$room->id}}">{{ $room->company_name }} ({{$room->name}})</a>
						@endif

					@endif

						
						
						<div class="info">
							@if($role == 'admin')
								<a href="/salas/{{$room->id}}" class="green tag blue">
									Ver
								</a href="#">
							@endif
							
							@foreach($room->promotions as $promotion)
								<a href="#" class="tag green hastooltip" title="{{$promotion->description}}">
								 	<i class="fa fa-tags"></i> 
								 	{{$promotion->tag}}
								</a href="#">
							@endforeach
								
						
							<a href="/salas/?ciudad={{$room->city}}" class="city tag blue">{{$room->city}}</a href="#">
							<a href="/salas/?colonia={{$room->colony}}" class="colony tag">{{$room->colony}}</a href="#">
							<a href="/salas/?deleg={{$room->deputation}}" class="deputation tag">{{$room->deputation}}</a href="#">
							
							{{-- <a href="#" class="discount">Descuento -20%</a href="#"> --}}
						</div>
						
					</div>
					<div class="medium-3 columns rating_wrapper">
								
						@if($room->ratings > 0)
							<select name="" data-score="{{$room->score}}" class="rating">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
							<div class="clarification">
								Basado en {{$room->total_ratings}} calificación(es)
							</div>
							
						@else

							<div class="text-center">
								 Esta sala aún no tiene calificaciones
							</div>
						@endif
						
					</div>
					<div class="medium-3 columns price">
						${{$room->price}}
					</div>

				</div>
				@endforeach
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			{!! $rooms->appends(Request::capture()->except('page'))->render() !!}
		</div>
	</div>


@endsection

@section('scripts')
<script src="{{asset('plugins/bar-rating/jquery.barrating.min.js')}}"></script>
<script>
	$(document).ready(function(){

		$( ".change_submit" ).change(function() {
  			$('#order_form').submit();
		});

		$('.rating').each(function() {
	        $(this).barrating({
				theme: 'fontawesome-stars',
				readonly:true,
				initialRating:$(this).data('score'),
				onSelect:function(value, text, event){
					console.log(value);
				}
			});
	    });

	    @if(Auth::guest())
			if (sessionStorage.getItem('loggin_invitation') !== 'true') {
				login();
				sessionStorage.setItem('loggin_invitation','true');
			}
		@endif

		function login (){
			swal({
			  title: 'Logéate',
			  imageUrl: '{{asset('img/logo_ensayo.png')}}',
			  html: 'Para comentar y califcar las salas o estudios, solo es un click! <br><a href="{{url('/redirect')}}" style="margin-top:20px;" class="button facebook expanded"><i class="fa fa-facebook"></i>      Login con Facebook</a>',
			  showCloseButton: true,
			  showConfirmButton: false,
			  focusConfirm: false,
			});
		}
	});
</script>
	
@endsection

