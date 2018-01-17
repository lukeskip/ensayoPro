@extends('layouts.reyapp.main')
@section('body_class', 'dashboard')
@section('content')
	<div class="row">
		<form action="">
			<div class="input-group">
				<input name="buscar" class="input-group-field" type="text">
				<div class="input-group-button">
					<input  type="submit" class="button black" value="Buscar">
				</div>
			</div>
		</form>
	</div>
	<div class="row">

		

		{{-- STARTS: Salas --}}
		<div class="large-12 columns reservations">
			<div class="row list-header">
				<div class="medium-12-columns">
					<h3>Usuarios</h3>
				</div>
				<div class="medium-3 columns show-for-medium">
					Nombre 
				</div>
				<div class="medium-4 columns show-for-medium">
					Email
				</div>
				<div class="medium-2 columns show-for-medium">
					Rol
				</div>
				<div class="medium-3 columns show-for-medium">
					Status
				</div>
			</div>
			@foreach($users as $user)
				<div class="row list-item">
					<div class="medium-3 columns">
						<a href="/usuarios/{{$user->id}}">{{$user->name}} {{$user->lastname}}</a>
					</div>
					<div class="medium-4 columns">
						{{$user->email}}
					</div>
					<div class="medium-2 columns ">
						{{$user->roles->first()->name}}
					</div>
					<div class="medium-3 columns status">
						@if($user->active)
							<i class="fa fa-check-circle-o confirmed hastooltip" title="Activa" aria-hidden="true"></i>
						@else
							<i class="fa fa-times-circle-o hastooltip cancelled" title="Inactiva" aria-hidden="true"></i>
						@endif
					</div>
				</div>
			@endforeach
		</div>
		<div class="row">
			<div class="large-12 columns">
				{!! $users->appends(Request::capture()->except('page'))->render() !!}
			</div>
		</div>
		{{-- ENDS: Salas --}}
	</div>
	

	
@endsection


