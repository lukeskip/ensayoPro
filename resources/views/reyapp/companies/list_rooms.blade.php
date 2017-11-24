@extends('layouts.reyapp.main')

@section('content')
			
	<div class="row">
		<div class="medium-9 columns">
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
				@if(!$rooms->isEmpty())
					@foreach ($rooms as $room)
						<div class="row list-item room-item">
							<div class="medium-6 columns">

								
								{{$room->companies->name}} ({{$room->name}})
								
								<div class="info">
									<a href="/company/salas/editar/{{$room->id}}" class="tag blue">Editar</a href="#">
									<a href="/salas/{{$room->id}}" class="tag blue">Ver</a href="#">
									{{-- <a href="#" class="discount">Descuento -20%</a href="#"> --}}
								</div>
								
							</div>
							<div class="medium-3 columns ">
								@if($room->opinions > 0)
									<div class="skillbar clearfix " data-percent="{{$room->score}}%" >
										<div class="skillbar-bar"></div>
									</div>
									<div class="text-center">
										 {{$room->opinions}} calificaciones
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
				@else
					<div class="row list-item">
						<div class="large-12 columnsaa">
							Aún no has registrado una sala
						</div>
					</div>
				@endif
		</div>
		<div class="medium-3 columns">
			<a href="/company/registro/salas" class="button expanded green">Registrar Sala</a>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			{!! $rooms->appends(Request::capture()->except('page'))->render() !!}
		</div>
	</div>
@endsection

@section('scripts')
<script>
	$(document).ready(function(){
		$('.skillbar').each(function(){
			$(this).find('.skillbar-bar').animate({
				width:$(this).attr('data-percent')
			},3000);
		});
	});
</script>
	
@endsection

