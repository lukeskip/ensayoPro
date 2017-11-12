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
    <a href="#main-content-section"><i class="fa fa-chevron-down fa-3x" aria-hidden="true"></i></a>
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
    <p class="text-center">Simple, en una sala de ensayo encontrarás el espacio ideal para ser todo un Pro en la música ya que cuenta con:</p>
    <div class="row">
      <div class="row large-up-2 small-up-2">
        <div class="featured-image-block column">
          <img src="http://reyapp.dev:8000/img/benefits-time.jpg" />
          <p class="text-center bullets-company">Tiempo de Calidad</p>
        </div>

        <div class="featured-image-block column">
          <img src="http://reyapp.dev:8000/img/benefits-amp.jpg" />
          <p class="text-center bullets-company">Equipo Profesional</p>
        </div>
        <div class="featured-image-block column">
          <img src="http://reyapp.dev:8000/img/benefits-confort.jpg" />
          <p class="text-center bullets-company">Comodidad</p>
        </div>

        <div class="featured-image-block column">
          <img src="http://reyapp.dev:8000/img/benefits-soundproof.jpg" />
          <p class="text-center bullets-company">Audio Insonorizado</p>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- ENDS: Benefits --}}

@endsection

@section('scripts')
{{-- Si quieres cargar un archivo de javascript como un plugin lo insertas aqui, la siguiente linea es un ejemplo, igual el archivo tiene que estar en la carpeta de public --}}
{{-- <script src="{{asset('js/vendor/jquery.js')}}"></script> --}}
@endsection
