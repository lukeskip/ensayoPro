@extends('layouts.reyapp.landing')
@section('body_class', 'landing')
@section('header')
{{-- Si quieres insertar algún archivo CSS va aquí, la siguiente linea es un ejemplo, el archivo tiene que estar cargado en la carpeta public --}}
{{-- <link rel="stylesheet" href="{{asset('js/vendor/selectize/css/selectize.default.css')}}"> --}}
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

<!--STARTS: slider-->
<div class="orbit clean-hero-slider" role="region" aria-label="Favorite Space Pictures" data-orbit>
  <div class="orbit-wrapper">
    <div class="orbit-controls">
      <button class="orbit-previous"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
      <button class="orbit-next"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
    </div>
    <ul class="orbit-container">
      <li class="orbit-slide">
        <figure class="orbit-figure">
          <img class="orbit-image" src=" http://reyapp.dev:8000/img/back_bass.jpg" alt="image alt text">
          <figcaption class="orbit-caption">
            <h3>Encuentra un espacio adecuado para tu ensayo</h3>
            <p>Deja de ensayar en la sala o en la vieja cochera, hoy es el día de profesionalizarte.</p>
          </figcaption>
        </figure>
      </li>
      <li class="orbit-slide">
        <figure class="orbit-figure">
          <img class="orbit-image" src="http://reyapp.dev:8000/img/back_drum.jpg" alt="image alt text">
          <figcaption class="orbit-caption">
            <h3>Práctica con equipo profesional</h3>
            <p>¿No tienes para tu amplo soñado? Encuentra la sala con tu equipo ideal.</p>
          </figcaption>
        </figure>
      </li>
      <li class="orbit-slide">
        <figure class="orbit-figure">
          <img class="orbit-image" src="http://reyapp.dev:8000/img/back_guitar.jpg" alt="image alt text">
          <figcaption class="orbit-caption">
            <h3>Ensaya en un espacio cómodo</h3>
            <p>La comodidad es fundamental para que sólo te preocupes por mejorar es a vuelta de coro.</p>
          </figcaption>
        </figure>
      </li>
    </ul>
  </div>
  <div class="bottom-content-section" data-magellan data-threshold="0">
    <a href="#main-content-section"><i class="fa fa-chevron-down fa-2x" aria-hidden="true"></i></a>
  </div>
  <nav class="orbit-button">
    <button class="button expanded"><a href="/registro">Registrarme</a></button>
  </nav>
</div>
{{-- ENDS: slider --}}

<!--STARTS: Benefits -->
<div id="main-content-section" data-magellan-target="main-content-section">
  <div class="top-company">
    <h2>¿Para qué una sala de ensayo?</h2>
    <p class="text-center landing-subtitle">Simple, para dejar lo amateur y convertirte en todo un Pro</p>
    <div class="row">
      <div class="row large-up-2 small-up-2">
        <div class="featured-image-block column">
          <img src="http://reyapp.dev:8000/img/benefits-time.jpg" />
          <h4 class="text-center bullets-company">Tiempo de Calidad</h4>
          <h5 class="text-center description-salas">Ensaya desde que llegas hasta que te vas y no pierdas tiempo valioso.</h5>
        </div>

        <div class="featured-image-block column">
          <img src="http://reyapp.dev:8000/img/benefits-amp.jpg" />
          <h4 class="text-center bullets-company">Equipo Profesional</h4>
          <h5 class="text-center description-salas">Deja de tocar con ese frankenstein, aquí hay equipo para Pro.</h5>
        </div>
        <div class="featured-image-block column">
          <img src="http://reyapp.dev:8000/img/benefits-confort.jpg" />
          <h4 class="text-center bullets-company">Comodidad</h4>
          <h5 class="text-center description-salas">Sabemos que mereces la mayor comodidad, por eso nos preocupamos por la calidad de las Salas de Ensayo. ¡Tenemos las mejores!</h5>
        </div>

        <div class="featured-image-block column">
          <img src="http://reyapp.dev:8000/img/benefits-soundproof.jpg" />
          <h4 class="text-center bullets-company">Espacios Insonorizados</h4>
          <h5 class="text-center description-salas">¿Cansado de que te digan que le bajes por que despiertas a la abuela? Tu sala de ensayo te está esperando.</h5>
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
{{-- Si quieres cargar un archivo de javascript como un plugin lo insertas aqui, la siguiente linea es un ejemplo, igual el archivo tiene que estar en la carpeta de public --}}
{{-- <script src="{{asset('js/vendor/jquery.js')}}"></script> --}}
@endsection
