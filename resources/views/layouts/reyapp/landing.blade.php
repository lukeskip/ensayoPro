<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>EnsayoPro</title>
		<link rel="stylesheet" href="{{asset('js/vendor/selectize/css/selectize.default.css')}}">
		<link rel="stylesheet" href="{{asset('css/foundation.css')}}">

		<link rel="shortcut icon" type="favicon/png" href="{{asset('img/favicon.png')}}"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>

		<link rel="stylesheet" href="{{asset('js/vendor/jquery-ui/jquery-ui.min.css')}}">
		<link rel="stylesheet" href="{{asset('plugins/colorpicker/css/evol-colorpicker.min.css')}}">
		<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.css')}}">
		<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/swal-forms.css')}}">
		<link rel="stylesheet" href="{{asset('plugins/fine-uploader/fine-uploader-gallery.min.css')}}">

		@yield('styles')

		<link rel="stylesheet" href="{{asset('css/app.css')}}">

		<meta property="og:url"                content="http://setlist.reydecibel.com.mx" />
		<meta property="og:title"              content="EnsayoPro" />
		<meta property="og:description"        content="Renta la sala de ensayo que más te convenga, muchas opciones" />
		<meta property="og:image"              content="{{asset('img/facebook_share.png')}}" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<meta name="description" content="Renta la sala de ensayo que más te convenga, muchas opciones" />
		<meta name="keywords" content="setlist, bandas, show, tocada, bandas independientes" />
		<meta name="author" content="Rey Decibel">
		<meta name="robots" content="index, follow">
		<meta name="revisit-after" content="3 month">
		
		<script type="text/javascript">
			var APP_URL = {!! json_encode(url('/')) !!}
		</script>
		@yield('header')

		<title>Ensaya Pro</title>

	</head>
	<body class="@yield('body_class')">
		<!-- STARTS: Preloader -->
		<div class="loader-wrapper">
			<div class="loader">
				{{-- <img src="assets/img/elements/logo-full.png"> --}}
				<div class="bars-animation">
					<div class="bar one"></div>
					<div class="bar two"></div>
					<div class="bar three"></div>
					<div class="bar four"></div>
					<div class="bar five"></div>
				</div>
			</div>
		</div>
		
		<!-- ENDS: Preloader -->
		<div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas>

		    <!-- Close button -->
		    <button class="close-button" aria-label="Close menu" type="button" data-close>
		      <span aria-hidden="true">&times;</span>
		    </button>

		    <!-- Menu -->
		    <div class="logo_menu ext-center">
		    	<img src="{{asset('img/logo_rey.png')}}" alt="" width="200px;">
		    </div>


		    <div class="legal">

				Todos los derechos reservados,2017. <a style="color:white" target="_blank" href="http://www.reydecibel.com.mx/terminos-condiciones-generador-setlists/">Términos y condiciones</a>
			</div>
			<!-- ENDS: Menu -->
	</div>

	<div class="off-canvas-content" data-off-canvas-content>

		{{-- <div class="beta">Alpha</div> --}}
		<div class="loader_wrapper">
			<div class="loader"></div>
		</div>

		<div class="container">

			<h1 class="text-center">
				@yield('title')
			</h1>



			@yield('content')



		</div><!--END: CONTAINER-->

	</div><!-- END OFF CANVAS WRAPPER-->

		<footer>
			<div><img src=" {{asset('img/logo_rey.png')}} " width="100" alt=""></div>
			Todos los derechos reservados,2017. <a style="color:white" href="http://www.reydecibel.com.mx/terminos-condiciones-generador-setlists/">Términos y condiciones</a>
		</footer>

		@yield('modal')


		<script src="{{asset('js/vendor/jquery.js')}}"></script>
		<script src="{{asset('js/vendor/jquery-ui/jquery-ui.min.js')}}"></script>
		<script src="{{asset('plugins/colorpicker/js/evol-colorpicker.min.js')}}"></script>
		<script src="{{asset('js/vendor/jquery-ui/touchpunch.js')}}"></script>
		<script src="{{asset('js/laroute.js')}}"></script>
		<script src="{{asset('js/vendor/what-input.js')}}"></script>
		<script src="{{asset('js/vendor/foundation.js')}}"></script>
		<script src="{{asset('js/vendor/selectize/js/selectize.min.js')}}"></script>
		<script src="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.js')}}"></script>
  		<script src="{{asset('plugins/swal-forms-master/swal-forms.js')}}"></script>
		<script src="{{asset('js/bower_components/chart.js/dist/Chart.min.js')}}"></script>
    	<script src="{{asset('plugins/jquery-validation-1.17.0/dist/jquery.validate.min.js')}}"></script>

		<script src="{{asset('plugins/fine-uploader/jquery.fine-uploader.js')}}"></script>

		<script src="{{asset('js/app.js')}}"></script>



		@yield('scripts')
	</body>
</html>
