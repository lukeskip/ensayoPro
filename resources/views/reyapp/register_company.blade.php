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
