@extends('layouts.reyapp.main_front')
@section('body_class', 'landing')
@section('header')

<link rel="stylesheet" href="{{asset('plugins/owlcarrousel/assets/owl.carousel.css')}}">
<link rel="stylesheet" href="{{asset('plugins/videoback/src/youtubebackground.css')}}">
@endsection

@section('content')

<div class="slider_wrapper">

	<div id="background-video" class="background-video">
		<img src="{{asset('img/placeholder.jpg')}}" alt="" class="placeholder-image">
	</div>
	<div class="owl-carousel owl-theme">
		 <div class="item">
			<div class="wrapper">
				<div class="text-center"><img src="{{asset('img/logo_ensayo.png')}}"></div>
				<br>
				<h2>Encuentra un espacio chingón para ensayar o grabar</h2>
				<p class="show-for-large">Califica y checa la opinión de otras bandas, además reserva aquí mismo tu ensayo en cualquier momento</p>
			</div>
		</div>
		 <div class="item">
			<div class="wrapper">
				<div class="text-center"><img src="{{asset('img/logo_ensayo.png')}}"></div>
				<br>
				<h2>Ensaya con el amplo que siempre has querido</h2>
				<p class="show-for-large">Encuéntralo en nuestra lista de las mejores salas de ensayo. </p>
			</div>
			
		</div>
		
		
	 
</div>
	<div class="buttons">
		<a class="button green " href="/salas">Salas de Ensayo</a>

		 <a class="button blue " href="/estudios-de-grabacion">Estudios de Grabación</a>
	</div>
		 
		
		 

	</div>
</div>


<!--STARTS: Benefits -->

<div class="top-company">
	<h1>¿Para qué una sala de ensayo?</h1>
	<p class="text-center landing-subtitle">Una sala de ensayo es un espacio equipado con amplificadores (backline), consola, bocinas y todo lo necesario para que una banda ensaye cómodamente. Todas las bandas emergentes ensayan en este tipo de lugares.</p>
	<p class="text-center landing-subtitle">Ensayo Pro es una plataforma que te permite comparar diferentes salas de ensayo en tu ciudad y reservarlas aquí mismo y tener una agenda sincronizada con tu banda para que sean más productivos y puedan llegar más lejos.</p>
	<div class="row a">
			<div class="columns medium-6 text-center">
				<img src="{{asset('img/musico_ensayo_1.png')}}" with='100%'/>
				<h2 class="text-center bullets-company">Tiempo de Calidad</h2>
				<p class="text-center description-salas">Ensaya desde que llegas hasta que te vas y no pierdas tiempo valioso.</p>
			</div>

			<div class="columns medium-6 text-center">
				<img src="{{asset('img/musico_ensayo_2.png')}}" with='100%'/>
				<h2 class="text-center bullets-company">Pura cosa chida</h2>
				<p class="text-center description-salas">Califica y comenta sobre tus salas favoritas así otros músicos podrán tomar buenas decisiones.</p>
				
			</div>
			<div class="columns medium-6 text-center">
				<img src="{{asset('img/musico_ensayo_3.png')}}" with='100%'/>
				<h2 class="text-center bullets-company">Equipo Profesional</h2>
				<p class="text-center description-salas">Deja de tocar con ese frankenstein, aquí hay equipo para Pro.</p>
				
			</div>

			<div class="columns medium-6 text-center">
				<img src="{{asset('img/musico_ensayo_4.png')}}" with='100%'/>
				<h2 class="text-center bullets-company">Espacios Insonorizados</h2>
				<p class="text-center description-salas">Diseña tu sonido sin que nadie te joda con que haces ruido.</p>
			</div>
	</div>
</div>

{{-- ENDS: Benefits --}}

<!--STARTS: Feature -->
<div class="feature">
	<h2>Aquí encuentras la mejor sala para ensayar.</h2>
	<p  class="landing-subtitle text-center">Sabemos la importancia de los ensayos, por ello hemos puesto atención en los detalles</p>
	<div class="row b">
		<div class="feature-item small-12 medium-4 columns hide-for-small-only">
			<div class="icon"><i class="fa fa-star fa-2x" aria-hidden="true"></i></div>
			<h3 class="feature-title text-center">Ranking para mejorar</h3>
			<p class="marketing-site-features-desc">Con esto podremos contar con mejores servicios.</p>
		</div>
		<div class="feature-item small-12 medium-4 columns hide-for-small-only">
			<div class="icon"><i class="fa fa-comments-o fa-2x" aria-hidden="true"></i></div>
			<h3 class="feature-title text-center">Comentarios para todos</h3>
			<p class="marketing-site-features-desc">¿Las estrellas no lo es todo? Deja tu comentario sobre la Sala Pro que reservaste.</p>
		</div>
		<div class="feature-item small-12 medium-4 columns hide-for-small-only">
			<div class="icon"><i class="fa fa-calendar fa-2x" aria-hidden="true"></i></div>
			<h3 class="feature-title text-center">Diversificación</h3>
			<p class="marketing-site-features-desc">¿Tienes diversas bandas? No te preocupes, podrás saber cuál ensayo le corresponde a cada una.</p>
		</div>
	</div>
	<div class="row d">
		<div class="feature-item small-12 medium-4 columns">
			<div class="icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></div>
			<h3 class="feature-title text-center">El mejor precio cerca de ti</h3>
			<p class="marketing-site-features-desc">Ubicaremos la mejor Sala Pro cerca de donde te encuentres.</p>
		</div>
		<div class="feature-item small-12 medium-4 columns">
			<div class="icon"><i class="fa fa-certificate fa-2x" aria-hidden="true"></i></div>
			<h3 class="feature-title text-center">Promociones exclusivas</h3>
			<p class="marketing-site-features-desc">Sólo aquí encontrarás promociones de las salas que no verás en otro lado.</p>
		</div>
		<div class="feature-item small-12 medium-4 columns hide-for-small-only">
			<div class="icon"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></div>
			<h3 class="feature-title text-center">Conecta con tu banda</h3>
			<p class="marketing-site-features-desc">Al vincular usuarios con tu banda todos recibirán la notificación del ensayo.</p>
		</div>
	</div>
</div>
{{-- ENDS: feature--}}

@endsection

@section('scripts')

<script src="{{asset('plugins/videoback/src/jquery.youtubebackground.js')}}"></script>
<script src="{{asset('plugins/owlcarrousel/owl.carousel.min.js')}}"></script>
<script async src="https://www.youtube.com/iframe_api"></script>
<script>
$(document).ready(function(){


 with_window = $(window).width();
 height_window = $(window).height();
 top_bar_height = $('.top-bar').height();
 $('.slider_wrapper').height(height_window - top_bar_height);
 $('.owl-carousel').owlCarousel({
		loop:true,
		margin:10,
		nav:true,
		items: 1,
		navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"]
})

 $('#background-video').YTPlayer({
				fitToBackground: false,
				videoId: 'V2fpgpanZAw',
				pauseOnScroll: false,
				playerVars: {
					modestbranding: 0,
					autoplay: 1,
					controls: 0,
					showinfo: 0,
					branding: 0,
					rel: 0,
					autohide: 0
				}
			});
 
});
 // Written by @labnol 
</script>
@endsection
