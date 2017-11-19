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
					<div class="medium-4 columns show-for-medium">
						Género
					</div>
					<div class="medium-4 columns show-for-medium">
						Miembros
					</div>
				</div>
				@foreach($bands as $band)
					<div class="row list-item">
						<div class="medium-4 columns">
							<a href="/musico/bandas/{{$band->id}}">{{$band->name}}</a> 
						</div>
						<div class="medium-4 columns ">
							{{$band->genre}} 
						</div>
						<div class="medium-4 columns ">
							@foreach($band->users as $user)
								@if($user->name != '')
									<div>{{$user->name}} {{$user->lastname}}</div>
								@else
									<div class="unregistered hastooltip" title="Aún no culmina su registro">
										{{$user->email}}
									</div>
								@endif
							@endforeach 
						</div>
						

					</div>
				@endforeach
				
		</div>
		
	</div>
	
	
@endsection

