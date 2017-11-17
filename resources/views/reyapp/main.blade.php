@extends('layouts.reyapp.landing')
@section('body_class', 'landing')
@section('header')

<link rel="stylesheet" href="{{asset('plugins/owlcarrousel/assets/owl.carousel.css')}}">
@endsection

@section('content')

<!-- STARTS: top bar-->
<nav class="top-bar topbar-responsive">
  <div class="top-bar-title">
    <span data-responsive-toggle="topbar-responsive" data-hide-for="medium">
      <button class="menu-icon" type="button" data-toggle></button>
    </span>
    <a class="topbar-responsive-logo" href="#"><img src=" http://reyapp.dev:8000/img/logo_rey.png " width="150" alt="logo"></a>
  </div>
  <div id="topbar-responsive" class="topbar-responsive-links">
    <div class="top-bar-right">
      <ul class="menu simple vertical medium-horizontal">
        <li><a href="/login/redirect">Iniciar Sesión</a></li>
        <li>
          <button type="button" class="button hollow topbar-responsive-button"><a href="/registro">Registrarme</a></button>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- ENDS: top bar-->
<div class="top-bar-clone">
  
</div>
<div class="slider_wrapper">

  <iframe style="position:absolute;top:0;left:0;margin-top:-10%;margin-left: -10% " frameborder="0" height="120%" width="120%" 
    src="https://youtube.com/embed/YtLlUS-Hq5Q?autoplay=1&loop=1&controls=0&showinfo=0&autohide=1">
  </iframe>
  <div class="owl-carousel owl-theme">
    <div class="item">
      <h2>Encuentra un espacio chingón para ensayar</h2>
      <p>Califica y checa la opinión de otras bandas y reserva aquí en cualquier momento</p>
    </div>
    <div class="item"><h4>2</h4></div>
    <div class="item"><h4>3</h4></div>
</div>
  <button class="button green large">REGÍSTRATE AHORA</button>
  {{-- <div id="muteYouTubeVideoPlayer"></div> --}}
</div>




<!--STARTS: Benefits -->
<div id="main-content-section" data-magellan-target="main-content-section">
  <div class="top-company">
    <h2>¿Para qué una sala de ensayo?</h2>
    <p class="text-center landing-subtitle">Simple, para dejar lo amateur y convertirte en todo un Pro</p>
    <div class="row">
      <div class="row large-up-2 small-up-2">
        <div class="featured-image-block column">
          <img src="http://reyapp.dev:8000/img/benefits-time.jpg" />
          <h3 class="text-center bullets-company">Tiempo de Calidad</h3>
          <p class="text-center description-salas">Ensaya desde que llegas hasta que te vas y no pierdas tiempo valioso.</p>
        </div>

        <div class="featured-image-block column">
          <img src="http://reyapp.dev:8000/img/benefits-amp.jpg" />
          <h3 class="text-center bullets-company">Equipo Profesional</h3>
          <p class="text-center description-salas">Deja de tocar con ese frankenstein, aquí hay equipo para Pro.</p>
        </div>
        <div class="featured-image-block column">
          <img src="http://reyapp.dev:8000/img/benefits-confort.jpg" />
          <h3 class="text-center bullets-company">Comodidad</h3>
          <p class="text-center description-salas">Sabemos que mereces la mayor comodidad, por eso nos preocupamos por la calidad de las Salas de Ensayo. ¡Tenemos las mejores!</p>
        </div>

        <div class="featured-image-block column">
          <img src="http://reyapp.dev:8000/img/benefits-soundproof.jpg" />
          <h3 class="text-center bullets-company">Espacios Insonorizados</h3>
          <p class="text-center description-salas">¿Cansado de que te digan que le bajes por que despiertas a la abuela? Tu sala de ensayo te está esperando.</p>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- ENDS: Benefits --}}

<!--STARTS: Feature -->
<div class="feature">
  <h2>Aquí encuentras la mejor sala para ensayar.</h2>
  <p  class="landing-subtitle text-center">Sabemos la importancia de los ensayos, por ello hemos puesto atención en los detalles</p>
  <div class="row">
    <div class="small-12 medium-3 columns">
      <i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i>
      <h4 class="feature-title text-center">Salas de Ensayo verificadas</h4>
      <p class="marketing-site-features-desc">Para tu seguridad, contamos con filtros de seguridad para brindarte la mejor experiencia.</p>
    </div>
    <div class="small-12 medium-3 columns hide-for-small-only">
      <i class="fa fa-star fa-2x" aria-hidden="true"></i>
      <h4 class="feature-title text-center">Ranking para mejorar</h4>
      <p class="marketing-site-features-desc">Con esto podremos contar con mejores servicios.</p>
    </div>
    <div class="small-12 medium-3 columns hide-for-small-only">
      <i class="fa fa-comments-o fa-2x" aria-hidden="true"></i>
      <h4 class="feature-title text-center">Comentarios para todos</h4>
      <p class="marketing-site-features-desc">¿Las estrellas no lo es todo? Deja tu comentario sobre la Sala Pro que reservaste.</p>
    </div>
    <div class="small-12 medium-3 columns hide-for-small-only">
      <i class="fa fa-calendar fa-2x" aria-hidden="true"></i>
      <h4 class="feature-title text-center">Diversificación de reservaciones</h4>
      <p class="marketing-site-features-desc">¿Tienes diversas bandas? No te preocupes, podrás saber cuál ensayo le corresponde a cada una.</p>
    </div>
  </div>
    <div class="row">
    <div class="small-12 medium-3 columns">
      <i class="fa fa-map-marker fa-2x" aria-hidden="true"></i>
      <h4 class="feature-title text-center">Salas al mejor precio cerca de ti</h4>
      <p class="marketing-site-features-desc">Ubicaremos la mejor Sala Pro cerca de donde te encuentres.</p>
    </div>
    <div class="small-12 medium-3 columns">
      <i class="fa fa-certificate fa-2x" aria-hidden="true"></i>
      <h4 class="feature-title text-center">Promociones exclusivas</h4>
      <p class="marketing-site-features-desc">Sólo aquí encontrarás promociones de las salas que no verás en otro lado.</p>
    </div>
    <div class="small-12 medium-3 columns hide-for-small-only">
      <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
      <h4 class="feature-title text-center">Conecta con tu banda</h4>
      <p class="marketing-site-features-desc">Al vincular usuarios con tu banda todos recibirán la notificación del ensayo.</p>
    </div>
    <div class="small-12 medium-3 columns">
      <i class="fa fa-lock fa-2x" aria-hidden="true"></i>
      <h4 class="feature-title text-center">Seguridad en tus pagos</h4>
      <p class="marketing-site-features-desc">No te preocupes, tus pagos están seguros en nuestra app, nada de que a chuchita la bolsearon.</p>
    </div>
  </div>
</div>
{{-- ENDS: feature--}}

<!--STARTS: testimonials-->
<!-- slider code -->

<div class="orbit testimonial-slider-container" role="region" aria-label="testimonial-slider" data-orbit>
  <ul class="orbit-container">
    <button class="orbit-previous"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
    <button class="orbit-next"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>


    <!-- content slide 1 -->

    <li class="is-active orbit-slide">
      <div class="testimonial-slide row">
        <div class="small-12 large-9 column">
          <div class="row align-middle testimonial-slide-content">
            <div class="small-12 medium-4 column hide-for-small-only profile-pic">
              <img src="https://placeimg.com/300/300/nature">
            </div>
            <div class="small-12 medium-8 column testimonial-slide-text">
              <p class="testimonial-slide-quotation">Muy rifada la página, siempre encuentra la mejor sala de ensayo cerca de mi ubicación en la CDMX.</p>
              <div class="testimonial-slide-author-container">
                <div class="small-profile-pic show-for-small-only">
                  <img src="https://placeimg.com/50/50/nature">
                </div>
                <p class="testimonial-slide-author-info">Richard González<br><i class="subheader">California Sound</i></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </li>

    <!--content slide 2 -->

    <li class="orbit-slide">
      <div class="testimonial-slide row">
        <div class="small-12 large-9 column">
          <div class="row align-middle testimonial-slide-content">
            <div class="small-12 medium-4 column hide-for-small-only profile-pic">
              <img src="https://placeimg.com/300/300/architecture">
            </div>
            <div class="small-12 medium-8 column testimonial-slide-text">
              <p class="testimonial-slide-quotation">Ya aparté mis ensayos de todo el mes en un solo momento. Muy buena página.</p>
              <div class="testimonial-slide-author-container">
                <div class="small-profile-pic show-for-small-only">
                  <img src="https://placeimg.com/50/50/architecture">
                </div>
                <p class="testimonial-slide-author-info">Tony Telecaster<br><i class="subheader">Virgenes Suicidas.<i></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </li>

    <!-- content slide 3 -->

    <li class="orbit-slide">
      <div class="testimonial-slide row">
        <div class="small-12 large-9 column">
          <div class="row align-middle testimonial-slide-content">
            <div class="small-12 medium-4 column hide-for-small-only profile-pic">
              <img src="https://placeimg.com/300/300/animals">
            </div>
            <div class="small-12 medium-8 column testimonial-slide-text">
              <p class="testimonial-slide-quotation">Vengo de Venezuela y desde allá pude apartar la sala de ensayo que fue un éxito. Grande la web.</p>
              <div class="testimonial-slide-author-container">
                <div class="small-profile-pic show-for-small-only">
                  <img src="https://placeimg.com/50/50/animals">
                </div>
                <p class="testimonial-slide-author-info">Jhonny Martin<br><i class="subheader">Mil Soles</i></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </li>

    <!-- content slide 4 -->

    <li class="orbit-slide">
      <div class="testimonial-slide row">
        <div class="small-12 large-9 column">
          <div class="row align-middle testimonial-slide-content">
            <div class="small-12 medium-4 column hide-for-small-only profile-pic">
              <img src="https://placeimg.com/300/300/any">
            </div>
            <div class="small-12 medium-8 column testimonial-slide-text">
              <p class="testimonial-slide-quotation">C mamaron con la app, muy buenas salas y sus promociones.</p>
              <div class="testimonial-slide-author-container">
                <div class="small-profile-pic show-for-small-only">
                  <img src="https://placeimg.com/50/50/any">
                </div>
                <p class="testimonial-slide-author-info">Ricky Fantoche<br><i class="subheader">Los Fantoches Ska</i></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div>

<!-- slider close -->


{{-- ENDS: testimonials --}}

<div class="marketing-site-hero">
  <div class="marketing-site-hero-content">
    <h1>Ensaya Pro, el inicio de tu carrera profesional.</h1>
    <p class="subheader" style="padding-bottom:20px;">Forma parte de la comunidad de músicos que serán las nuevas referencias de la música mexicana.</p>
    <a href="#" class="button expanded">Registrarme</a>

  </div>
</div>


@endsection

@section('scripts')

<script src="{{asset('plugins/owlcarrousel/owl.carousel.min.js')}}"></script>
<script async src="https://www.youtube.com/iframe_api"></script>
<script>
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
 function onYouTubeIframeAPIReady() {
  var player;
  player = new YT.Player('muteYouTubeVideoPlayer', {
    videoId: 'KCbCbUpURo8', // YouTube Video ID
    width: with_window,               // Player width (in px)
    height: 1000,              // Player height (in px)
    playerVars: {
      autoplay: 1,        // Auto-play the video on load
      controls: 1,        // Show pause/play buttons in player
      showinfo: 0,        // Hide the video title
      modestbranding: 1,  // Hide the Youtube Logo
      loop: 1,            // Run the video in a loop
      fs: 0,              // Hide the full screen button
      cc_load_policy: 0, // Hide closed captions
      iv_load_policy: 3,  // Hide the Video Annotations
      autohide: 0         // Hide video controls when playing
    },
    events: {
      onReady: function(e) {
        e.target.mute();
      }
    }
  });
 }

 // Written by @labnol 
</script>
@endsection
