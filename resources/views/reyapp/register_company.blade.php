@extends('layouts.reyapp.landing')

@section('content')
	<form class="form-horizontal" method="POST" action="{{ route('companies.store') }}">
		{{ csrf_field() }}
		
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

				<div class="large-6 columns">
					<div class="input-group">
						<span class="input-group-label">
							Dirección:
						</span>
					  <input class="input-group-field" type="text" name="address">
					</div>
				</div>

				<div class="large-6 columns">
					<div class="input-group">
						<span class="input-group-label">
							Colonia:
						</span>
					  <input class="input-group-field" type="text" name="colony">
					</div>
				</div>


				
			</div>

			<div class="row">
				
				<div class="large-6 columns">
					<div class="input-group">
						<span class="input-group-label">
							Deleg/Municipio:
						</span>
					  <input class="input-group-field" type="text" name="deputation">
					</div>
				</div>

				<div class="large-6 columns">
					<div class="input-group">
						<span class="input-group-label">
							Código Postal:
						</span>
					  <input class="input-group-field" type="text" name="postal_code">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="large-6 columns">
					<div class="input-group">
						<span class="input-group-label">
							Ciudad:
						</span>
					  <input class="input-group-field" type="text" name="city">
					</div>
				</div>

				<div class="large-6 columns">
					<div class="input-group">
						<span class="input-group-label">
							País:
						</span>
					  <select class="input-group-field" name="country" id="">
					  	<option value="mexico">México</option>
					  </select>
					</div>
				</div>
			</div>

		<div class="row">
			
			<div class="large-12 columns">
				<div class="input-group">
					<span class="input-group-label">
						Telefono:
					</span>
				  <input class="input-group-field" type="text" name="phone">
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

		<div class="row ">
			<div class="large-12 columns">
				<button type="submit" class="button expanded green">
					Registrar
				</button>
			</div>
		</div>
	</form>
@endsection
