<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Ensaya Pro</title>
		<link rel="stylesheet" href="{{asset('js/vendor/selectize/css/selectize.default.css')}}">
		<link rel="stylesheet" href="{{asset('css/foundation.css')}}">

		<link rel="shortcut icon" type="favicon/png" href="{{asset('img/favicon.png')}}"/>
		
		<link rel="stylesheet" href="{{asset('js/vendor/jquery-ui/jquery-ui.min.css')}}">
		<link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.css')}}">
		<link rel="stylesheet" href="{{asset('plugins/fine-uploader/fine-uploader-gallery.min.css')}}">
		

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
		
		{{-- STARTS: fine Uploader --}}
		
		<script type="text/template" id="qq-template">
		    <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
		        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
		            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
		        </div>
		        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
		            <span class="qq-upload-drop-area-text-selector"></span>
		        </div>
		        <div class="qq-upload-button-selector qq-upload-button">
		            <div>Sube tus imágenes</div>
		        </div>
		        <span class="qq-drop-processing-selector qq-drop-processing">
		            <span>Processing dropped files...</span>
		            <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
		        </span>
		        <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
		            <li>
		                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
		                <div class="qq-progress-bar-container-selector qq-progress-bar-container">
		                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
		                </div>
		                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
		                <div class="qq-thumbnail-wrapper">
		                    <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
		                </div>
		                <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
		                <button type="button" class="qq-upload-retry-selector qq-upload-retry">
		                    <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
		                    Retry
		                </button>

		                <div class="qq-file-info">
		                    <div class="qq-file-name">
		                        <span class="qq-upload-file-selector qq-upload-file"></span>
		                        <span class="qq-edit-filename-icon-selector qq-btn qq-edit-filename-icon" aria-label="Edit filename"></span>
		                    </div>
		                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
		                    <span class="qq-upload-size-selector qq-upload-size"></span>
		                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
		                        <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
		                    </button>
		                    <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
		                        <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
		                    </button>
		                    <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
		                        <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
		                    </button>
		                </div>
		            </li>
		        </ul>

		        <dialog class="qq-alert-dialog-selector">
		            <div class="qq-dialog-message-selector"></div>
		            <div class="qq-dialog-buttons">
		                <button type="button" class="qq-cancel-button-selector">Close</button>
		            </div>
		        </dialog>

		        <dialog class="qq-confirm-dialog-selector">
		            <div class="qq-dialog-message-selector"></div>
		            <div class="qq-dialog-buttons">
		                <button type="button" class="qq-cancel-button-selector">No</button>
		                <button type="button" class="qq-ok-button-selector">Yes</button>
		            </div>
		        </dialog>

		        <dialog class="qq-prompt-dialog-selector">
		            <div class="qq-dialog-message-selector"></div>
		            <input type="text">
		            <div class="qq-dialog-buttons">
		                <button type="button" class="qq-cancel-button-selector">Cancel</button>
		                <button type="button" class="qq-ok-button-selector">Ok</button>
		            </div>
		        </dialog>
		    </div>
		</script>

		{{-- ENDS: Fine Uploader --}}

		<title>Ensaya Pro</title>



	</head>
	<body>
		<div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas>

		    <!-- Close button -->
		    <button class="close-button" aria-label="Close menu" type="button" data-close>
		      <span aria-hidden="true">&times;</span>
		    </button>

		    <!-- Menu -->
		    <div class="logo_menu ext-center">
		    	<img src="{{asset('img/logo_rey.png')}}" alt="" width="200px;">
		    </div>

		    <ul class="vertical menu">
				<li>
					
					<a target="_blank" href="/users/{{Auth::user()->id}}">
					<i class="fa fa-user" aria-hidden="true"></i> {{Auth::user()->name}}
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
				<li>
					<a href="/logout">
						<i class="fa fa-sign-out" aria-hidden="true"></i> Salir
					</a>
				</li>
		    </ul>
		    <div class="legal">

				Todos los derechos reservados,2017. <a style="color:white" target="_blank" href="http://www.reydecibel.com.mx/terminos-condiciones-generador-setlists/">Términos y condiciones</a>
			</div>
			<!-- ENDS: Menu -->
	</div>

	<div class="off-canvas-content" data-off-canvas-content>
		 
		<div class="beta">Alpha</div>
		<div class="loader_wrapper">
			<div class="loader"></div>
		</div>	
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
			Todos los derechos reservados,2017. <a style="color:white" href="http://www.reydecibel.com.mx/terminos-condiciones-generador-setlists/">Términos y condiciones</a>
		</footer>

		@yield('modal')
		
		
		<script src="{{asset('js/vendor/jquery.js')}}"></script>
		<script src="{{asset('js/vendor/jquery-ui/jquery-ui.min.js')}}"></script>
		<script src="{{asset('js/vendor/jquery-ui/touchpunch.js')}}"></script>
		<script src="{{asset('js/laroute.js')}}"></script>
		<script src="{{asset('js/vendor/what-input.js')}}"></script>
		<script src="{{asset('js/vendor/foundation.js')}}"></script>
		<script src="{{asset('js/vendor/selectize/js/selectize.min.js')}}"></script>
		<script src="{{asset('plugins/sweetalert2/sweetalert2.js')}}"></script>
		<script src="{{asset('js/bower_components/chart.js/dist/Chart.min.js')}}"></script>

		<script src="{{asset('plugins/fine-uploader/fine-uploader.js')}}"></script>

		<script src="{{asset('js/app.js')}}"></script>

		

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-73222704-1', 'auto');
		  ga('send', 'pageview');

		</script>

		@yield('scripts')
	</body>
</html>

