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

<div class="form_wrapper room-edit">	
	<form id="form_rooms" class="form-horizontal" method="PUT" action="{{ route('companies.update',['id' => $room->id]) }}">
		{{ csrf_field() }}
		
		<div class="row">
			<div class="large-12 columns">
				<h1>Edita los datos de tu {{$room->types->label}}</h1>
			</div>
		</div>
		
		<div class="row">
			<input type="hidden" name="company" value="{{$company->id}}">

			<div class="large-4 columns">
			
				<label>Nombre</label>
				<input class="input-group-field required"  type="text" name="name" placeholder="Ej. Sala grande" value="{{$room->name}}">
				
			</div>

			<div class="large-4 columns">
				
					<label>Tipo</label>
					<select class="required" name="type" id="">
						<option value="">Elige...</option>
						@foreach($types as $type)
							<option @if($room->types->name == $type->name) {{'selected'}} @endif value="{{$type->name}}">{{$type->label}}</option>
						@endforeach
					</select>
					
				</div>

			<div class="large-4 columns">
				<label for="company_address">
					Estatus <i class="fa fa-question-circle hastooltip" aria-hidden="true" title="Desactiva esta sala temporalmente"></i>
					{{$room->status}}
				</label>
				<select name="status" id="">
					<option @if($room->status == 'active') {{'selected'}} @endif value="active">Activa</option>
					<option @if($room->status == 'inactive') {{'selected'}} @endif value="inactive">Inactiva</option>

					@if($role == 'admin')
						<option @if($room->status == 'deleted') {{'selected'}} @endif value="deleted">Cancelada</option>
					@endif
				</select>
			</div>

		</div>

		<div class="row">
			<div class="large-12 columns">
				<h3>Ubicación</h3>
				<label for="company_address" class="no-background">
					<input id="company_address" name="company_address" @if($room->company_address) {{'checked'}} @endif type="checkbox">Misma dirección que marca
				</label>
			</div>
		</div>

		{{-- STARTS: ADDRESS ZONE --}}
		<div class="new_address">
			<div class="row">
				
				<div class="large-8 columns">	
					<label>Dirección</label>
					<input class="input-group-field address get_loc required" type="text" name="address" placeholder="Calle y número" value="{{$room->address}}">
				</div>
				
				<div class="large-4 columns">
					
					<label>Delegación o Municipio</label>
					<input class="input-group-field deputation get_loc required" type="text" name="deputation" placeholder="Delegación o municipio" value="{{$room->deputation}}">
					
				</div>

			</div>

			<div class="row">
				
				<div class="large-4 columns">
					<label>Colonia</label>
					<input class="input-group-field colony get_loc required" type="text" name="colony" value="{{$room->colony}}">
				</div>

				<div class="large-4 columns">
					<label>Teléfono</label>
					<input class="input-group-field required" type="text" name="phone" value="{{$room->phone}}">
				</div>

				<div class="large-4 columns">	
					<label>Código Postal</label>
					<input class="input-group-field postal_code get_loc required" type="text" name="postal_code" value="{{$room->postal_code}}">	
				</div>
			</div>

			<div class="row">
				
				<div class="large-6 columns">
					<label>Ciudad</label>
					<input class="input-group-field city get_loc required" type="text" name="city" value="{{$room->city}}">
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
			<div class="large-4 columns">
				<label>Descripción <i class="fa fa-question-circle hastooltip" title="Escribe una descripción breve, ej: Sala amplia cómoda para bandas de hasta 6 miembros" aria-hidden="true"></i></label>
				<textarea class="input-group-field required" type="text" name="description" data-rule-maxlength="255">{{$room->description}}</textarea>

			</div>

			<div class="large-4 columns">		
				<label>Equipamiento <i class="fa fa-question-circle hastooltip" title="Escribe un item por línea, ej. Amplificador Marshall a Bulbos mod..." aria-hidden="true"></i></label>
				<textarea class="input-group-field required" type="text" name="equipment" placeholder="Escribe un item por línea">{{$room->equipment}}</textarea>
			</div>

			<div class="large-4 columns">		
				<label>Instrucciones <i class="fa fa-question-circle hastooltip" title="Escribe las indicaciones para quienes renten tu sala" aria-hidden="true"></i></label>
				<textarea class="input-group-field required" type="text" name="instructions" placeholder="Ej. El baterista deberá de llevar sus platos y pedal de bombo..." data-rule-maxlength="255">{{$room->instructions}}</textarea>
			</div>

		</div>

		<div class="row">
		   
			<div class="large-6 columns">
				<label>Precio <i class="fa fa-question-circle hastooltip" title="Escribe el precio de renta de esta sala por hora" aria-hidden="true"></i></label>
				<input class="input-group-field required" type="text" name="price" value="{{$room->price}}">
			</div>

			<div class="large-6 columns">
				<label>
					Color 
					<i class="fa fa-question-circle hastooltip" title="Con este color identificarás a esta sala en el calendario" aria-hidden="true"></i>
				</label>
				<input style="background:{{$room->color}}" value="{{$room->color}}" class="input-group-field colorpicker required" type="text" name="color" value="{{$room->color}}">
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
				  <option @if (in_array(1, $room->days)) {{'selected'}} @endif value="1">Lunes</option>
				  <option @if (in_array(2, $room->days)) {{'selected'}} @endif value="2">Martes</option>
				  <option @if (in_array(3, $room->days)) {{'selected'}} @endif value="3">Miércoles</option>
				  <option @if (in_array(4, $room->days)) {{'selected'}} @endif value="4">Jueves</option>
				  <option @if (in_array(5, $room->days)) {{'selected'}} @endif value="5">Viernes</option>
				  <option @if (in_array(6, $room->days)) {{'selected'}} @endif value="6">Sábado</option>
				  <option @if (in_array(0, $room->days)) {{'selected'}} @endif value="0">Domingo</option>

				</select>
				<label class="chosen-error error"></label>
			</div>


			<div class="large-4 columns">
				<label>Abre:</label>
				<select class="input-group-field required" name="schedule_start" id="">
					<option value="">Selecciona...</option>
					<option @if($room->schedule_start == 6) {{'selected'}} @endif value="6">
						6:00
					</option>
					<option @if($room->schedule_start == 7) {{'selected'}} @endif value="7">
						7:00
					</option>
					<option @if($room->schedule_start == 8) {{'selected'}} @endif value="8">
						8:00
					</option>
					<option @if($room->schedule_start == 9) {{'selected'}} @endif value="9">
						9:00
					</option>
					<option @if($room->schedule_start == 10) {{'selected'}} @endif value="10">
						10:00
					</option>
					<option @if($room->schedule_start == 11) {{'selected'}} @endif value="11">
						11:00
					</option>
					<option @if($room->schedule_start == 12) {{'selected'}} @endif value="12">
						12:00
					</option>
					<option @if($room->schedule_start == 13) {{'selected'}} @endif value="13">
						13:00
					</option>
					<option @if($room->schedule_start == 14) {{'selected'}} @endif value="14">
						14:00
					</option>
					<option @if($room->schedule_start == 15) {{'selected'}} @endif value="15">
						15:00
					</option>
					<option @if($room->schedule_start == 16) {{'selected'}} @endif value="16">
						16:00
					</option>
					<option @if($room->schedule_start == 17) {{'selected'}} @endif value="17">
						17:00
					</option>
					<option @if($room->schedule_start == 18) {{'selected'}} @endif value="18">
						18:00
					</option>
					<option @if($room->schedule_start == 19) {{'selected'}} @endif value="19">
						19:00
					</option>
					<option @if($room->schedule_start == 20) {{'selected'}} @endif value="20">
						20:00
					</option>
					<option @if($room->schedule_start == 21) {{'selected'}} @endif value="21">
						21:00
					</option>
					<option @if($room->schedule_start == 22) {{'selected'}} @endif value="22">
						22:00
					</option>
					<option @if($room->schedule_start == 23) {{'selected'}} @endif value="23">
						23:00
					</option>
					<option @if($room->schedule_start == 24) {{'selected'}} @endif value="24">
						24:00
					</option>
				</select>
				
			</div>

			<div class="large-4 columns">
				<label>Cierra</label>
				<select class="input-group-field required" name="schedule_end" id="">
					<option value="">Selecciona...</option>
					<option @if($room->schedule_end == 6) {{'selected'}} @endif value="6">
						6:00
					</option>
					<option @if($room->schedule_end == 7) {{'selected'}} @endif value="7">
						7:00
					</option>
					<option @if($room->schedule_end == 8) {{'selected'}} @endif value="8">
						8:00
					</option>
					<option @if($room->schedule_end == 9) {{'selected'}} @endif value="9">
						9:00
					</option>
					<option @if($room->schedule_end == 10) {{'selected'}} @endif value="10">
						10:00
					</option>
					<option @if($room->schedule_end == 11) {{'selected'}} @endif value="11">
						11:00
					</option>
					<option @if($room->schedule_end == 12) {{'selected'}} @endif value="12">
						12:00
					</option>
					<option @if($room->schedule_end == 13) {{'selected'}} @endif value="13">
						13:00
					</option>
					<option @if($room->schedule_end == 14) {{'selected'}} @endif value="14">
						14:00
					</option>
					<option @if($room->schedule_end == 15) {{'selected'}} @endif value="15">
						15:00
					</option>
					<option @if($room->schedule_end == 16) {{'selected'}} @endif value="16">
						16:00
					</option>
					<option @if($room->schedule_end == 17) {{'selected'}} @endif value="17">
						17:00
					</option>
					<option @if($room->schedule_end == 18) {{'selected'}} @endif value="18">
						18:00
					</option>
					<option @if($room->schedule_end == 19) {{'selected'}} @endif value="19">
						19:00
					</option>
					<option @if($room->schedule_end == 20) {{'selected'}} @endif value="20">
						20:00
					</option>
					<option @if($room->schedule_end == 21) {{'selected'}} @endif value="21">
						21:00
					</option>
					<option @if($room->schedule_end == 22) {{'selected'}} @endif value="22">
						22:00
					</option>
					<option @if($room->schedule_end == 23) {{'selected'}} @endif value="23">
						23:00
					</option>
					<option @if($room->schedule_end == 24) {{'selected'}} @endif value="24">
						24:00
					</option>
				</select>
			</div>
		</div>

		<div class="row">
			
		</div>

		<div class="row">
			<div class="large-12 columns">
				<h3>Imágenes</h3>	
			</div>
			
			<div class="large-6 columns">
				<div id="uploader"></div>
				<br><br>
			</div>
			<div class="large-6 columns">
				<div class="images">
					@foreach($room->media_items as $image)

						<span class="image" href="{{url('imagenes/'.$image->name)}}" data-lightbox="{{$room->name}}">
							<img src="{{url('imagenes/'.$image->name)}}" />
							<a href="#" class="delete" data-id="{{$image->id}}">
								<i class="fa fa-times-circle" aria-hidden="true"></i>
							</a>
						</span>
			
					@endforeach
				</div>
			</div>
		</div>

		<div class="row ">
			<div class="large-12 columns">
				<button type="submit" class="button expanded green register_room submit">
					Guardar datos
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
	<script>
	
		var initMarker = {lat: {{$latitude}}, lng: {{$longitude}} };
		var editmode 	= true;	
	
	</script>
	<script src="{{asset('js/get_loc.js')}}"></script>
	<script>

		// Creamos el array que contendrá las imágenes y con el que revisamos si hay imágenes que cargar 
		var room_images = [];
		var room_images_check = [];

		// Borramos las imágenes ya cargadas preguntando si realmente está seguro
		$('.delete').click(function(e){
			e.preventDefault();
			target = $(this);
			id = $(this).data('id');
			swal({
			  title: '¿Estás seguro?',
			  text: "No podrás revertir esta acción",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Borrar'
			}).then(function () {
				conection('DELETE','','/company/borrar_imagen/'+id,true).then(function(data){
					if(data.success == true){
						show_message('success','¡Listo!','La imagen ha sido borrada con éxito');
						target.parent().remove();
					}
				}); 
			});
			
			
		});

		$('#uploader').fineUploader().on("submit", function (event, id, name, response) {
    		room_images_check.push({
				'id'  :id,
			});
    	}).on("complete", function (event, id, name, response) {
    		room_images.push({
				'name'  :response.name,
				'path'	:'uploader/completed'
			});
    	}).on("allComplete", function (event, id, name, response) {
        		send_data();
    	});

		$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
		$('#form_rooms').validate({
			submitHandler: function(form) {
				
				if(room_images_check.length !== 0){
					$('#uploader').fineUploader('uploadStoredFiles');
				}else{
					send_data();
				}
    			
  			},
  			errorPlacement: function(error, element) {
    		if(element[0].name == "days[]"){
    			console.log(element.parent().find('label.error'));

    		}else{
    			error.insertAfter(element);
    		}
    		
		}
		});

		function send_data(){
			data = $("#form_rooms").serialize()+'&images='+JSON.stringify(room_images);
			conection('PUT',data,'/company/salas/'+'{{$room->id}}',true).then(function(answer){
				if(answer.success == true){
					swal({
					  title: '¡Listo!',
					  text: answer.description,
					  type: 'success',
					  confirmButtonColor: '#CF2832', 
					}).then(function () {
						location.reload();
						// window.location.replace('/company/salas')
					});
				}
				
			});
		}

	</script>
	

@endsection
