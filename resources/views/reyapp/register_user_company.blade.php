@extends('layouts.reyapp.landing')

@section('content')
	<form class="form-horizontal" method="POST" action="{{ route('register') }}">
		{{ csrf_field() }}

		<input name="role" type="hidden" value="{{$role}}">
		
		<div class="row">
			<div class="large-12 columns">
				<div class="step">
					<div class="description">Paso</div>
					<div class="number">1</div>
				</div>
				<h1>Regístrate</h1>
			</div>
		</div>
		<div class="row">

			<div class="large-6 columns {{ $errors->has('name') ? ' has-error' : '' }}">
				<div class="input-group">
					<span class="input-group-label">
						Nombre:
					</span>
				  <input class="input-group-field" type="text" name="name" placeholder="Fulano">
				</div>
			</div>

			<div class="large-6 columns {{ $errors->has('lastname') ? ' has-error' : '' }}">
				<div class="input-group">
					<span class="input-group-label">
						Apellido:
					</span>
				  <input class="input-group-field" type="text" name="lastname" placeholder="García">
				</div>
			</div>

		</div>

		<div class="row {{ $errors->has('email') ? ' has-error' : '' }}">
			
			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						Email:
					</span>
				  <input class="input-group-field" type="text" name="email" placeholder="correo@correo.com">
				</div>
			</div>

		</div>

		<div class="row {{ $errors->has('password') ? ' has-error' : '' }}">
		   
			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						Contraseña:
					</span>
				  <input class="input-group-field" type="password" name="password" placeholder="elije una contraseña">
				</div>
			</div>

		</div>

		<div class="row ">
			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						Contraseña:
					</span>
				  <input class="input-group-field" type="password" name="password_confirmation" placeholder="confirma tu contraseña">
				</div>
			</div>

		</div>

		<div class="row ">
			<div class="large-12 columns">
				<button type="submit" class="button expanded green">
					Registrar
				</button>
			</div>
		</div>
	</form>
@endsection
