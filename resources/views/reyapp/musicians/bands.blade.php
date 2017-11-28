@extends('layouts.reyapp.main')
@section('body_class', 'dashboard')
@section('content')
	<div class="row">
		<div class="large-12 columns">
			<a href="/registro/banda" class="button green">Registrar Banda</a>
		</div>
		{{-- STARTS: reservaciones --}}
		<div class="large-12 columns">
				<div class="row list-header">
					<div class="medium-12-columns">
						<h3>Tus bandas</h3>
					</div>
					<div class="medium-4 columns show-for-medium">
						Nombre 
					</div>
					<div class="medium-8 columns show-for-medium">
						Miembros
					</div>
				</div>
				@if(!$bands->isEmpty())
					@foreach($bands as $band)
						<div class="row list-item">
							<div class="medium-4 columns">
								@if($band->registrant == Auth::user()->id)
									<a href="/musico/bandas/{{$band->id}}">{{$band->name}}</a>
								@else
									{{$band->name}}
								@endif 
							</div>
							<div class="medium-8 columns text-left">
								@foreach($band->users as $user)
									@if($user->name != '')
										<div class="tag green small">{{$user->name}}</div>
									@else
										<div class="tag black small unregistered hastooltip" title="Aún no culmina su registro">
											{{$user->email}}
										</div>
									@endif
								@endforeach 
							</div>
							

						</div>
					@endforeach
				@else
					<div class="row list-item">
						<div class="large-12 columnsaa">
							Aún no has registrado una banda
						</div>
					</div>
				@endif
				
		</div>
		
	</div>
	
	
@endsection

