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
						<h3>Comentarios</h3>
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
				
		</div>
	
		{{-- ENDS: Comentarios --}}

	</div>

	<div class="row">
		<div class="large-12 columns">
			{!! $comments->appends(Request::capture()->except('page'))->render() !!}
		</div>
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
		

	});
</script>
	
@endsection

