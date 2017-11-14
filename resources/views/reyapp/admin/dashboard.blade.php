@extends('layouts.reyapp.main')
@section('styles')
<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.css')}}">
<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/swal-forms.css')}}">
@endsection;
@section('body_class', 'dashboard')
@section('content')
	

	
	<div class="row">
		
		{{-- STARTS: Comentarios --}}
		<div class="large-12 columns">
				<div class="row list-header">
					<div class="medium-12-columns">
						<h3>Comentarios Pendientes</h3>
					</div>
					<div class="medium-3 columns show-for-medium">
						Sala/Compañía
					</div>
					<div class="medium-7 columns show-for-medium">
						Descripción
					</div>
					<div class="medium-2 columns show-for-medium">
						Estatus
					</div>
				</div>
				@foreach($comments as $comment)
					<div class="row list-item " 
						
					>
						<div class="medium-3 columns ">
							<a href="/salas/{{$comment->rooms->id}}">
								{{$comment->rooms->name}}
							</a>
							<a href="/admin/company/{{$comment->rooms->companies->id}}">
								({{$comment->rooms->companies->name}})
							</a>
							
						</div>
						<div class="medium-7 columns ">
							<span class="more">
								<strong style="color:black">{{$comment->title}}</strong>
								{{$comment->description}}
							</span>
							
						</div>
						<div class="medium-2 columns status">
							<a class="comment_form" href="#"
								data-id="{{$comment->id}}" 
								data-title="{{$comment->description}}"
								data-status="{{$comment->status}}"
							>

								@if($comment->status == 'approved')
									<i class="fa fa-check-circle-o confirmed hastooltip" title="Aprobado" aria-hidden="true"></i>
								@elseif($comment->status == 'pending')
									<i class="fa fa-clock-o hastooltip pending" aria-hidden="true" title="Pendiente"></i>
								@elseif($comment->status == 'rejected')
									<i class="fa fa-times-circle-o hastooltip cancelled" title="Rechazado" aria-hidden="true"></i>
								@endif

							</a>
						</div>

					</div>
				@endforeach

			<div class="row">
				<div class="large-12 columns text-center">
					<br>
					<a class="button black" href="/admin/comentarios">Ver todos</a>
				</div>
			</div>
				
		</div>
	
		{{-- ENDS: Comentarios --}}

		{{-- STARTS: reservaciones --}}
		<div class="large-12 columns reservations end">
				<div class="row list-header">
					<div class="medium-12-columns">
						<h3>Últimas reservaciones</h3>
					</div>
					<div class="medium-3 columns show-for-medium">
						Usuario 
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
						Status
					</div>
				</div>
				@foreach($reservations as $reservation)
					<div class="row list-item">
						<div class="medium-3 columns">

							<span>
								{{$reservation->users->name}} {{$reservation->users->lastname}}
							</span>
							
						</div>
						<div class="medium-3 columns ">
							@if($reservation->bands->count() > 0)
								{{$reservation->bands->first()->name}}
							@elseif($reservation->description!='')
								{{$reservation->description}}
							@else
								{{'Sin banda'}}
							@endif
						</div>
						<div class="medium-2 columns ">
							{{$reservation->rooms->name}}
						</div>
						<div class="medium-2 columns price">
							{{$reservation->price}}
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

			<div class="row">
				<div class="large-12 columns text-center">
					<br>
					<a class="button black" href="/admin/reservaciones">Ver todas</a>
				</div>
			</div>
				
		</div>
	
		{{-- ENDS: reservaciones --}}

		{{-- STARTS: reservaciones --}}
	
		<div class="large-12 columns reservations">
			<div class="row list-header">
				<div class="medium-12-columns">
					<h3>Mejores salas</h3>
				</div>
				<div class="medium-4 columns show-for-medium">
					Sala 
				</div>
				<div class="medium-3 columns show-for-medium">
					Precio
				</div>
				<div class="medium-3 columns show-for-medium">
					Calificación
				</div>
				<div class="medium-2 columns show-for-medium">
					Status
				</div>
			</div>
			@foreach($rooms as $room)
				<div class="row list-item">
					<div class="medium-4 columns">
						<a href="/salas/{{$room->id}}">{{$room->name}}</a>
					</div>
					<div class="medium-3 columns ">
						${{$room->price}}
					</div>
					<div class="medium-3 columns ">
						@if($room->ratings > 0)
							<select name="" data-score="{{$room->score}}" class="rating">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
							
						@else

							<div class="text-center">
								 Esta sala aún no tiene calificaciones
							</div>
						@endif
					</div>
					<div class="medium-2 columns status">
						@if($room->status == 'active')
							<i class="fa fa-check-circle-o confirmed hastooltip" title="Activa" aria-hidden="true"></i>
						@elseif($room->status == 'inactive')
							<i class="fa fa-clock-o hastooltip pending" aria-hidden="true" title="Inactiva"></i>
						@elseif($room->status == 'cancelled')
							<i class="fa fa-times-circle-o hastooltip cancelled" title="Cancelada" aria-hidden="true"></i>
						@endif
					</div>

				</div>
			@endforeach
			<div class="row">
				<div class="large-12 columns text-center">
					<br>
					<a class="button black" href="/admin/salas">Ver todas</a>
				</div>
			</div>
		</div>
		{{-- ENDS: reservaciones --}}
	</div>
	

	
@endsection

@section('scripts')
<script src="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.js')}}"></script>
<script src="{{asset('plugins/swal-forms-master/swal-forms.js')}}"></script>
<script>
	$(document).ready(function(){

		$('.comment_form').click(function(){
			var id 			= $(this).data('id');
			var title 		= $(this).data('title');
			var status 		= $(this).data('status');
			var description = $(this).data('description');
			open_form_comment(id,title,description,status);
		});

		function open_form_comment(id,title,description,status){
			var options = []
			
			var status_init = {
				"pending"	:"Pendiente",
  				"approved": "Aprobado",
  				"rejected"	:"Rechazado"
			};

			$.each( status_init, function( key, value ) {
			  	if(key == status){
					console.log(key);
					options.push({
						'selected' :'true',
						'value' : key,
						'text' 	: value 
					});
				}else{
					options.push({
						'value' : key,
						'text' 	: value 
					});
				}
			  	

				
			});
			
			console.log(options);

			swal.withFormAsync({
				    title: title,
				    showCancelButton: true,
				    confirmButtonColor: '#2FAB31',
				    confirmButtonText: 'Guardar',
				    closeOnConfirm: true,
				    customClass: 'comment-swal',
				    formFields: [
						{ id: 'id', type:'hidden', value:id},
						{ id: 'status',
							type: 'select',
							options: options
						}
					]
				  }).then(function (context) {
				  	if(context._isConfirm){
				  		conection('PUT',context.swalForm,'/admin/comentarios/'+id,true).then(function(data) {
	  						if(data.success == true){
								window.location.reload();
							}else{
								show_message('error','¡Error!',data.message);
							}
						});
		
				  	}
				    
				  });

		}
		
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
	});
</script>
	
@endsection

