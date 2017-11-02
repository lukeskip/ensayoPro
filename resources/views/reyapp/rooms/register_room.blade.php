@extends('layouts.reyapp.main')
@section('header')

{{-- STARTS: fine Uploader --}}
		
		<script type="text/template" id="qq-template">
		    <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
		        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
		            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
		        </div>
		        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
		            
		            <span class="qq-upload-drop-area-text-selector">
		            	
		            </span>
		        </div>
		        <div class="qq-upload-button-selector qq-upload-button">
		            <div>Sube tus imágenes</div>
		        </div>
		        <span class="qq-drop-processing-selector qq-drop-processing">
		            <span>Processing dropped files...</span>
		            <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
		        </span>
		        <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
		            <li>
		                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
		                <div class="qq-progress-bar-container-selector qq-progress-bar-container">
		                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
		                </div>
		                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
		                <div class="qq-thumbnail-wrapper">
		                    <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
		                </div>
		                <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">
		                	X
		                </button>
		                <button type="button" class="qq-upload-retry-selector qq-upload-retry">
		                    <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
		                    Retry
		                </button>

		                <div class="qq-file-info">
		                    <div class="qq-file-name">
		                        <span class="qq-upload-file-selector qq-upload-file"></span>
		                        <span class="qq-edit-filename-icon-selector qq-btn qq-edit-filename-icon" aria-label="Edit filename"></span>
		                    </div>
		                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
		                    <span class="qq-upload-size-selector qq-upload-size"></span>
		                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
		                        <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
		                    </button>
		                    <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
		                        <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
		                    </button>
		                    <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
		                        <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
		                    </button>
		                </div>
		            </li>
		        </ul>

		        <dialog class="qq-alert-dialog-selector">
		            <div class="qq-dialog-message-selector"></div>
		            <div class="qq-dialog-buttons">
		                <button type="button" class="qq-cancel-button-selector">Close</button>
		            </div>
		        </dialog>

		        <dialog class="qq-confirm-dialog-selector">
		            <div class="qq-dialog-message-selector"></div>
		            <div class="qq-dialog-buttons">
		                <button type="button" class="qq-cancel-button-selector">No</button>
		                <button type="button" class="qq-ok-button-selector">Yes</button>
		            </div>
		        </dialog>

		        <dialog class="qq-prompt-dialog-selector">
		            <div class="qq-dialog-message-selector"></div>
		            <input type="text">
		            <div class="qq-dialog-buttons">
		                <button type="button" class="qq-cancel-button-selector">Cancel</button>
		                <button type="button" class="qq-ok-button-selector">Ok</button>
		            </div>
		        </dialog>
		    </div>
		</script>

{{-- ENDS: Fine Uploader --}}

@endsection
@section('content')

<div class="form_wrapper">	
	<form id="form_rooms" class="form-horizontal" method="POST" action="{{ route('companies.store') }}">
		{{ csrf_field() }}
		
		<div class="row">
			<div class="large-12 columns">
				@if(Request::has('step'))
					<div class="step">
						<div class="description">Paso</div>
						<div class="number">3</div>
					</div>
				@endif
				
				<h1>Registra tu sala de ensayo</h1>
				<h2>Tendrás que registrar una a una las salas con las que cuenta tu marca</h2>
			</div>
		</div>
		
		<div class="row">

			<div class="large-4 columns">
				<label>Compañía</label>
				<select class="input-group-field" name="company" id="company">
					@foreach($companies as $company)
						<option value="{{$company->id}}">{{$company->name}}</option>
					@endforeach
				</select>
			</div>

			<div class="large-8 columns">
			
				<label>Nombre</label>
				<input class="input-group-field required"  type="text" name="name" placeholder="Ej. Sala grande">
				
			</div>

		</div>

		<div class="row">
			<div class="large-12 columns">
				<h3>Ubicación</h3>
				<label for="company_address" class="no-background">
					<input id="company_address" name="company_address" type="checkbox">Misma dirección que marca
				</label>
			</div>
				
			<div class="large-12 columns">
				
			</div>
		</div>

		{{-- STARTS: ADDRESS ZONE --}}
		<div class="new_address">
			<div class="row">
				
				<div class="large-8 columns">	
					<label>Dirección</label>
					<input class="input-group-field address get_loc required" type="text" name="address" placeholder="Calle y número" value="">
				</div>
				
				<div class="large-4 columns">
					
					<label>Delegación o Municipio</label>
					<input class="input-group-field deputation get_loc required" type="text" name="deputation" placeholder="Delegación o municipio">
					
				</div>

			</div>

			<div class="row">
				
				<div class="large-4 columns">
					<label>Colonia</label>
					<input class="input-group-field colony get_loc required" type="text" name="colony">
				</div>

				<div class="large-4 columns">
					<label>Teléfono</label>
					<input class="input-group-field required" type="text" name="phone">
				</div>

				<div class="large-4 columns">	
					<label>Código Postal</label>
					<input class="input-group-field postal_code get_loc required" type="text" name="postal_code">	
				</div>
			</div>

			<div class="row">
				
				<div class="large-6 columns">
					<label>Ciudad</label>
					<input class="input-group-field city get_loc required" type="text" name="city">
				</div>

				<div class="large-6 columns">
					<label>País <i class="fa fa-question-circle hastooltip" title="Por ahora esta plataforma sólo esta disponible en México" aria-hidden="true"></i></label>
					<select class="input-group-field country get_loc required" name="country" id="">
						<option value="mexico">México</option>
					</select>	
				</div>

				<div class="large-12 columns">
					<div class="clarification text-center">
						Verifica la ubicación, corrígela arrastrando el pin
					</div>
					<div id="map-canvas" ></div>
				</div>
			</div>

		</div>
		{{-- ENDS: ADDRESS ZONE --}}
		
		<div class="row">
			<div class="large-12 columns">
				<h3>Características</h3>
			</div>
			<div class="large-6 columns">
				<label>Descripción <i class="fa fa-question-circle hastooltip" title="Escribe una descripción breve, ej: Sala amplia cómoda para bandas de hasta 6 miembros" aria-hidden="true"></i></label>
				<textarea class="input-group-field required" type="text" name="description"></textarea>
			</div>

			<div class="large-6 columns">		
				<label>Equipamiento <i class="fa fa-question-circle hastooltip" title="Escribe un item por línea, ej. Amplificador Marshall a Bulbos mod..." aria-hidden="true"></i></label>
				<textarea class="input-group-field required" type="text" name="equipment" placeholder="Escribe un item por línea"></textarea>
			</div>

		</div>

		<div class="row">
		   
			<div class="large-6 columns">
				<label>Precio <i class="fa fa-question-circle hastooltip" title="Escribe el precio de renta de esta sala por hora" aria-hidden="true"></i></label>
				<input class="input-group-field required" type="text" name="price">
			</div>

			<div class="large-6 columns">
				<label>
					Color 
					<i class="fa fa-question-circle hastooltip" title="Con este color identificarás a esta sala en el calendario" aria-hidden="true"></i>
				</label>
				<input class="input-group-field colorpicker required" type="text" name="color">
			</div>

		</div>
		<div class="row">
			<div class="large-12 columns">
				<h3>Horario de servicio</h3>
			</div>
		</div>

		<div class="row">
			<div class="large-4 columns">
				<label for="">Días de Servicio</label>
				<select data-placeholder="Selecciona..." multiple name="days[]" class="chosen-select required">
				  <option value="-1">Todos los días</option>
				  <option value="1">Lunes</option>
				  <option value="2">Martes</option>
				  <option value="3">Miércoles</option>
				  <option value="4">Jueves</option>
				  <option value="5">Viernes</option>
				  <option value="6">Sábado</option>
				  <option value="7">Domingo</option>

				</select>
				<label class="chosen-error error"></label>
			</div>


			<div class="large-4 columns">
				<label>Abre:</label>
				<select class="input-group-field required" name="schedule_start" id="">
					<option value="">Selecciona...</option>
					<option value="06">6:00</option>
					<option value="07">7:00</option>
					<option value="08">8:00</option>
					<option value="09">9:00</option>
					<option value="10">10:00</option>
					<option value="11">11:00</option>
					<option value="12">12:00</option>
					<option value="13">13:00</option>
					<option value="14">14:00</option>
					<option value="15">15:00</option>
					<option value="16">16:00</option>
					<option value="17">17:00</option>
					<option value="18">18:00</option>
					<option value="19">19:00</option>
					<option value="20">20:00</option>
					<option value="21">21:00</option>
					<option value="22">22:00</option>
					<option value="23">23:00</option>
					<option value="24">24:00</option>
				</select>
				
			</div>

			<div class="large-4 columns">
				<label>Cierra</label>
				<select class="input-group-field required" name="schedule_end" id="">
					<option value="">Selecciona...</option>
					<option value="06">6:00</option>
					<option value="07">7:00</option>
					<option value="08">8:00</option>
					<option value="09">9:00</option>
					<option value="10">10:00</option>
					<option value="11">11:00</option>
					<option value="12">12:00</option>
					<option value="13">13:00</option>
					<option value="14">14:00</option>
					<option value="15">15:00</option>
					<option value="16">16:00</option>
					<option value="17">17:00</option>
					<option value="18">18:00</option>
					<option value="19">19:00</option>
					<option value="20">20:00</option>
					<option value="21">21:00</option>
					<option value="22">22:00</option>
					<option value="23">23:00</option>
					<option value="24">24:00</option>
				</select>
			</div>
		</div>
	
		</div>

		<div class="row">
			<div class="large-12 columns">
				<div id="uploader"></div>
				<br><br>
			</div>
		</div>

		<div class="row ">
			<div class="large-12 columns">
				<button type="submit" class="button expanded green register_room submit">
					Registrar
				</button>
			</div>
		</div>
	</form>
</div>
@endsection
@section('scripts')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMMiHmdWoL0K5FQPWL_cXBbK0IV-t7l3w"></script>
	
	<script src="{{asset('plugins/validation/jquery.validate.min.js')}}"></script>
	<script src="{{asset('plugins/validation/messages.js')}}"></script>
	<script src="{{asset('js/get_loc.js')}}"></script>
	<script>
		$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
		$('#form_rooms').validate({
			submitHandler: function(form) {
    			// $(form).submit();
    			register_room_prepare ();
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