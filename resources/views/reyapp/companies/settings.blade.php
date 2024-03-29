@extends('layouts.reyapp.main')
@section('content')
@if($company)
<div class="form_wrapper">
	<form id="form_comp">
		{{ csrf_field() }}
		
		<input type="hidden" name="latitude" class="latitude">
		<input type="hidden" name="longitude" class="longitude">

		<div class="row">
			<div class="large-12 columns">
				
				<h1>Edita los datos de la marca</h1>
				<p class="text-center">Los campos marcados con un (*) son requeridos</p>
			</div>
		</div>
		<div class="row">
			<div class="large-12 columns">
				<h3>Información general</h3>
			</div>
			<div class="@if($role == 'admin'){{'large-4'}}@else{{'large-6'}}@endif columns">
				<label>Nombre Comercial (*)</label>
				<input class="input-group-field required" type="text" name="name" value="{{$company->name}}">
			</div>

			<div class="@if($role == 'admin'){{'large-4'}}@else{{'large-6'}}@endif columns">
				<div class="reservation_opt">
					<div class="label_opt">
						Aceptar reservaciones
						<i class="fa fa-question-circle hastooltip" title="Tendrás que ser habilitado por un administrador de EnsayoPRO" aria-hidden="true"></i>
					</div>
					<div class="switch @if($company->reservation_opt == true) on @endif"></div>
					
				</div>
				<input class="input-group-field required reservation_opt" type="hidden" name="reservation_opt" value="{{$company->reservation_opt}}">
			</div>
			
			@if($role == 'admin')
			<div class="large-4 columns">
				<label for="">Estatus</label>
				<select name="status" id="">
					<option @if($company->status == 'active') {{'selected'}} @endif value="active">
						Activo
					</option>
					<option @if($company->status == 'paused') {{'selected'}} @endif value="paused">
						En pausa
					</option>
					<option @if($company->status == 'inactive') {{'selected'}} @endif value="inactive">Inactivo</option>
					<option @if($company->status == 'deleted') {{'selected'}} @endif value="deleted">Borrado</option>
				</select>
			</div>
			@endif
			
		</div>		

		{{-- STARTS: ADDRESS ZONE --}}
		<div class="new_address">

			<div class="row">
				<div class="large-8 columns">
					
					<label>Dirección (*)</label>
					<input class="input-group-field address get_loc required" type="text" name="address" placeholder="Calle y número" value="{{$company->address}}">
					
				</div>
				
				<div class="large-4 columns">
					<label>Delegación o municipio (*)</label>
					<input class="input-group-field deputation get_loc required" type="text" name="deputation" placeholder="Delegación o municipio" value="{{$company->deputation}}">
				</div>

			</div>

			<div class="row">
				
				<div class="large-4 columns">
					<label>Colonia (*)</label>	
					<input class="input-group-field colony get_loc required" type="text" name="colony" value="{{$company->colony}}">
				</div>

				<div class="large-4 columns">
					<label>Teléfono (*)</label>
					<input class="input-group-field required" type="text" name="phone" value="{{$company->phone}}">
				</div>

				<div class="large-4 columns">
					<label>Código Postal (*)</label>
					<input class="input-group-field postal_code get_loc required" type="text" name="postal_code" value="{{$company->postal_code}}">
				</div>
			</div>

			<div class="row">
				
				<div class="large-6 columns">
					<label>Página web</label>	
					<input class="input-group-field colony get_loc " type="text" name="webpage" value="{{$company->webpage}}">
				</div>

				<div class="large-6 columns">
					<label>Facebook</label>
					<input class="input-group-field" type="text" name="facebook" value="{{$company->facebook}}">
				</div>
			</div>

			<div class="row">
				<div class="large-6 columns">	
					<label>Estado (*)</label>	
					<select class="required" name="city" id="">
						<option @if($company->city == 'Ciudad de México'){{'selected'}}@endif value="Ciudad de México">
							Ciudad de México (CDMX)
						</option>
						<option @if($company->city == 'Estado de México'){{'selected'}}@endif value="Estado de México">
							Estado de México
						</option>
						<option @if($company->city == 'Jalisco'){{'selected'}} @endif value="Jalisco">
							Jalisco
						</option>
						<option @if($company->city == 'Nuevo León'){{'selected'}} @endif value="Nuevo León">
							Nuevo León
						</option>
					</select>
				</div>

				<div class="large-6 columns">
					<label>País (*)</label>	
					<select class="input-group-field country get_loc required" name="country" id="">
						<option value="mexico">México</option>
					</select>
				</div>

				
			</div>

			<div class="row tax_info @if($company->reservation_opt != true) {{'hidden'}} @endif">
				<div class="large-12 columns">
					<h3>Información Fiscal</h3>
					<p>Estos campos son opcionales solo temporalmente, pronto tendrás que llenar esta información</p>
				</div>
				<div class="large-6 columns">
					<label>Razón Social</label>	
					<input class="input-group-field city get_loc" type="text" name="legalname" 
					value="{{$company->legalname}}">
				</div>

				<div class="large-6 columns">
					<label>RFC</label>	
					<input class="input-group-field city get_loc" type="text" name="rfc" value="{{$company->rfc}}">
				</div>

				
			</div>
		</div>
		{{-- ENDS: ADDRESS ZONE --}}
		
		<div class="row tax_info @if($company->reservation_opt != true) {{'hidden'}} @endif">
			<div class="large-12 columns">
				<h3>Información bancaria</h3>
			</div>
			
			<div class="large-4 columns">
				
				<label>CLABE Interbancaria (*)
					<i class="fa fa-question-circle hastooltip" title="Utilizaremos esta información para depositar tus pagos, revisa muy bien este dato" aria-hidden="true"></i>
				</label>	
				<input class="input-group-field required" type="text" name="clabe" value="{{$company->clabe}}">
				
			</div>
			<div class="large-4 columns">
				
				<label>Nombre completo del titular (*)
					<i class="fa fa-question-circle hastooltip" title="Utilizaremos esta información para depositar tus pagos, revisa muy bien este dato" aria-hidden="true"></i>
				</label>	
				<input class="input-group-field required" type="text" name="account_holder" value="{{$company->account_holder}}">
				
			</div>

			<div class="large-4 columns">
				
				<label>Entidad Bancaria (*)
					<i class="fa fa-question-circle hastooltip" title="Utilizaremos esta información para depositar tus pagos, revisa muy bien este dato" aria-hidden="true"></i>
				</label>	
				<input class="input-group-field required" type="text" name="bank" value="{{$company->bank}}">
				
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
					Guardar Información
				</button>
			</div>
		</div>

	</form>
</div>
@else
<div class="row">
	<div class="large-12 columns text-center">
		<h1>Primero registra tu compañía</h1>
		<a class="button green" href="/company/registro">Registrar Compañía</a>
	</div>
</div>
@endif

@endsection
@section('scripts')
	<script src="{{asset('plugins/validation/jquery.validate.min.js')}}"></script>
	<script src="{{asset('plugins/validation/messages.js')}}"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMMiHmdWoL0K5FQPWL_cXBbK0IV-t7l3w"></script>
@if($company)
	<script>

		var initMarker = {lat: {{$company->latitude}}, lng: {{$company->longitude}}};
		var editmode 	= true;	

	</script>
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
    			conection('PUT',data,'/company/companies/{{$company->id}}',true).then(function(answer){
    				if(answer.success == true){
    					show_message('success','¡Listo!','Los datos fueron guardados correctamente');
    				}else{
    					show_message('error', 'Error','Los datos no fueron guardados. '+ answer[0]['name'])
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
		if('{{$company->status}}' == 'Inactiva'){
			show_message('warning','Atención','Los datos de tu compañía están siendo validados, por lo que aún no está activa');
		}
	</script>
@endif
@endsection