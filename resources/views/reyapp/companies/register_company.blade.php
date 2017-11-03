@extends('layouts.reyapp.landing')

@section('content')
<div class="form_wrapper">
	<form id="form_comp">
		{{ csrf_field() }}
		
		<input type="hidden" name="latitude" class="latitude">
		<input type="hidden" name="longitude" class="longitude">

		<div class="row">
			<div class="large-12 columns">
				<div class="step">
					<div class="description">Paso</div>
					<div class="number">2</div>
				</div>
				<h1>Registra tu marca</h1>
				<h2>Posteriormente tendrás que registrar cada una de la salas o cuartos de ensayo operando bajo esta marca.</h2>

				<p class="text-center">Los campos marcados con un (*) son requeridos</p>
			</div>
		</div>
		<div class="row">
			<div class="large-12 columns">
				<h3>Información general</h3>
			</div>
			<div class="large-12 columns">
				<label>Nombre Comercial (*)</label>
				<input class="input-group-field required" type="text" name="name">
			</div>

			
		</div>		

		{{-- STARTS: ADDRESS ZONE --}}
		<div class="new_address">

			<div class="row">
				<div class="large-8 columns">
					
					<label>Dirección (*)</label>
					<input class="input-group-field address get_loc required" type="text" name="address" placeholder="Calle y número">
					
				</div>
				
				<div class="large-4 columns">
					<label>Delegación o municipio (*)</label>
					<input class="input-group-field deputation get_loc required" type="text" name="deputation" placeholder="Delegación o municipio">
				</div>

			</div>

			<div class="row">
				
				<div class="large-4 columns">
					<label>Colonia (*)</label>	
					<input class="input-group-field colony get_loc required" type="text" name="colony">
				</div>

				<div class="large-4 columns">
					<label>Teléfono (*)</label>
					<input class="input-group-field required" type="text" name="phone">
				</div>

				<div class="large-4 columns">
					<label>Código Postal (*)</label>
					<input class="input-group-field postal_code get_loc required" type="text" name="postal_code">
				</div>
			</div>

			<div class="row">
				<div class="large-6 columns">
					<label>Ciudad (*)</label>	
					<input class="input-group-field city get_loc required" type="text" name="city">
				</div>

				<div class="large-6 columns">
					<label>País (*)</label>	
					<select class="input-group-field country get_loc required" name="country" id="">
						<option value="mexico">México</option>
					</select>
				</div>

				
			</div>

			<div class="row">
				<div class="large-12 columns">
					<h3>Información Fiscal</h3>
					<p>Estos campos son opcionales solo temporalmente, pronto tendrás que llenar esta información</p>
				</div>
				<div class="large-6 columns">
					<label>Razón Social</label>	
					<input class="input-group-field city get_loc" type="text" name="legalname">
				</div>

				<div class="large-6 columns">
					<label>RFC</label>	
					<input class="input-group-field city get_loc" type="text" name="rfc">
				</div>

				
			</div>
		</div>
		{{-- ENDS: ADDRESS ZONE --}}
		
		<div class="row">
			<div class="large-12 columns">
				<h3>Información bancaria</h3>
			</div>
			
			<div class="large-4 columns">
				
				<label>CLABE Interbancaria (*)
					<i class="fa fa-question-circle hastooltip" title="Utilizaremos esta información para depositar tus pagos, revisa muy bien este dato" aria-hidden="true"></i>
				</label>	
				<input class="input-group-field required" type="text" name="clabe">
				
			</div>
			<div class="large-4 columns">
				
				<label>Nombre completo del titular (*)
					<i class="fa fa-question-circle hastooltip" title="Utilizaremos esta información para depositar tus pagos, revisa muy bien este dato" aria-hidden="true"></i>
				</label>	
				<input class="input-group-field required" type="text" name="account_holder">
				
			</div>

			<div class="large-4 columns">
				
				<label>Entidad Bancaria (*)
					<i class="fa fa-question-circle hastooltip" title="Utilizaremos esta información para depositar tus pagos, revisa muy bien este dato" aria-hidden="true"></i>
				</label>	
				<input class="input-group-field required" type="text" name="bank_entity">
				
			</div>

		</div>

		<div class="row">
			
			<div class="large-12 columns">
				<div class="clarification text-center">
					Verifica la ubicación, corrígela arrastrando el pin
				</div>
				<div id="map-canvas"></div>
			</div>
		</div>

		
				


		<div class="row ">
			<div class="large-12 columns">
				<br><br>
				<button type="submit" class="button expanded green">
					Registrar
				</button>
			</div>
		</div>

	</form>
</div>
@endsection
@section('scripts')
	<script src="{{asset('plugins/validation/jquery.validate.min.js')}}"></script>
	<script src="{{asset('plugins/validation/messages.js')}}"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMMiHmdWoL0K5FQPWL_cXBbK0IV-t7l3w"></script>
	<script src="{{asset('js/get_loc.js')}}"></script>
	<script>
		$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
		$('#form_comp').validate({
			rules:{
				clabe:{
					required :true,
					digits   : true

				}
			},
			submitHandler: function(form) {
    			data = $(form).serialize();
    			conection('POST',data,'/company/companies',true).then(function(answer){
    				if(answer.success == true){
    					window.location.replace("/company");
    				}
    			});
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