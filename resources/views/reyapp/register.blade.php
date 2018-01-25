@extends('layouts.reyapp.main')

@section('content')
<div class="form_wrapper">
	

	<form class="form-horizontal" method="POST" action="{{ route('register') }}">
		{{ csrf_field() }}
		
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
				
					
					<label>Nombre</label>
					
					<input class="input-group-field" type="text" name="name" value="{{ old('name') }}" placeholder="Fulano">
					@if ($errors->has('name'))
						<label class="error">
							<strong>{{ $errors->first('name') }}</strong>
						</label>
					@endif
				
			</div>

			<div class="large-6 columns {{ $errors->has('lastname') ? ' has-error' : '' }}">
				
					<label>Apellido</label>
					<input class="input-group-field" type="text" name="lastname" value="{{ old('lastname') }}" placeholder="García">

					@if ($errors->has('lastname'))
						<label class="error">
							<strong>{{ $errors->first('lastname') }}</strong>
						</label>
					@endif
				
			</div>

		</div>

		<div class="row {{ $errors->has('email') ? ' has-error' : '' }}">
			
			<div class="large-6 columns">
				
					<label>Email</label>
					<input class="input-group-field" type="text" name="email" value="{{ old('email') }}" placeholder="correo@correo.com">

					@if ($errors->has('email'))
						<label class="error">
							<strong>{{ $errors->first('email') }}</strong>
						</label>
					@endif
			</div>

			<div class="large-6 columns">
				
					<label>Teléfono</label>
					<input class="input-group-field" type="text" name="phone" value="{{ old('phone') }}" placeholder="555-555-55">

					@if ($errors->has('email'))
						<label class="error">
							<strong>{{ $errors->first('phone') }}</strong>
						</label>
					@endif
			</div>

		</div>

		<div class="row {{ $errors->has('password') ? ' has-error' : '' }}">
		   
			<div class="large-6 columns">

					<label>Contraseña:</label>
					<input class="input-group-field" type="password" name="password" placeholder="elije una contraseña">
					@if ($errors->has('password'))
						<label class="error">
							<strong>{{ $errors->first('password') }}</strong>
						</label>
					@endif
			</div>

			<div class="large-6 columns">
				<label>Repite la contraseña:</label>

				<input class="input-group-field" type="password" name="password_confirmation" placeholder="confirma tu contraseña">

				@if ($errors->has('password_confirmation'))
					<label class="error">
						<strong>{{ $errors->first('password_confirmation') }}</strong>
					</label>
				@endif
			</div>

		</div>
		<hr>
		<div class="row">
			<div class="medium-4 columns text-center">
				{!! Captcha::display() !!}
				@if ($errors->has('g-recaptcha-response'))
					<label class="error">
						<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
					</label>
				@endif
			</div>
			<div class="medium-8 columns">
				<div class="disclaimer">
					Haciendo click en "Registrar" aceptas los <strong><a href="/terminos_y_condiciones">Términos y Condiciones</a></strong> así como el <strong><a href="/aviso-de-privacidad">Aviso de Privacidad</a></strong> que puedes visitar en los enlaces antes mencionados, además aceptas que Rey Decibel a través de EnsayoPro te contacte a tu correo para temas propios de la plataforma.
				</div>
			</div>
		</div>
		<hr>
		<div class="row ">
			<div class="large-12 columns">
				<button type="submit" class="button expanded green">
					Registrar
				</button>
				
			</div>
		</div>
	</form>
</div>
@endsection
