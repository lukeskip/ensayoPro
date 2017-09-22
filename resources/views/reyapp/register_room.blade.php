@extends('layouts.reyapp.main')

@section('content')


	
   


	<form class="form-horizontal" method="POST" action="{{ route('companies.store') }}">
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
					 <label for="same_address"><input id="same_address" type="checkbox">Misma dirección que Marca</label>
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
				<button type="submit" class="button expanded green">
					Registrar
				</button>
			</div>
		</div>
	</form>
@endsection
@section('scripts')
	 <script>
        // Some options to pass to the uploader are discussed on the next page
        var uploader = new qq.FineUploader({
            element: document.getElementById("uploader"),
            debug: true,
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
            deleteFile: {
                enabled: true,
                endpoint: '/uploader/delete/{uuid}'
            }
            
        })
    </script>
@endsection
