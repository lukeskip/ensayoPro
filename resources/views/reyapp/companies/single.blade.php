@extends('layouts.reyapp.main')

@section('content')
<div class="company-single">
	<div class="row">
		<div class="large-12 columns">
			<h1>Salas de {{$company->name}}</h1>	
		</div>
		<div class="large-12 columns">
			
		</div>
	</div>			
	<div class="row">
		<div class="medium-3 columns">
			<a href="/company/registro/salas" class="button expanded green">Registrar Sala</a>
		</div>
	</div>
	<div class="row">
		<div class="medium-12 columns">
				<div class="row list-header show-for-medium">
					<div class="medium-3 columns">
						Nombre/Marca:
					</div>
					<div class="medium-2 columns">
						Color:
					</div>
					<div class="medium-3 columns">
						Calificación:
					</div>
					<div class="medium-3 columns">
						Precio/Hora:
					</div>
					<div class="medium-1 columns">
						Estatus:
					</div>
				</div>
				@foreach ($rooms as $room)
				<div class="row list-item room-item">
					<div class="medium-3 columns text-center">

						{{$room->companies->name}} ({{$room->name}})
						
						<div class="info">
							<a href="/company/salas/ajustes/{{$room->id}}" class="tag blue">Editar</a href="#">
							<a href="/salas/{{$room->id}}" class="tag blue">Ver</a href="#">
							<a href="/admin/salas/eliminar/{{$room->id}}" class="tag blue delete" data-id="{{$room->id}}">Eliminar</a href="#">
						</div>
						
					</div>
					<div class="medium-2 columns text-center">
						<div class="color" style="background: {{$room->color}}"></div>
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
							<div class="clarification">
								Basado en {{$room->ratings}} calificación(es)
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

					<div class="medium-1 columns price">
						<div class="medium-2 columns status">
							@if($room->status == 'active')
								<i class="fa fa-check-circle-o confirmed hastooltip" title="Activa" aria-hidden="true"></i>
							@elseif($room->status == 'inactive')
								<i class="fa fa-clock-o hastooltip pending" aria-hidden="true" title="Inactiva"></i>
							@elseif($room->status == 'deleted')
								<i class="fa fa-times-circle-o hastooltip cancelled" title="Cancelada" aria-hidden="true"></i>
							@endif
						</div>
					</div>

				</div>
				@endforeach
		</div>
		
	</div>
</div>	
@endsection

@section('scripts')

	<script>
		$(document).ready(function(){

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

		    $('.room-item .delete').click(function(e){
		    	e.preventDefault();
		    	var id = $(this).data('id');
		    	swal({
					title: "¿Estas seguro?",
					text: "Esta acción no se puede revertir.",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#36A939',
					confirmButtonText: 'Sí, elimínalo!',
					cancelButtonText: "No, cancelar!",
					cancelButtonColor: '#CD2B37'
				}).then(function() {
					// $('.loader-wrapper').css('display','block');
					
					conection('GET','','/admin/salas/eliminar/'+id,true).then(function(answer){
						if(answer.success == true){
							location.reload();
						}else{
							show_message('error','¡Error!',answer.message);
						}
	    			});
				},function(dismiss) {
					
				});

		    });
		});
	</script>
@endsection

