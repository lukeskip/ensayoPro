@extends('layouts.reyapp.main')
@section('body_class', 'dashboard')
@section('content')
	<div class="row">
		<div class="large-12 columns">
			<h1>{{$company->name}}</h1>
		</div>
		
	</div>
	<div class="row">
		<div class="large-9 columns reservations">
				<div class="row list-header">
					<div class="medium-12-columns">
						<h3>Últimas reservaciones</h3>
					</div>
					<div class="medium-3 columns show-for-medium">
						Usuario 
					</div>
					<div class="medium-3 columns show-for-medium">
						Banda
					</div>
					<div class="medium-2 columns show-for-medium">
						Sala
					</div>
					<div class="medium-2 columns show-for-medium">
						Total
					</div>
					<div class="medium-2 columns show-for-medium">
						Status
					</div>
				</div>
				
				<div class="row list-item">
					<div class="medium-3 columns">

					<span class="hastooltip" title="Este es un tool tip">Sergio García</span>
						
					</div>
					<div class="medium-3 columns ">
						Noche de Quiz
					</div>
					<div class="medium-2 columns ">
						Sala Grande
					</div>
					<div class="medium-2 columns price">
						$400
					</div>
					<div class="medium-2 columns status">
						<i class="fa fa-times-circle-o hastooltip cancelled" title="Cancelado" aria-hidden="true"></i>
					</div>

				</div>

				<div class="row list-item">
					<div class="medium-3 columns">

					<span class="hastooltip" title="Este es un tool tip">Male Lara</span>
						
					</div>
					<div class="medium-3 columns ">
						Falsa Fortuna
					</div>
					<div class="medium-2 columns ">
						Sala Grande
					</div>
					<div class="medium-2 columns price">
						$500
					</div>
					<div class="medium-2 columns status">
						<i class="fa fa-clock-o hastooltip pending" aria-hidden="true" title="Pendiente"></i>
					</div>

				</div>

				<div class="row list-item">
					<div class="medium-3 columns">

					<span class="hastooltip" title="Este es un tool tip">Francisco Salas</span>
						
					</div>
					<div class="medium-3 columns ">
						Silver Stones
					</div>
					<div class="medium-2 columns ">
						Sala Grande
					</div>
					<div class="medium-2 columns price">
						$400
					</div>
					<div class="medium-2 columns status">
						<i class="fa fa-check-circle-o confirmed hastooltip" title="Confirmado" aria-hidden="true"></i>
					</div>

				</div>
				
		</div>
		<div class="large-3 columns">
			<button class="button expanded green">Ir a agenda</button>
			<div class="incomings">
				<div class="text">Ingresos este mes</div>
				<div class="number">20,000</div>
			</div>

			<div class="hours">
				<div class="number">156</div>
				<div class="text">Horas reservadas este mes</div>
			</div>
		</div>
	</div>
	
@endsection

@section('scripts')
<script>
	$(document).ready(function(){

		if('{{$company->status}}' == 'inactive'){
			show_message('warning','Atención','Los datos de tu compañía están siendo validados, por lo que aún no está activa');
		}
	});
</script>
	
@endsection

