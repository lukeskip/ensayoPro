@extends('layouts.reyapp.main')
@section('content')
	<h2>Edita los datos de tu sala de ensayos</h2>
	<div class="row">
		<div class="medium-12 columns text-center">
			<h3>Estatus: {{$room->status}}</h3>
		</div>
	</div>
	{{-- STA de tu compañiaRTS: Row --}}
	<div class="row">
		<input type="hidden" class="country" value="México">
		{{-- STARTS: Field --}}
		<div class="medium-8 columns">
			<div class="show-edit-wrapper">
				<div class="show">
					<label for="">Nombre:</label>
					<div class="text">
						{{$room->name}}	
					</div>
				</div>
				<div class="edit">
					<form data-address="false" action="/company/companies/{{$room->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <input class="input-group-field" type="text" name="name" value="{{$room->name}}">
						  <div class="input-group-button">
						    <button class="button black"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						  </div>
						</div>
					</form>
				</div>
			</div>
		</div>
		{{-- ENDS: Field --}}

		{{-- STARTS: Field --}}
		<div class="medium-4 columns">
			<div class="show-edit-wrapper">
				<div class="show">
					<label for="">Precio:</label>
					<div class="text">
						{{$room->price}}	
					</div>
				</div>
				<div class="edit">
					<form action="/company/companies/{{$room->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <input class="input-group-field" type="text" name="description" value="{{$room->price}}">
						  <div class="input-group-button">
						    <button class="button black"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						  </div>
						</div>
					</form>
				</div>
			</div>
		</div>
		{{-- ENDS: Field --}}
	
	</div>
	{{-- ENDS: Row --}}


	{{-- STARTS: Row --}}
	<div class="row">
		<input type="hidden" class="country" value="México">
		{{-- STARTS: Field --}}
		<div class="medium-6 columns">
			<div class="show-edit-wrapper">
				<div class="show big">
					<label for="">Descripción:</label>
					<div class="text">
						{{$room->description}}	
					</div>
				</div>
				<div class="edit">
					<form action="/company/companies/{{$room->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <textarea class="input-group-field" name="description" >
						  	{{$room->description}}
						  </textarea>
						  <div class="input-group-button">
						    <button class="button black"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						  </div>
						</div>
					</form>
				</div>
			</div>
		</div>
		{{-- ENDS: Field --}}

		{{-- STARTS: Field --}}
		<div class="medium-6 columns">
			<div class="show-edit-wrapper">
				<div class="show big">
					<label for="">Equipamiento:</label>
					<div class="text">
						{{$room->equipment}}	
					</div>
				</div>
				<div class="edit">
					<form action="/company/companies/{{$room->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <textarea class="input-group-field" name="equipment">
						  	{{$room->equipment}}
						  </textarea>
						  <div class="input-group-button">
						    <button class="button black"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						  </div>
						</div>
					</form>
				</div>
			</div>
		</div>
		{{-- ENDS: Field --}}
	
	</div>
	{{-- ENDS: Row --}}

	<div class="row">
		<div class="large-12 columns">
			<h3>Ubicación</h3>
			<label for="company_address" class="no-background">
				<input id="company_address" name="company_address" checked type="checkbox">Misma dirección que marca
			</label>
		</div>
	</div>
	
	<div class="new_address">
	
		{{-- STARTS: Row --}}
		<div class="row">

			{{-- STARTS: Field --}}
			<div class="medium-8 columns">
				<div class="show-edit-wrapper">
					<div class="show">
						<label for="">Dirección:</label>
						<div class="text">
							{{$room->address}}	
						</div>
					</div>
					<div class="edit">
						<form data-address="true" action="/company/companies/{{$room->id}}" method="PUT">
							
							<input type="hidden" name="latitude" class="latitude">
							<input type="hidden" name="longitude" class="longitude">
							
							<div class="input-group">
							  <input class="input-group-field get_loc address" type="text" name="address" value="{{$room->address}}">
							  <div class="input-group-button">
							    <button class="button black"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
							  </div>
							</div>
						</form>
					</div>
				</div>
			</div>
			{{-- ENDS: Field --}}

			{{-- STARTS: Field --}}
			<div class="medium-4 columns">
				<div class="show-edit-wrapper">
					<div class="show">
						<label for="">Colonia:</label>
						<div class="text">
							{{$room->colony}}	
						</div>
					</div>
					<div class="edit">
						
						<form data-address="true" action="/company/companies/{{$room->id}}" method="PUT">
							<div class="input-group">
							  <input class="input-group-field get_loc colony" type="text" name="colony" value="{{$room->colony}}">
							  <div class="input-group-button">
							    <button class="button black"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
							  </div>
							</div>
						</form>
					</div>
				</div>
			</div>
			{{-- ENDS: Field --}}
		
		</div>
		{{-- ENDS: Row --}}
		
		{{-- STARTS: Row --}}
		<div class="row">
			
			{{-- STARTS: Field --}}
			<div class="medium-4 columns">
				<div class="show-edit-wrapper">
					<div class="show">
						<label for="">Ciudad:</label>
						<div class="text">
							{{$room->city}}	
						</div>
					</div>
					<div class="edit">
						<form data-address="true" action="/company/companies/{{$room->id}}" method="PUT">
							{{ csrf_field() }}
							<div class="input-group">
							  <input class="input-group-field get_loc city" type="text" name="deputation" value="{{$room->city}}">
							  <div class="input-group-button">
							    <button class="button black"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
							  </div>
							</div>
						</form>
					</div>
				</div>
			</div>
			{{-- ENDS: Field --}}

			{{-- STARTS: Field --}}
			<div class="medium-4 columns">
				<div class="show-edit-wrapper">
					<div class="show">
						<label for="">Delegación o municipio:</label>
						<div class="text">
							{{$room->deputation}}	
						</div>
					</div>
					<div class="edit">
						<form data-address="true" action="/company/companies/{{$room->id}}" method="PUT">
							{{ csrf_field() }}
							
							<div class="input-group">
							  <input class="input-group-field get_loc deputation" type="text" name="deputation" value="{{$room->deputation}}">
							  <div class="input-group-button">
							    <button class="button black"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
							  </div>
							</div>
						</form>
					</div>
				</div>
			</div>
			{{-- ENDS: Field --}}

			{{-- STARTS: Field --}}
			<div class="medium-4 columns">
				<div class="show-edit-wrapper">
					<div class="show">
						<label for="">Código Postal:</label>
						<div class="text">
							{{$room->postal_code}}	
						</div>
					</div>
					<div class="edit">
						<form data-address="true" action="/company/companies/{{$room->id}}" method="PUT">
							{{ csrf_field() }}

							<div class="input-group">
							  <input class="input-group-field get_loc postal_code" type="text" name="postal_code" value="{{$room->postal_code}}">
							  <div class="input-group-button">
							    <button class="button black"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
							  </div>
							</div>
						</form>
					</div>
				</div>
			</div>
			{{-- ENDS: Field --}}

		</div>
		{{-- ENDS:Row --}}

		<div class="row">		
			<div class="large-12 columns">
				<div class="clarification text-center">
					Verifica la ubicación, corrígela arrastrando el pin
				</div>
				<div id="map-canvas"></div>
			</div>
		</div>
	</div>
@endsection


@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMMiHmdWoL0K5FQPWL_cXBbK0IV-t7l3w"></script>
<script>
	// si edit mode está en true, deberemos declarar también la variable action 
	var editmode 	= true;
	var action 	= '/company/companies/{{$room->id}}';
	var initMarker = {lat: {{$room->latitude}}, lng: {{$room->longitude}}};
</script>
<script src="{{asset('js/get_loc.js')}}"></script>
@endsection

