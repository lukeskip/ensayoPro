@extends('layouts.reyapp.landing')

@section('content')

	<form id="register_com" method="POST" action="{{ route('companies.store') }}">
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
			</div>
		</div>
		<div class="row">

			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						Marca:
					</span>
				  <input class="input-group-field" type="text" name="name">
				</div>
			</div>

		</div>

		<div class="row">
		   
			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						RFC:
					</span>
				  <input class="input-group-field" type="text" name="rfc">
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

		<div class="row ">
			<div class="large-12 columns">
				<button class="button expanded green submit">
					Registrar
				</button>
			</div>
		</div>
	</form>
@endsection
@section('scripts')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMMiHmdWoL0K5FQPWL_cXBbK0IV-t7l3w"></script>

	<script src="{{asset('js/get_loc.js')}}"></script>
@endsection