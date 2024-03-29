@extends('layouts.reyapp.main')

@section('content')
	<h2>Compañías</h2>
	<div class="row">
		<div class="large-12 columns">
				<div class="row list-header show-for-medium">
					<div class="medium-6 columns">
						Nombre/Marca:
					</div>
					<div class="medium-2 columns">
						Acepta Online:
					</div>
					<div class="medium-4 columns">
						Estatus:
					</div>
				</div>
				@foreach ($companies as $company)
				<div class="row list-item room-item">
					<div class="medium-6 columns text-center">

						<a href="/company/datalle/{{$company->id}}">{{$company->name}}</a>
						<div class="info">
							<a href="/admin/company/ajustes/{{$company->id}}" class="blue tag">
								Editar
							</a href="#">
							<a href="/company/datalle/{{$company->id}}" class="blue tag">Ver</a href="#">
							{{-- <a href="#" class="discount">Descuento -20%</a href="#"> --}}
						</div>
						
					</div>
					<div class="medium-2 columns status">
						@if($company->reservation_opt)
							<i class="fa fa-check-circle-o confirmed hastooltip" title="Acepta reservaciones" aria-hidden="true"></i>
						@else
							<i class="fa fa-times-circle-o hastooltip cancelled" title="No acepta reservaciones" aria-hidden="true"></i>
						@endif

					</div>
					<div class="medium-2 columns status">
								
						@if($company->status == 'active')
							<i class="fa fa-check-circle-o confirmed hastooltip" title="Activa" aria-hidden="true"></i>
						@elseif($company->status == 'inactive')
							<i class="fa fa-clock-o hastooltip" aria-hidden="true" title="Inactiva"></i>
						@elseif($company->status == 'paused')
							<i class="fa fa-pause hastooltip pending" aria-hidden="true" title="Pausada"></i>
						@elseif($company->status == 'deleted')
							<i class="fa fa-times-circle-o hastooltip cancelled" title="Cancelada" aria-hidden="true"></i>
						@endif
						
					</div>

				</div>
				@endforeach
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			{!! $companies->appends(Request::capture()->except('page'))->render() !!}
		</div>
	</div>
@endsection

@section('scripts')
<script src="{{asset('plugins/bar-rating/jquery.barrating.min.js')}}"></script>
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
	});
</script>
	
@endsection
