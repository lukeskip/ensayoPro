<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Rey Decibel Tools</title>
		<link rel="stylesheet" href="{{asset('css/foundation.css')}}">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="shortcut icon" type="favicon/png" href="{{asset('img/favicon.png')}}"/>
		
		<link rel="stylesheet" href="{{asset('js/vendor/jquery-ui/jquery-ui.min.css')}}">
		<link rel="stylesheet" href="{{asset('js/vendor/owl.carousel/assets/owl.carousel.min.css')}}">
		<link rel="stylesheet" href="{{asset('js/vendor/sweetalert/sweetalert.css')}}">

		<link rel="stylesheet" href="{{asset('css/app.css')}}">
		
		<meta property="og:url"                content="http://setlist.reydecibel.com.mx" />
		<meta property="og:title"              content="Generador de Setlist" />
		<meta property="og:description"        content="Esta es una gran herramienta, indispensable para bandas independientes" />
		<meta property="og:image"              content="{{asset('img/facebook_share.png')}}" />

		<script type="text/javascript">
			var APP_URL = {!! json_encode(url('/')) !!}
		</script>
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<meta name="description" content="Esta es una plataforma que te ayudará a generar los setlists para tu show o tocadas" />
		<meta name="keywords" content="setlist, bandas, show, tocada, bandas independientes" />
		<meta name="author" content="metatags generator">
		<meta name="robots" content="index, follow">
		<meta name="revisit-after" content="3 month">

		<title>Generador de Setlists</title>

	</head>
	<body>
		<div class="beta">Beta</div>
		<div class="loader_wrapper">
			<div class="loader"></div>
		</div>	
			
			
			
			@yield('content')	
				
					
				
		
		<footer>
			<div><img src=" {{asset('img/logo_rey.png')}} " width="100" alt=""></div>
			Todos los derechos reservados,2017. <a style="color:white" href="http://www.reydecibel.com.mx/terminos-condiciones-generador-setlists/">Términos y condiciones</a>
		</footer>

		@yield('modal')
		
		
		<script src="{{asset('js/vendor/jquery.js')}}"></script>
		<script src="{{asset('js/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
		<script src="{{asset('js/vendor/jquery-ui/jquery-ui.min.js')}}"></script>
		<script src="{{asset('js/vendor/jquery-ui/touchpunch.js')}}"></script>
		<script src="{{asset('js/laroute.js')}}"></script>
		<script src="{{asset('js/vendor/what-input.js')}}"></script>
		<script src="{{asset('js/vendor/foundation.js')}}"></script>
		<script src="{{asset('js/vendor/sweetalert/sweetalert.min.js')}}"></script>
		{{-- <script src="{{asset('plugins/angular/angular.min.js')}}"></script> --}}


		<script src="{{asset('js/app_presskit.js')}}"></script>

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-73222704-1', 'auto');
		  ga('send', 'pageview');

		</script>

		@yield('javascript')
	</body>
</html>

