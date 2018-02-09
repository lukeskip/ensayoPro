@extends('layouts.reyapp.main')

@section('content')

	<h1>Registrar Promoción</h1>
	
		<div class="form_wrapper">
			<form action="">
			<div class="row">
				<div class="large-6 columns">
					<label for="">Nombre</label>
					<input type="text" name="name" class="required">
				</div>
				<div class="large-6 columns">
					<label for="">Status</label>
					<select name="status" id="status">
						<option value="draft">Borrador</option>
						<option value="published">Pública</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="large-4 columns">
					<label for="">Tipo de promoción</label>
					<select name="type" id="type" class="required">
						<option value="">Selecciona...</option>
						<option value="direct">Directo</option>
						<option value="percentage">Porcentaje</option>
						<option value="hour_price">Precio por hora</option>
					</select>
				</div>
				<div class="large-4 columns">
					<label for="">
						Sala <i class="fa fa-question-circle hastooltip" title="Salas en las que aplicará la promoción" aria-hidden="true"></i>
					</label>
					<select type="text" multiple name="rooms[]" class="chosen-select required" data-placeholder="Selecciona...">
						<option value="-1">Todas mis salas</option>
						@foreach($rooms as $room)
							<option value="{{$room->id}}">{{$room->name}}</option>
						@endforeach
					</select>
					
				</div>
				
				<div class="large-4 columns">
					<label for="">Descuento <i class="fa fa-question-circle hastooltip" title="Es un número entero que dependiento el tipo de promoción significa dinero de descuento, un porcentaje del pago o el precio por hora" aria-hidden="true"></i></label>
					<input type="number" id="discount" name="discount" class="required">
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<h3>Tiempo de validez</h3>
				</div>
			</div>
			<div class="row">
				<div class="large-6 columns">
					<label for="">Válida a partir de <i class="fa fa-question-circle hastooltip" title="Rango de tiempo en qué será valida la promoción, máximo 1 mes" aria-hidden="true"></i></label>
					<input id="valid_starts" class="datepicker required valid_starts" type="text" name="valid_starts" >
				</div>

				<div class="large-6 columns">
					<label for="">Válida hasta <i class="fa fa-question-circle hastooltip" title="Rango de tiempo en qué será valida la promoción, máximo 1 mes" aria-hidden="true"></i></label>
					<input class="datepicker required" type="text" name="valid_ends" >
				</div>
			</div>
			<div class="row">	
				<div class="large-12 columns">
					<h3>Reglas</h3>
				</div>
				<div class="large-6 columns end">
					<label class="option_label blue" for="schedule_btn"><input id="schedule_btn" type="radio" name="rule" checked class="schedule_btn" value="schedule"> Por horario <i class="fa fa-question-circle hastooltip" title="La promción sólo aplicará en un horario específico del día" aria-hidden="true"></i></label>
  					<label class="option_label blue" for="hours_btn"><input id="hours_btn" type="radio" name="rule" class="hours_btn" value="hours"> Por número de horas <i class="fa fa-question-circle hastooltip" title="La promoción sólo aplicará cuando el usuario reserve un número determinado de horas" aria-hidden="true"></i></label><br>
				</div>
			</div>
			<div class="row">
				<div class="hours hidden">
					<div class="large-12 columns">
						<h3>Numero de horas</h3>
					</div>
					<div class="large-6 columns end">
						<label for="">Cantidad mínima de horas</label>
						<input type="text" name="min_hours" class="required">
					</div>
					
				</div>
				<div class="schedule">
					<div class="large-12 columns no-padding">
						<div class="large-12 columns">
							<h3>Horario</h3>
						</div>
						
						<div class="large-6 columns">
							<label for="">A partir de las... (hrs.)</label>
							<select  id="schedule_starts" class="input-group-field required" name="schedule_starts" id="">
								<option value="">Selecciona...</option>
								<option value="6">6:00</option>
								<option value="7">7:00</option>
								<option value="8">8:00</option>
								<option value="9">9:00</option>
								<option value="10">10:00</option>
								<option value="11">11:00</option>
								<option value="12">12:00</option>
								<option value="13">13:00</option>
								<option value="14">14:00</option>
								<option value="15">15:00</option>
								<option value="16">16:00</option>
								<option value="17">17:00</option>
								<option value="18">18:00</option>
								<option value="19">19:00</option>
								<option value="20">20:00</option>
								<option value="21">21:00</option>
								<option value="22">22:00</option>
								<option value="23">23:00</option>
								<option value="24">24:00</option>
							</select>	
						</div>
						<div class="large-6 columns">
							<label for="">Hasta las... (hrs).</label>
							<select class="input-group-field required" name="schedule_ends" id="">
								<option value="">Selecciona...</option>
								<option value="6">6:00</option>
								<option value="7">7:00</option>
								<option value="8">8:00</option>
								<option value="9">9:00</option>
								<option value="10">10:00</option>
								<option value="11">11:00</option>
								<option value="12">12:00</option>
								<option value="13">13:00</option>
								<option value="14">14:00</option>
								<option value="15">15:00</option>
								<option value="16">16:00</option>
								<option value="17">17:00</option>
								<option value="18">18:00</option>
								<option value="19">19:00</option>
								<option value="20">20:00</option>
								<option value="21">21:00</option>
								<option value="22">22:00</option>
								<option value="23">23:00</option>
								<option value="24">24:00</option>
							</select>	
						</div>
						
					</div>

					<div class="large-6 columns end">
						<label for="">Válida los días...</label>
						<select data-placeholder="Selecciona..." type="text" multiple name="days[]" class="chosen-select">
							<option value="-1">Todos los días</option>
							<option value="1">Lunes</option>
							<option value="2">Martes</option>
							<option value="3">Miércoles</option>
							<option value="4">Jueves</option>
							<option value="5">Viernes</option>
							<option value="6">Sábado</option>
							<option value="0">Domingo</option>
						</select>
					</div>
				</div>
			</div>
				
			<div class="row">
				<hr>
				<div class="large-12 columns">
					<button type="submit" class="button expanded green">
						Registrar
					</button>
					
				</div>
			</div>
				
			</form>
		

	</div>
		
	
@endsection

@section('scripts')
<script src="{{asset('plugins/jquery-ui/datepicker_es.js')}}"></script>
<script src="{{asset('plugins/validation/messages.js')}}"></script>
<script>
	$(document).ready(function(){
		$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });

		$("form").validate({
			rules: {
				schedule_ends: {
				    number: true,
				    min: 0,
				    greaterThan: "#schedule_starts",
				    required: '#schedule_btn[value="schedule"]:checked'
				},
				"valid_ends": {
        			required: function(element) {
        				return ($("#valid_ends").val()!="");},
        			greaterStart: "#valid_starts"
     			 },
     			 "discount": {
        			percentage: "#type",
        			direct: "#type",
        			hour_price: "#type"
     			 },
     			


			},
			submitHandler: function(form) {
				if($('#status').val()=='published'){
					type 	= $('#type').val();
					if(type == 'direct'){
						type = 'Directo';
						value = '$'+$('#discount').val();
					}else if(type == 'percentage'){
						type = 'porcentaje';
						value = $('#discount').val()+'%';
					}
					swal({
					  title: 'Tu promoción se publicará',
					  html: "No podrás modificarla desde el administrador, en caso de haber algún problema tendrás que contactar al webmaster de EnsayoPro",
					  type: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#36A939',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Entiendo, Publícala',
					  cancelButtonText: 'Cancelar'
					}).then((result) => {
					  	data = $(form).serialize();
			  			conection('POST', data, '/company/promociones/registro',true).then(function(answer){
				  				if(answer.success == true){
			  						show_message('success','¡Listo!','Tu promoción fue gardada como borrador');
			  					}else{
			  						show_message('error','Error!',answer.message);
			  					}
			  			});
					});
				}else if ($('#status').val()=='draft'){
					data = $(form).serialize();
		  			conection('POST', data, '/company/promociones/registro',true).then(function(answer){
		  					if(answer.success == true){
		  						show_message('success','¡Listo!','Tu promoción fue gardada como borrador');
		  					}else{
		  						show_message('error','Error!',answer.message);
		  					}
		  					
		  			});
				}
				
				
			}
 		});

		$.validator.addMethod("greaterStart", function (value, element, params){
    		return this.optional(element) || new Date(value) >= new Date($(params).val());
		},'La fecha de término debe de ser después de la de inicio');

		$.validator.addMethod("greaterThan",function (value, element, param) {
	          var $otherElement = $(param);
	          return parseInt(value, 10) > parseInt($otherElement.val(), 10);
	    },'El horario de término no puede ser más temprano que el horario de comienzo');

	    $.validator.addMethod("percentage",function (value, element, param) {
	          
	          if($(param).val() == 'percentage' && parseInt(value, 10) > {{$max_prom_percentage}}){
	          	return false;
	          }else{
	          	return true;
	          }
	          
	    },'No puedes hacer un descuento de más del {{$max_prom_percentage}}%');

	    $.validator.addMethod("direct",function (value, element, param) {
	          
	          if($(param).val() == 'direct' && parseInt(value, 10) > {{$max_prom_direct}}){
	          	return false;
	          }else{
	          	return true;
	          }
	          
	    },'No puedes hacer un descuento de más del ${{$max_prom_direct}} pesos');

	    $.validator.addMethod("hour_price",function (value, element, param) {
	          
	          if($(param).val() == 'hour_price' && parseInt(value, 10) < {{$min_hour_price}}){
	          	return false;
	          }else{
	          	return true;
	          }
	          
	    },'No puedes bajar el precio a más allá de ${{$min_hour_price}} pesos');




		$("input[type=radio]").click(function () {
    		if($("input:radio[class='schedule_btn']").is(":checked")) {
    			$('.hours').css('display','none');
         		$('.schedule').css('display','block');       
			}else if($("input:radio[class='hours_btn']").is(":checked")) {
         		$('.hours').css('display','block'); 
         		$('.schedule').css('display','none');       
			}


		});
	});
</script>
	
@endsection

