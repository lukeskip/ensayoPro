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
		<link rel="stylesheet" href="{{asset('js/vendor/jquery-ui/jquery-ui.theme.min.css')}}">
		<link rel="stylesheet" href="{{asset('plugins/colorpicker/css/evol-colorpicker.min.css')}}">
		<link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.css')}}">
		
		<link rel="stylesheet" href="{{asset('plugins/chosen/chosen.min.css')}}">
		<link rel="stylesheet" href="{{asset('plugins/fine-uploader/fine-uploader-gallery.min.css')}}">
		<link rel="stylesheet" href="{{asset('plugins/bar-rating/themes/fontawesome-stars.css')}}">
		
		@yield('styles')

		<link rel="stylesheet" href="{{asset('css/app.css')}}">
		
		<script type="text/javascript">
			var APP_URL = {!! json_encode(url('/')) !!}
		</script>
		
		@yield('header')

		<title>Ensaya Pro</title>

		<script type="text/javascript"> //<![CDATA[ 
		var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.comodo.com/" : "http://www.trustlogo.com/");
		document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
		//]]>
		</script>
		@yield('metatags')

	</head>
	<body class="@yield('body_class')">
		
		<!-- STARTS: Preloader -->
		<div class="loader-wrapper">
			<div class="loader">
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
		    <div class="logo_menu text-center">
		    	<a href="/">
		    		<img src="{{asset('img/logo_ensayo_white.png')}}" alt="" width="150px;">
		    	</a>
		    </div>
		    <br><br>

		    <ul class="vertical menu">
				@if(!Auth::guest())

					{{-- STARTS: admin Menu --}}
					@if (Auth::user()->roles->first()->name == 'admin')

						<li>
							<a href="/usuarios/{{Auth::user()->id}}">
								<i class="fa fa-user" aria-hidden="true"></i> {{Auth::user()->name}}
							</a>
						</li>
						<li>
							<a href="/admin/">
								<i class="fa fa-line-chart" aria-hidden="true"></i> Dashboard
							</a>
						</li>
						<li>
							<a href="/admin/users">
								<i class="fa fa-users" aria-hidden="true"></i> Usuarios
							</a>
						</li>
						<li>
							<a href="/admin/companies">
								<i class="fa fa-users" aria-hidden="true"></i> Compañías
							</a>
						</li>
						<li>
							<a href="/salas">
								<i class="fa fa-calendar-o" aria-hidden="true"></i> Salas
							</a>
						</li>
						<li>
							<a href="/admin/salas">
								<i class="fa fa-calendar-o" aria-hidden="true"></i> Reservaciones
							</a>
						</li>

						<li>
							<a href="/admin/pagos">
								<i class="fa fa-credit-card-alt" aria-hidden="true"></i> Pagos
							</a>
						</li>

						<li>
							<a href="/admin/ajustes">
								<i class="fa fa-cogs" aria-hidden="true"></i> Ajustes
							</a>
						</li>

						<li>
							<a href="/logout">
								<i class="fa fa-sign-out" aria-hidden="true"></i> Salir
							</a>
						</li>

					{{-- ENDS: admin Menu --}}
					
					{{-- STARTS: Company Menu --}}
					@elseif(Auth::user()->roles->first()->name == 'company')
						<li>
							<a href="/usuarios/{{Auth::user()->id}}">
								<i class="fa fa-user" aria-hidden="true"></i> {{Auth::user()->name}}
							</a>
						</li>
						<li>
							<a href="/company">
								<i class="fa fa-line-chart" aria-hidden="true"></i> Dashboard
							</a>
						</li>
						<li>
							<a href="/company/salas">
								<i class="fa fa-music" aria-hidden="true"></i> Mis Salas
							</a>
						</li>
						<li>
							<a href="/company/ajustes">
								<i class="fa fa-cogs" aria-hidden="true"></i> Ajustes
							</a>
						</li>
						<li>
							<a href="/company/agenda">
								<i class="fa fa-calendar-o" aria-hidden="true"></i> Agenda
							</a>
						</li>
						<li>
							<a href="/logout">
								<i class="fa fa-sign-out" aria-hidden="true"></i> Salir
							</a>
						</li>
					{{-- ENDS: Company Menu --}}
					
					{{-- STARTS: Musician Menu --}}
					@elseif (Auth::user()->roles->first()->name == 'musician')

						<li>
							<a href="/usuarios/{{Auth::user()->id}}">
								<i class="fa fa-user" aria-hidden="true"></i> {{Auth::user()->name}}
							</a>
						</li>
						<li>
							<a href="/musico/bienvenido">
								<i class="fa fa-line-chart" aria-hidden="true"></i> Dashboard
							</a>
						</li>
						<li>
							<a href="/musico/agenda">
								<i class="fa fa-calendar-o" aria-hidden="true"></i> Agenda
							</a>
						</li>
						<li>
							<a href="/musico/bandas">
								<i class="fa fa-users" aria-hidden="true"></i> Tus bandas
							</a>
						</li>
						<li>
							<a href="/salas">
								<i class="fa fa-calendar-o" aria-hidden="true"></i> Reserva tu ensayo
							</a>
						</li>

						<li>
							<a href="/logout">
								<i class="fa fa-sign-out" aria-hidden="true"></i> Salir
							</a>
						</li>

					{{-- ENDS: Musician Menu --}}

					@endif

				@else

					<li>
						
						<a href="/login">
							<i class="fa fa-sign-in" aria-hidden="true"></i> Logéate
						</a>
					</li>
					<li>
						
						<a href="/registro">
							<i class="fa fa-check-square-o" aria-hidden="true"></i> Regístrate
						</a>
					</li>
					<li>
						
						<a target="_blank" href="http://reydecibel.com.mx">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> Blog
						</a>
					</li>
					@yield('menu_extra')
					<li>
						<a target="_blank" href="https://www.facebook.com/ReyDecibelMx/">
						<i class="fa fa-facebook-official" aria-hidden="true"></i> Síguenos
					</a>
					

				@endif <!-- END IF AUTH-->
				
		    </ul>
		    <div class="legal">

				Todos los derechos reservados,2017. <a style="color:white" target="_blank" href="http://www.reydecibel.com.mx/terminos-condiciones-generador-setlists/">Términos y condiciones</a>
			</div>
			<div class="logo_menu text-center">
		    	<a href="http://reydecibel.com.mx" target="_blank"><img src="{{asset('img/logo_rey.png')}}" alt="" width="150px;"></a>
		    </div>
			<!-- ENDS: Menu -->
	</div>

	<div class="off-canvas-content" data-off-canvas-content>
		 
		<a class="menu_start" data-toggle="offCanvasLeft">
			<i class="fa fa-bars" aria-hidden="true"></i>
			MENÚ
		</a>
		<div class="container">
			
			<h1 class="text-center">
				@yield('title')
			</h1>
			

			
			@yield('content')	
				
				
				
		</div><!--END: CONTAINER-->
				
	</div><!-- END OFF CANVAS WRAPPER-->
	
		<footer>
			<div><img src=" {{asset('img/logo_rey.png')}} " width="100" alt=""></div>
			Todos los derechos reservados,2017. <a style="color:white" href="/terminos-y-condiciones">Términos y condiciones</a>
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
		<script src="{{asset('plugins/sweetalert2/sweetalert2.js')}}"></script>
		<script src="{{asset('plugins/chosen/chosen.jquery.min.js')}}"></script>
		<script src="{{asset('js/bower_components/chart.js/dist/Chart.min.js')}}"></script>
    	<script src="{{asset('plugins/jquery-validation-1.17.0/dist/jquery.validate.min.js')}}"></script>
    	<script src="{{asset('plugins/bar-rating/jquery.barrating.min.js')}}"></script>
    	

		<script src="{{asset('plugins/fine-uploader/jquery.fine-uploader.js')}}"></script>

		<script src="{{asset('js/app.js')}}"></script>


		@yield('scripts')


		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-73222704-2"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-73222704-2');
		</script>
			</body>
		</html>

