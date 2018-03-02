@extends('layouts.reyapp.main')

@section('styles')
	<link rel="stylesheet" href="{{asset('plugins/lightbox/css/lightbox.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/bar-rating/themes/fontawesome-stars-o.css')}}">
@endsection

@section('content')
<div class="room-item room-single">

	<div class="row">
		
	
		<div class="large-8 columns info">
			
			<h1 class="text-left">{{$room->companies->name}}</h1>
			<h2 class="text-left">
				{{$room->name}}
				<span class="price">
					${{$room->price}}/hora
				</span>
			</h2>
			

			
			<div class="tags">
				<a href="/salas/?colonia={{$room->colony}}" class="colony">{{$room->colony}}</a>
				<a href="/salas/?deleg={{$room->deputation}}" class="deputation">{{$room->deputation}}</a>
			</div>
			<br>
			
			
			<div class="hide-for-large">
				<br><br>
				<div class="text-center">
					<label for="">@if($room->score) Califica esta sala @else Sé el primero en calificar esta sala @endif</label>
					<select name="rating" class="hidden rating">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
				@if($reservation_opt)
					<a href="reservando/{{$room->id}}" class="button expanded green">Reservar esta sala</a>
				@endif

				@if($room->promotions)
					<h3 class="list-header green">
						<i class="fa fa-tags"></i>
						PROMOCIONES VIGENTES (*)
					</h3>
					<div class="promotions">
						
						@foreach($room->promotions as $promotion)
							<div class="promotion">
							<i class="fa fa-tags"></i>
								{{$promotion->description}}

							</div>
						@endforeach
						<div class="disclaimer">
							* Sólo una promoción por transacción, se eligirá automáticamente según convenga al cliente
						</div>
					</div>
				@endif
			</div>
			
			
			<div class="full-address">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
				{{$room->address}},
				{{$room->colony}},
				{{$room->deputation}},
				{{$room->postal_code}},
				{{$room->companies->phone}}
			</div>
			<div class="description">
				<p>{{$room->description}}</p>
			</div>
			
			<div class="equipment">
				<h3 class="list-header">EQUIPAMIENTO</h3>
				<ul>
					@foreach($room->equipment as $equipment)
						<li class="list-item">{{$equipment}}</li>
					@endforeach
				</ul>
				@if($room->media_items->count())
				<h3 class="list-header">Imágenes</h3>
				
					<div class="images">
						@foreach($room->media_items as $image)

							<a class="image" href="{{url('imagenes/'.$image->name)}}" data-lightbox="{{$room->name}}">
								<img src="{{url('imagenes/'.$image->name)}}" />
							</a>
				
						@endforeach
					</div>
				@endif
			</div>
			

		</div>

		<div class="large-4 columns location">
			<div class="show-for-large">
				<div class="text-center">
					<label for="">Califica esta sala</label>
					<select name="rating" class="hidden rating">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
				@if($reservation_opt)
					<a href="reservando/{{$room->id}}" class="button expanded green">Reservar esta sala</a>
				@endif

				@if($room->promotions->count())
					<h3 class="list-header green">
						<i class="fa fa-tags"></i>
						PROMOCIONES VIGENTES (*)
					</h3>
					<div class="promotions">
						
						@foreach($room->promotions as $promotion)
							<div class="promotion">
							<i class="fa fa-tags"></i>
								<span class="title">{{$promotion->name}}</span>
								{{$promotion->description}}

							</div>
						@endforeach
						<div class="disclaimer">
							* Sólo una promoción por transacción, se eligirá automáticamente según convenga al cliente
						</div>
					</div>
				@endif
			</div>
			<h3 class="list-header">Ubicación</h3>
			<div id="map"></div>
			
			
		</div>

		<div class="large-12 columns">
			<div class="comments-wrapper">
				<h3 class="list-header">OPINIONES</h3>
					<div class="comment-form">
						@if (!Auth::guest())
						<form id="form-comment" action="">
							<h3 class="title text-left">Deja una opinión</h3>
							<label for="">Título:</label>
							<input type="text" name="title">
							<label for="">Opinión:</label>
							<textarea name="description" id=""></textarea>
							<input type="hidden" name="room_id" value="{{$room->id}}">
							<button class="black button comment-submit">Enviar</button>
						</form>
						@else
						<h3 style="color: #333">Logéate para dejar una opinión</h3>
						@endif
					</div>
					<div class="comments">
						
						@foreach($room->comments as $comment)
							{{-- Si el comentarios está aprobado o pertenece al usuario que lo creo, estará visible --}}
							@if($comment->status == 'approved' or $user == $comment->user_id)
							<div class="comment {{$comment->status}} @if(Request::get('comentario') == $comment->id){{'active'}} @endif  " data-id="{{$comment->id}}">

								<div class="title">{{$comment->title}}</div>
								<div class="description">
									{{$comment->description}}
								</div>
								<div class="sign">

									{{$comment->author}} 
									<span class="date">{{$comment->created_at->format('d/m/Y')}}</span>
									@if(!Auth::guest())
									@if(Auth::user()->id == $comment->user_id)
										<a href="#" class="delete delete-comment" data-id="{{$comment->id}}" >
											Eliminar comentario
										</a>
									@endif
								@endif
								</div>
							</div>
							@else

							@endif

						@endforeach

					</div>
					
			</div>
		</div>

		

	</div>
	
	
	
</div>
	

@endsection
@section('scripts')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMMiHmdWoL0K5FQPWL_cXBbK0IV-t7l3w"></script>
	<script src="{{asset('plugins/lightbox/js/lightbox-plus-jquery.min.js')}}"></script>
	<script src="{{asset('plugins/gmaps/gmaps.js')}}"></script>
	<script src="{{asset('plugins/bar-rating/jquery.barrating.min.js')}}"></script>
	<script>

	$(document).ready(function(){
		
		// creamos el mapa con las coordenadas guardadas
		// $('#map').height($('.info').height());

		

		@if(Auth::guest())
			swal({
			  title: 'Logéate',
			  imageUrl: '{{asset('img/logo_ensayo.png')}}',
			  html: 'Para comentar y califcar esta sala <br><a href="{{url('/redirect')}}" target="_black" style="margin-top:20px;" class="button facebook expanded"><i class="fa fa-facebook"></i>      Login con Facebook</a>',
			  showCloseButton: true,
			  showConfirmButton: false,
			  focusConfirm: false,
			});


		@endif

		map = new GMaps({
	        div: '#map',
	        lat: {{$room->latitude}},
	        lng: {{$room->longitude}}
      	});

      	map.addMarker({
		  lat: {{$room->latitude}},
		  lng: {{$room->longitude}},
		  title: 'Lima',
		  click: function(e) {
		    alert('You clicked in this marker');
		  }
		});


        $('.rating').barrating({
			theme: 'fontawesome-stars-o',
			initialRating:@if($room->score){{$room->score}} @else 0 @endif,
			onSelect:function(value, text, event){
				data = {'score':value,'room_id':{{$room->id}},'description':text };
				conection('POST',data,'/ratings');
			}
		});

		$('.comment-submit').click(function(e){
			e.preventDefault();
			data = $('#form-comment').serialize();
			conection('POST',data,'/comentarios',true).then(function(data){
				if(data.success == true){
					$('.comments').prepend('<div class="comment '+data.class+'"><div class="title">'+data.title+'</div><div class="description">'+data.description+'</div><div class="sign">'+data.author+' <span class="date">'+data.date+'</span></div></div>');
					resetForm($('#form-comment'));	
				}else{
					show_message('error','Error',data.message);
				}
				
			})
		});

		$('.delete-comment').click(function(e){
			e.preventDefault();
			conection('DELETE',$(this).data('id'),'/comentarios/'+$(this).data('id'),true).then(function(data){
				if(data.success == true){
					$('a[data-id='+data.id+']').parent().parent().remove();	
				}else{
					show_message('error','Error',data.message);
				}
				
			})
			
		});


		
	    




		
	});
	</script>
@endsection