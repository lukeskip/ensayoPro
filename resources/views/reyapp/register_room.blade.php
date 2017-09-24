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
						Compañía:
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
						Nombre:
					</span>
				  <input class="input-group-field" type="text" name="name">
				</div>
			</div>

		</div>

		<div class="row">
			
			<div class="large-12 columns">
				<div class="input-group">
					 <label for="same_address"><input id="same_address" type="checkbox">Misma dirección que marca</label>
				</div>
			</div>

			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						Dirección:
					</span>
				  <input class="input-group-field" type="text" name="address">
				</div>
			</div>

			

		</div>
		
		<div class="row">
			
			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						Teléfono:
					</span>
				  <input class="input-group-field" type="text" name="phone">
				</div>
			</div>

		</div>
		
		<div class="row">
			
			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						Descripción:
					</span>
				  <textarea class="input-group-field" type="text" name="description"></textarea>
				</div>
			</div>

		</div>

		<div class="row">
		   
			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						Precio:
					</span>
				  <input class="input-group-field" type="text" name="price">
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
				<button type="submit" class="button expanded green register_room">
					Registrar
				</button>
			</div>
		</div>
	</form>
@endsection
@section('scripts')
	<script>
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
