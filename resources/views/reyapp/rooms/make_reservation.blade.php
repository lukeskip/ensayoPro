@extends('layouts.reyapp.main')

@section('style')
	<link rel="stylesheet" href="{{asset('pluglins/fullcalendar-3.5.1 2/fullcalendar.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/jquery-ui/jquery-ui.structure.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/jquery-ui/jquery-ui.theme.min.css')}}">
@endsection
@section('content')

<div class="row">
	<div class="medium-12 columns">
		<h1>{{$room->companies->name}}</h1>
		<h2>{{$room->name}}</h2>
	</div>
	<div class="medium-12 columns">
		<div id="datepicker">
            <input class="date required " name="date" type="hidden">
        </div>
	</div>
	
</div>
@endsection
@section('scripts')
	
	<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
	<script>
	$(document).ready(function (){
	// STARTS: DATE PICKER
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '< Ant',
		nextText: 'Sig >',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};

	$.datepicker.setDefaults($.datepicker.regional['es']);

	var fulldays = {};
    fulldays[new Date('04/05/2016')] = new Date('2017/09/02');
    fulldays[new Date('05/04/2016')] = new Date('2017/09/01');
    fulldays[new Date('06/06/2016')] = new Date('2017/09/09');

	$( "#datepicker" ).datepicker({
	 	dateFormat: 'yy-mm-dd', 
	 	minDate: 0,
	 	maxDate: "+2M",
	 	beforeShowDay: function(date) {
            var full = fulldays[date];
            if (full) {
            	console.log(date);
                return [true, "fullday", full];
            }
            else {
                return [true, '', ''];
            }
        },
	 	onSelect: function(dateText, inst) {
	 		$('.date').val($.datepicker.formatDate('yy-mm-dd', new Date($(this).datepicker('getDate'))));
	        console.log("hello");
		}
	});
// ENDS: DATE PICKER
});
		
	</script>
@endsection