@extends('layouts.reyapp.main')
@section('styles')
<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.css')}}">
<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/swal-forms.css')}}">
@endsection
@section('body_class', 'dashboard')
@section('content')
	
	<div class="row">

		

		{{-- STARTS: Salas --}}
		<div class="large-12 columns reservations">
			<div class="row list-header">
				<div class="medium-12-columns">
					<h3>Salas de Ensayo</h3>
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
						@if($room->ratings)
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
		</div>
		<div class="row">
			<div class="large-12 columns">
				{!! $rooms->appends(Request::capture()->except('page'))->render() !!}
			</div>
		</div>
		{{-- ENDS: Salas --}}
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

