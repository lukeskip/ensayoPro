@extends('layouts.reyapp.main')

@section('content')
	<h1>Promociones</h1>
	<div class="row">
		<div class="medium-9 columns">
				<div class="row list-header show-for-medium">
					<div class="medium-3 columns">
						Descripción:
					</div>
					<div class="medium-3 columns">
						Validez:
					</div>
					<div class="medium-3 columns">
						Descuento:
					</div>
					<div class="medium-3 columns">
						Estatus:
					</div>
				</div>
				@if(!$promotions->isEmpty())
					@foreach ($promotions as $promotion)
						<div class="row list-item room-item">
							<div class="medium-3 columns">

								
								{{$promotion->name}} 
								
					
								
							</div>
							<div class="medium-3 columns text-center">
								{{$promotion->finishs}}
							</div>
							<div class="medium-3 columns text-center">
								@if($promotion->type == 'direct')
									${{$promotion->value}}
								@elseif ($promotion->type == 'percentage')
									{{$promotion->value}}%
								@endif
							</div>
							<div class="medium-3 columns status">
								@if($promotion->status == 'active')
									<i class="fa fa-check-circle-o confirmed hastooltip" title="Activa" aria-hidden="true"></i>
								@elseif($promotion->status == 'draft')
									<i class="fa fa-pencil-square-o hastooltip pending" aria-hidden="true" title="Borrador"></i>
								@endif
							</div>

						</div>
					@endforeach
				@else
					<div class="row list-item">
						<div class="large-12 columnsaa">
							Aún no has registrado ninguna promoción para tus salas
						</div>
					</div>
				@endif
		</div>
		<div class="medium-3 columns">
			<a href="/company/promociones/registro" class="button expanded green">Registrar Promoción</a>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			{!! $promotions->appends(Request::capture()->except('page'))->render() !!}
		</div>
	</div>		
	
@endsection

@section('scripts')
<script>
	
</script>
	
@endsection

