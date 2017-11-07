@extends('layouts.reyapp.main')
@section('content')
	<h2>Edita los datos de tu compañía</h2>
	<div class="row">
		<div class="medium-12 columns text-center">
			<h3>Estatus: {{$company->status}}</h3>
		</div>
	</div>
	{{-- STA de tu compañiaRTS: Row --}}
	<div class="row">
		<input type="hidden" class="country" value="México">
		{{-- STARTS: Field --}}
		<div class="medium-6 columns">
			<div class="show-edit-wrapper">
				<div class="show">
					<label for="">Nombre Comercial:</label>
					<div class="text">
						{{$company->name}}	
					</div>
				</div>
				<div class="edit">
					<form data-address="false" action="/company/companies/{{$company->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <input class="input-group-field" type="text" name="name" value="{{$company->name}}">
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
				<div class="show">
					<label for="">Nombre legal:</label>
					<div class="text">
						{{$company->legalname}}	
					</div>
				</div>
				<div class="edit">
					<form action="/company/companies/{{$company->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <input class="input-group-field" type="text" name="legalname" value="{{$company->legalname}}">
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
				<div class="show">
					<label for="">RFC:</label>
					<div class="text">
						{{$company->rfc}}	
					</div>
				</div>
				<div class="edit">
					<form action="/company/companies/{{$company->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <input class="input-group-field" type="text" name="rfc" value="{{$company->rfc}}">
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
				<div class="show">
					<label for="">Teléfono:</label>
					<div class="text">
						{{$company->phone}}	
					</div>
				</div>
				<div class="edit">
					<form action="/company/companies/{{$company->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <input class="input-group-field" type="text" name="phone" value="{{$company->phone}}">
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
		<div class="medium-4 columns">
			<div class="show-edit-wrapper">
				<div class="show">
					<label for="">Número CLABE:</label>
					<div class="text">
						{{$company->clabe}}	
					</div>
				</div>
				<div class="edit">
					<form action="/company/companies/{{$company->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <input class="input-group-field" type="text" name="clabe" value="{{$company->clabe}}">
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
					<label for="">Banco:</label>
					<div class="text">
						{{$company->phone}}	
					</div>
				</div>
				<div class="edit">
					<form action="/company/companies/{{$company->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <input class="input-group-field" type="text" name="phone" value="{{$company->phone}}">
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
					<label for="">Titular de la cuenta:</label>
					<div class="text">
						{{$company->account_holder}}	
					</div>
				</div>
				<div class="edit">
					<form action="/company/companies/{{$company->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <input class="input-group-field" type="text" name="account_holder" value="{{$company->account_holder}}">
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
		<div class="medium-8 columns">
			<div class="show-edit-wrapper">
				<div class="show">
					<label for="">Dirección:</label>
					<div class="text">
						{{$company->address}}	
					</div>
				</div>
				<div class="edit">
					<form data-address="true" action="/company/companies/{{$company->id}}" method="PUT">
						
						<input type="hidden" name="latitude" class="latitude">
						<input type="hidden" name="longitude" class="longitude">
						
						<div class="input-group">
						  <input class="input-group-field get_loc address" type="text" name="address" value="{{$company->address}}">
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
						{{$company->colony}}	
					</div>
				</div>
				<div class="edit">
					
					<form data-address="true" action="/company/companies/{{$company->id}}" method="PUT">
						<div class="input-group">
						  <input class="input-group-field get_loc colony" type="text" name="colony" value="{{$company->colony}}">
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
						{{$company->city}}	
					</div>
				</div>
				<div class="edit">
					<form data-address="true" action="/company/companies/{{$company->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <input class="input-group-field get_loc city" type="text" name="deputation" value="{{$company->city}}">
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
						{{$company->deputation}}	
					</div>
				</div>
				<div class="edit">
					<form data-address="true" action="/company/companies/{{$company->id}}" method="PUT">
						{{ csrf_field() }}
						
						<div class="input-group">
						  <input class="input-group-field get_loc deputation" type="text" name="deputation" value="{{$company->deputation}}">
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
						{{$company->postal_code}}	
					</div>
				</div>
				<div class="edit">
					<form data-address="true" action="/company/companies/{{$company->id}}" method="PUT">
						{{ csrf_field() }}

						<div class="input-group">
						  <input class="input-group-field get_loc postal_code" type="text" name="postal_code" value="{{$company->postal_code}}">
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
	
@endsection


@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMMiHmdWoL0K5FQPWL_cXBbK0IV-t7l3w"></script>
<script>
	// si edit mode está en true, deberemos declarar también la variable action 
	var editmode 	= true;
	var action 	= '/company/companies/{{$company->id}}';
	var initMarker = {lat: {{$company->latitude}}, lng: {{$company->longitude}}};
</script>
<script src="{{asset('js/get_loc.js')}}"></script>
@endsection

