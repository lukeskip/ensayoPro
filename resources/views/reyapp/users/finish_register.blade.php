@extends('layouts.reyapp.main')

@section('content')
<div class="form_wrapper">
	
	<h1>Finaliza tu registro</h1>
	<form class="form-horizontal" method="PUT" action="/usuarios/{{$user->id}}">
		{{ csrf_field() }}
		
		<div class="row">

			<div class="large-6 columns {{ $errors->has('name') ? ' has-error' : '' }}">
				
					
					<label>Nombre:</label>
					
					<input class="input-group-field" type="text" name="name" value="{{$user->name}}" placeholder="Fulano">
					@if ($errors->has('name'))
						<label class="error">
							<strong>{{ $errors->first('name') }}</strong>
						</label>
					@endif
				
			</div>

			<div class="large-6 columns {{ $errors->has('lastname') ? ' has-error' : '' }}">
				
					<label>Apellido:</label>
					<input class="input-group-field" type="text" name="lastname" value="{{ $user->lastname }}" placeholder="García">

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
					<input class="input-group-field" type="text" name="email" value="{{$user->email}}" placeholder="correo@correo.com">

					@if ($errors->has('email'))
						<label class="error">
							<strong>{{ $errors->first('email') }}</strong>
						</label>
					@endif
			</div>

			<div class="large-6 columns">
				
					<label>Teléfono</label>
					<input class="input-group-field" type="text" name="phone" value="{{$user->phone}}" placeholder="555-5555-55">

					@if ($errors->has('phone'))
						<label class="error">
							<strong>{{ $errors->first('phone') }}</strong>
						</label>
					@endif
			</div>

		</div>

		<div class="row {{ $errors->has('password') ? ' has-error' : '' }}">
			<div class="large-12 columns">
				<h3>Elije tu contraseña</h3>
			</div>

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
		<div class="row ">
			<div class="large-12 columns">
				<button type="submit" class="button expanded green send">
					Guardar
				</button>
				
			</div>
		</div>
	</form>

</div>
@endsection
@section('scripts')
<script>
	
	$(document).ready(function(){
		$('.send').click(function(e){
			e.preventDefault();
			data = $('form').serialize();
			conection('PUT', data,'/usuarios/'+{{$user->id}},true).then(function(data){
				if(data.success){
					window.location.reload();
				}else{
					show_message('error','¡Error!',data.messages)
				}
			});
		});
	});
	
</script>
@endsection
