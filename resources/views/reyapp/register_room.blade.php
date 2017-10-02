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

	
	<form id="form_companies" class="form-horizontal" method="POST" action="{{ route('companies.store') }}">
		{{ csrf_field() }}
		
		<div class="row">
			<div class="large-12 columns">
				<div class="step">
					<div class="description">Paso</div>
					<div class="number">3</div>
				</div>
				<h1>Registra tu sala de ensayo</h1>
				<h2>Tendrás que registrar una a una las salas con las que cuenta tu marca</h2>
			</div>
		</div>
		
		<div class="row">

			<div class="large-12 columns">
				<label for="company"></label>
				

				<div class="input-group">
					<span class="input-group-label">
						Compañía
					</span>
				  
				  <select class="input-group-field" name="company" id="company">
					@foreach($companies as $company)
						<option value="{{$company->id}}">{{$company->name}}</option>
					@endforeach
				  </select>
				</div>
			</div>

		</div>

		<div class="row">

			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						Nombre
					</span>
				  <input class="input-group-field" type="text" name="name" placeholder="Ej. Sala grande">
				</div>
			</div>

		</div>

		<div class="row">
			<div class="large-12 columns">
				<div class="input-group">
					 <label for="company_address">
					 	<input id="company_address" name="company_address" type="checkbox">Misma dirección que marca
					 </label>
				</div>
			</div>
		</div>

		{{-- STARTS: ADDRESS ZONE --}}
		<div class="new_address">
			<div class="row">
				<div class="large-12 columns">
					<div class="input-group">
						<span class="input-group-label">
							Dirección
						</span>
					  <input class="input-group-field address get_loc" type="text" name="address" placeholder="Calle y número">
					</div>
				</div>
				
				<div class="large-12 columns">
					<div class="input-group">
						<span class="input-group-label">
							Deleg.
						</span>
					  <input class="input-group-field deputation get_loc" type="text" name="deputation" placeholder="Delegación o municipio">
					</div>
				</div>

			</div>

			<div class="row">
				
				<div class="large-12 columns">
					<div class="input-group">
						<span class="input-group-label">
							Colonia
						</span>
					  <input class="input-group-field colony get_loc" type="text" name="colony">
					</div>
				</div>

				<div class="large-6 columns">
					<div class="input-group">
						<span class="input-group-label">
							Teléfono
						</span>
					  <input class="input-group-field" type="text" name="phone">
					</div>
				</div>

				<div class="large-6 columns">
					<div class="input-group">
						<span class="input-group-label">
							Código P.
						</span>
					  <input class="input-group-field postal_code get_loc" type="text" name="postal_code">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="large-6 columns">
					<div class="input-group">
						<span class="input-group-label">
							Ciudad
						</span>
					  <input class="input-group-field city get_loc" type="text" name="city">
					</div>
				</div>

				<div class="large-6 columns">
					<div class="input-group">
						<span class="input-group-label">
							País
						</span>
					  <select class="input-group-field country get_loc" name="country" id="">
					  	<option value="mexico">México</option>
					  </select>
					</div>
				</div>

				<div class="large-12 columns">
					<div class="clarification text-center">
						Verifica la ubicación, corrígela arrastrando el pin
					</div>
					<div id="map-canvas" style="height: 200px;"></div>
				</div>
			</div>
		</div>
		{{-- ENDS: ADDRESS ZONE --}}
		
		<div class="row">
			
			

		</div>
		
		<div class="row">
			
			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						Descripción
					</span>
				  <textarea class="input-group-field" type="text" name="description"></textarea>
				</div>
			</div>

		</div>

		<div class="row">
			
			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						Equipamiento
					</span>
				  <textarea class="input-group-field" type="text" name="equipment" placeholder="Escribe un item por línea"></textarea>
				</div>
			</div>

		</div>

		<div class="row">
		   
			<div class="large-6 columns">
				<div class="input-group">
					<span class="input-group-label">
						Precio
					</span>
				  <input class="input-group-field" type="text" name="price">
				</div>
			</div>
			<div class="large-6 columns">
				<div class="input-group">
					<span class="input-group-label">
					Color
						<i class="fa fa-question-circle hastooltip" title="Con este color identificarás a esta sala en el calendario" aria-hidden="true"></i>

					</span>
				  <input class="input-group-field colorpicker" type="text" name="color">
				</div>
			</div>
			<div class="large 12-columns">
				<div class="clarification text-center">
					Horario de servicio:
				</div>
			</div>
			<div class="large-6 columns">
				
				<div class="input-group">
					<span class="input-group-label">
						Abre:
					</span>
					<select class="input-group-field" name="schedule_start" id="">
						<option value="">Selecciona...</option>
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
					</select>
				</div>
			</div>
			<div class="large-6 columns">
				
				<div class="input-group">
					<span class="input-group-label">
						Cierra
					</span>
					<select class="input-group-field" name="schedule_end" id="">
						<option value="">Selecciona...</option>
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
				<button class="button expanded green register_room submit">
					Registrar
				</button>
			</div>
		</div>
	</form>
@endsection
@section('scripts')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMMiHmdWoL0K5FQPWL_cXBbK0IV-t7l3w"></script>

	<script src="{{asset('js/get_loc.js')}}"></script>
	

	<script>
		$(".colorpicker").on("change.color", function(event, color){
    		$(this).css('background-color', color);
    		
		});

		$(".colorpicker").colorpicker({
			hideButton: true,
			history: false,
			defaultPalette:'web'

		});


		// Cargamos los archivos antes de hacer submit
		$('#uploader').fineUploader({
			debug:false,
			request: {
				endpoint: '/uploader/upload',
				params: {
				base_directory: 'completed',
				sub_directory: null,
				optimus_uploader_allowed_extensions: [],
				optimus_uploader_size_limit: 0,
				optimus_uploader_thumbnail_height: 100,
				optimus_uploader_thumbnail_width: 100,
				}
	        },
			autoUpload: false,
			callbacks: {
			    onComplete: function(id,name,responseJSON) {
			        room_images.push({
						'name'  :responseJSON.name,
						'path'	:'uploader/completed'
					});
			    },
			    onAllComplete: function(succeeded){
			    	register_room();
			    }
			}
    	});
	</script>

@endsection
