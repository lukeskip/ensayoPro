@extends('layouts.reyapp.main')
@section('styles')

@endsection
@section('content')
<h1>Crea un código promoción</h1>
<div class="form_wrapper">
	<form id="form_rooms" class="form-horizontal" method="POST" action="{{ route('companies.store') }}">
		{{ csrf_field() }}
		
		<div class="row">

			<div class="large-4 columns">
			
				<label>Código <i class="fa fa-question-circle hastooltip" title="Elige un código sin espacios o caracteres especiales, puedes usar mayúsculas y minúsculas" aria-hidden="true"></i></label>
				<input class="input-group-field required"  type="text" name="name" placeholder="SALA130">
				
			</div>

			<div class="large-4 columns">
			
				<label>Tipo</label>
				<select name="type" id="">
					<option value="">Elige</option>
					<option value="percent">Porcentaje</option>
					<option value="money">Dinero</option>
					<option value="package">Paquete</option>
				</select>
				
			</div>

			<div class="large-4 columns">
			
				<label>Descuento</label>
				<input class="input-group-field required"  type="number" name="discount" placeholder="120">
				
			</div>

		</div>
		<div class="row">
			<div class="large-12 columns">
				<label>Descripción <i class="fa fa-question-circle hastooltip" title="Escribe una descripción breve, ej: Sala amplia cómoda para bandas de hasta 6 miembros" aria-hidden="true"></i></label>
				<textarea class="input-group-field required" type="text" name="description"></textarea>	
			</div>	
		</div>
		<div class="row">
			<div class="medium-6 columns">
				<label for="">Desde</label>
				<input class="input-group-field required date"  type="text" name="starts" placeholder="120">
			</div>
			<div class="medium-6 columns">
				<label for="">Hasta</label>
				<input class="input-group-field required date"  type="text" name="ends" placeholder="120">
			</div>
		</div>
	</form>
</div>
@endsection
@section('scripts')	
	<script src="{{asset('plugins/validation/jquery.validate.min.js')}}"></script>
	<script src="{{asset('plugins/validation/messages.js')}}"></script>
	
	<script>
		$(document).ready(function(){
			$( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
		});
	</script>

@endsection
