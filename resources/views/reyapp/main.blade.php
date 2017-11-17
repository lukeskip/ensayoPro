@extends('layouts.reyapp.landing')
@section('body_class', 'landing')
@section('header')

<link rel="stylesheet" href="{{asset('plugins/owlcarrousel/assets/owl.carousel.css')}}">
<link rel="stylesheet" href="{{asset('plugins/videoback/src/youtubebackground.css')}}">
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

  {{-- <iframe style="position:absolute;top:0;left:0;margin-top:-10%;margin-left: -10% " frameborder="0" height="120%" width="120%" 
    src="https://youtube.com/embed/YtLlUS-Hq5Q?autoplay=1&loop=1&controls=0&showinfo=0&autohide=1">
  </iframe> --}}
  <div id="background-video" class="background-video">
    <img src="images/placeholder.jpg" alt="" class="placeholder-image">
  </div>
  <div class="owl-carousel owl-theme">
    <div class="item">
      <h2>Encuentra un espacio chingón para ensayar</h2>
      <p>Califica y checa la opinión de otras bandas y reserva aquí en cualquier momento</p>
    </div>
    <div class="item">
      <h2>Ensaya con el amplo que siempre has querido</h2>
      <p>Una sala de ensayo está equipada con lo mejor, ¿Marshall de bulbos?, ¿Ampeg de 400 watts? ¿Batería Tama? Encuéntralo en nuestra lista de las mejores salas de ensayo </p>
    </div>
    <div class="item"><h4>3</h4></div>
</div>
  <button class="button green large">REGÍSTRATE AHORA</button>
</div>




<!--STARTS: Benefits -->
<div id="main-content-section" data-magellan-target="main-content-section">
  <div class="top-company">
    <h1>¿Para qué una sala de ensayo?</h1>
    <p class="text-center landing-subtitle">Simple, para dejar lo amateur y convertirte en todo un Pro</p>
    <div class="row">
      <div class="row large-up-2 small-up-2">
        <div class="featured-image-block column">
          <img src="{{asset('img/musico_ensayo_1.png')}}" with='100%'/>
          <h2 class="text-center bullets-company">Tiempo de Calidad</h2>
          <p class="text-center description-salas">Ensaya desde que llegas hasta que te vas y no pierdas tiempo valioso.</p>
        </div>

        <div class="featured-image-block column">
          <img src="{{asset('img/musico_ensayo_2.png')}}" with='100%'/>
          <h2 class="text-center bullets-company">Equipo Profesional</h2>
          <p class="text-center description-salas">Deja de tocar con ese frankenstein, aquí hay equipo para Pro.</p>
        </div>
        <div class="featured-image-block column">
          <img src="{{asset('img/musico_ensayo_3.png')}}" with='100%'/>
          <h2 class="text-center bullets-company">Comodidad</h2>
          <p class="text-center description-salas">Sabemos que mereces la mayor comodidad, por eso nos preocupamos por la calidad de las Salas de Ensayo. ¡Tenemos las mejores!</p>
        </div>

        <div class="featured-image-block column">
          <img src="{{asset('img/musico_ensayo_4.png')}}" with='100%'/>
          <h2 class="text-center bullets-company">Espacios Insonorizados</h2>
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
    <div class="row">
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
        videoId: 'YtLlUS-Hq5Q',
        pauseOnScroll: false,
        playerVars: {
          modestbranding: 0,
          autoplay: 1,
          controls: 1,
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
