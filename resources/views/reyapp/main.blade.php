@extends('layouts.reyapp.landing')
@section('header')
<!-- top bar-->
<div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium">
  <button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
  <div class="title-bar-title">Menu</div>
</div>

<div class="top-bar" id="responsive-menu">
  <div class="top-bar-left">
    <ul class="dropdown menu" data-dropdown-menu>
      <li class="menu-text"><img src=" http://reyapp.dev:8000/img/logo_rey.png " width="150" alt="logo"></li>

    </ul>
  </div>
  <div class="top-bar-right">
    <ul class="menu">
      <li><a href="/login/redirect">Iniciar Sesión</a></li>
      <li><a href="/registro">Registrarme</a></li>
    </ul>
  </div>
</div>
@section('content')

<!-- slider-->
<div class="large-12">
<div class="fullscreen-image-slider">
  <div class="orbit" role="region" aria-label="FullScreen Pictures" data-orbit>
    <ul class="orbit-container">
      <button class="orbit-previous">
        <span class="show-for-sr">Previous Slide</span>
        <span class="nav fa fa-chevron-left fa-3x"></span>
      </button>
      <button class="orbit-next">
        <span class="show-for-sr">Next Slide</span>
        <span class="nav fa fa-chevron-right fa-3x"></span>
      </button>
      <div class="bottom-content-section" data-magellan data-threshold="0">


      <li class="is-active orbit-slide">
        <img class="orbit-image" src="http:/img/back_bass.jpg" alt="Space">
        <figcaption class="orbit-caption">
					<h1>Aquí inicia el músico pro</h1>

        </figcaption>
      </li>
      <li class="orbit-slide">
        <img class="orbit-image" src="https://i.imgur.com/JD4Caxa.jpg" alt="Space">
        <figcaption class="orbit-caption">
					<h1>Encuenta salas de ensayo cerca de ti</h1>
        </figcaption>
      </li>
      <li class="orbit-slide">
        <img class="orbit-image" src="https://i.imgur.com/rsTQbNV.jpg" alt="Space">
        <figcaption class="orbit-caption">
					<h1>toda tu banda conectada</h1>
        </figcaption>
      </li>
    </ul>
  </div>
</div>
</div>


<!-- Benefits -->

<div class="top-companies">
  <h2 class="marketing-site-features-headline">¿Para qué una sala de ensayo?</h2>
  <p class="top-companies-subheadline subheader">Hay miles de beneficios de ensayar en un espacio dedicado a la música:</p>
  <div class="row">
    <div class="row large-up-3 small-up-2">
    <div class="featured-image-block column">
        <img src="https://unsplash.it/600/440?image=899" />
        <p class="text-center companies-image-block-title">Tiempo de Calidad</p>
    </div>

    <div class="featured-image-block column">
        <img src="https://unsplash.it/600/440?image=693" />
        <p class="text-center companies-image-block-title">Equipo Profesional</p>
    </div>

    <div class="featured-image-block column">
        <img src="https://unsplash.it/600/440?image=452" />
        <p class="text-center companies-image-block-title">Comodidad</p>
    </div>

    <div class="featured-image-block column">
        <img src="https://unsplash.it/600/440?image=667" />
        <p class="text-center companies-image-block-title">Redes Sociales</p>
    </div>

    <div class="featured-image-block column">
        <img src="https://unsplash.it/600/440?image=249" />
        <p class="text-center companies-image-block-title">Calendarización de actividades</p>
    </div>

    <div class="featured-image-block column">
        <img src="https://unsplash.it/600/440?image=382" />
        <p class="text-center companies-image-block-title">Ser todo un Pro</p>
    </div>
  </div>
</div>
<div class="button-float"><a href="/registro" class="button expanded">Registrarme</a></div>
</div>

<!-- Features -->
<div class="marketing-site-features">
  <h2 class="marketing-site-features-headline">Novedades de nuestra WebApp</h2>
  <p class="marketing-site-features-subheadline subheader">Ensaya Pro es una app web desarrollada para el músico, por músicos.</p>
  <div class="row">
    <div class="small-12 medium-6 large-3 columns">
      <i class="fa fa-users" aria-hidden="true"></i>
      <h4 class="marketing-site-features-title">Perfiles</h4>
      <p class="marketing-site-features-desc">Crea tu perfil y el de tu banda para estar siempre conectado.</p>
    </div>
    <div class="small-12 medium-6 large-3 columns">
      <i class="fa fa-microphone" aria-hidden="true"></i>
      <h4 class="marketing-site-features-title">Salas de Ensayo Pro</h4>
      <p class="marketing-site-features-desc">Elige entre las cientos de opciones para que ensayes como Pro cerca de tu localización.</p>
    </div>
    <div class="small-12 medium-6 large-3 columns">
      <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
      <h4 class="marketing-site-features-title">Control de tus ensayos</h4>
      <p class="marketing-site-features-desc">Con nuestro calendario no vuelvas a olvidar tus ensayos.</p>
    </div>
		<div class="small-12 medium-6 large-3 columns">
      <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
      <h4 class="marketing-site-features-title">Pagos protegidos</h4>
      <p class="marketing-site-features-desc">Paga con tu tarjeta de Crédito o Débito Visa o MasterCard, no temas tus compras están protegidas.</p>
    </div>
  </div>
</div>


<!--
<div class="large-12 text-center">
	<p>Bienvenido al lugar donde te volveras un profesional en la música</p>
	<a href="/registro" class="button expanded">Registrarme</a> -->




@endsection
