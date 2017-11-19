@extends('layouts.reyapp.main')

@section('content')
<div class="form_wrapper">
	<form id="band_data" class="form-horizontal" method="POST" action="{{ route('register') }}">
		{{ csrf_field() }}
						
		<div class="row">
			<div class="large-12 columns">
				<div class="step">
					<div class="description">Paso</div>
					<div class="number">2</div>
				</div>
				<h1>Registra tu banda</h1>
				<p class="text-center">
					Al registrar tu banda y sus miembros, les llegará un aviso con la fecha del ensayo que reserves, así será más fácil tener sincronía con tu banda
				</p>
			</div>
		</div>
		
		
		
		<div class="row">
			<div class="large-12 column">
				<h2>Datos de tu banda</h2>
			</div>
			<div class="large-6 columns input_band_member">
				<label>Nombre</label>
				<input class="input-group-field" name="name" type="text" placeholder="ej.  Led Zeppelin">
			</div>

			<div class="large-6 columns input_band_member">
				
				<label>Género</label>
				<select class="input-group-field required" name="genre" id="">
				  <option value="">Selecciona...</option>
				  <option value="rock">Rock</option>
				  <option value="pop">Pop</option>
				  <option value="latin">Ritmos Latinos</option>
				  <option value="jazz">Jazz</option>
				  <option value="blues">Blues</option>
				</select>
				
					
			</div>
		</div>
	
	
	
		<div class="row" class="band_register">
			<div class="large-12 columns">
				<h3>Correos de los miembros de tu banda</h3>
				<p>Pueden o no estar inscritos en esta plataforma</p>
			</div>
			<div class="large-12 columns input_band_member">
				<div class="input-group">
					<span class="input-group-label">
						Email
					</span>
				  <input class="input-group-field member required" type="email" placeholder="ej. guitarrista@correo.com" name="email">
				</div>
				
			</div>

			<div id="paste"></div>

			<div class="large-12 columns">
				<div class="add member hastooltip" title="Registra a todos lo miembros de tu banda para matenerlos informados de reservaciones de ensayo">
					<i class="fa fa-address-card-o" aria-hidden="true"></i> Agregar otro miembro
				</div>
			</div>

		</div>
		
		
		{{-- HIDDEN FIELD TO CLONE --}}
		<div class="hidden">
			<div class="large-12 columns input_band_member_clone">
				<div class="input-group">
					<span class="input-group-label">
						Email
					</span>
				  <input class="input-group-field member" type="text" placeholder="ej. guitarrista@correo.com" name="email">
				</div>
				
			</div>
		</div>
		{{-- HIDDEN FIELD TO CLONE --}}

		<br><br>
		<div class="row ">
			<div class="large-6 columns">
				<button type="submit" class="button expanded green register_band">
					Registrar
				</button>
			</div>

			<div class="large-6 columns">
				<a  class="button expanded" href="/musico/bienvenido">
					Saltar, lo haré luego
				</a>
			</div>
		</div>
	</form>
</div>	
@endsection
@section('scripts')	
	<script src="{{asset('plugins/validation/jquery.validate.min.js')}}"></script>
	<script src="{{asset('plugins/validation/messages.js')}}"></script>
	
	<script>
		
		$('#band_data').validate({
			submitHandler: function(form) {
    			register_band ();
  			},
  			errorPlacement: function(error, element) {
    		if(element[0].name == "days[]"){
    			console.log(element.parent().find('label.error'));

    		}else{
    			error.insertAfter(element);
    		}
    		
		}
		});

		

	</script>
	

@endsection
