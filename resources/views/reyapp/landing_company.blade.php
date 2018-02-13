@extends('layouts.reyapp.main')
@section('body_class', 'landing')
@section('header')

<link rel="stylesheet" href="{{asset('css/landing_company.css')}}">

@endsection

@section('metatags')

<meta name="description" content="Inscríbe a tu sala de ensayo en nuestro ranking y genera más reservaciones gratis"/>
<link rel="canonical" href="https://ensayopro.com.mx/unete" />
<meta property="og:locale" content="es_ES" />
<meta property="og:type" content="article" />
<meta property="og:title" content="Incribe a tu sala de ensayo en EnsayoPro" />
<meta property="og:description" content="Inscribe a tu sala de ensayo en nuestro ranking y genera más reservaciones gratis" />
<meta property="og:url" content="https://ensayopro.com.mx/unete" />
<meta property="og:site_name" content="EnsayoPro" />
<meta property="article:section" content="Incríbe a tus sala de ensayo" />
<meta property="article:published_time" content="2017-02-01T23:01:04-06:00" />
<meta property="article:modified_time" content="2018-02-01T11:48:36-06:00" />
<meta property="og:updated_time" content="2018-02-01T11:48:36-06:00" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="Si tienes una sala de ensayo inscríbela en nuestro ranking y genera más reservaciones, es gratis" />
<meta name="twitter:title" content="Obtén más reservaciones para tu Sala de Ensayo" />

@endsection

@section('content')
<div class="hero-full-screen">
  <div class="middle-content-section">
    <img src="{{asset('img/logo_ensayo.png')}}">
    <h1>Es momento de que tu sala de ensayo crezca.</h1>
    <a class="button green large" style="margin-bottom: 90px;" href="/registro/usuario/company">REGÍSTRATE AHORA</a>
      <div class="bottom-content-section" data-magellan data-threshold="0">
        <a href="#main-content-section"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 12c0-6.627-5.373-12-12-12s-12 5.373-12 12 5.373 12 12 12 12-5.373 12-12zm-18.005-1.568l1.415-1.414 4.59 4.574 4.579-4.574 1.416 1.414-5.995 5.988-6.005-5.988z"/></svg></a>
      </div>
  </div>
</div>

<div id="main-content-section" data-magellan-target="main-content-section">

 <!--STARTS: Benefits -->

  <div class="top-company_landing">
    <section class="four-up-feature">
    <div class="medium-6 medium-centered columns">
      <h2>¿Qué es EnsayoPro?</h2>
      <p>Es una plataforma en la que músicos pueden comparar el servicio y precios de diferentes Salas de Ensayo y reservar en línea de forma automática con cargo a su tarjeta de crédito, débito o pagando en Oxxo. Utiliza un modelo muy parecido a AirB&B o Trivago.</p>
      <br><br>

    </div>
    <div class="row align-spaced">
    <div class="small-12 medium-6 columns">
      <img class="four-up-feature-image" src="{{asset('img/company_3.png')}}" alt="icon">
      <h4>Ingresos seguros</h4>
      <p class="four-up-feature-text">Mediante el prepago de los ensayos vía oxxo, las reservaciones ahora serán más seguras.</p>
    </div>
    <div class="small-12 medium-6 columns">
      <img class="four-up-feature-image" src="{{asset('img/company_2.png')}}" alt="icon">
      <h4>Conoce a tu competencia</h4>
      <p class="four-up-feature-text">Al tener el listados de las salas de ensayo podrás conocer a tu competencia y mejorar tu servicio y tu oferta.</p>
    </div>
    <div class="small-12 medium-6 columns">
      <img class="four-up-feature-image" src="{{asset('img/company_1.png')}}" alt="icon">
      <h4>Más clientes para un mayor crecimiento</h4>
      <p class="four-up-feature-text">Tus salas estarán disponibles para miles de músicos, deja que ellos agenden y aumenta tus ingresos.</p>
    </div>
    <div class="small-12 medium-6 columns">
      <img class="four-up-feature-image" src="{{asset('img/company_4.png')}}" alt="icon">
      <h4>Lo mejor de todo: es gratis</h4>
      <p class="four-up-feature-text">Sólo pagarás comisión por aquellas reservaciones que EnsayoPro consiga para ti, el resto de la plataforma no cuesta NA-DA.</p>
    </div>
    
    <div class="small-12 columns">
      <br><br>
      <a class="button green large" style="margin-bottom: 90px;" href="/registro/usuario/company">REGÍSTRATE AHORA</a>
      <br><br><br>
    </div>

    </div>
    </section>
  </div>

{{-- ENDS: Benefits --}}
</div>

@endsection

@section('scripts')

@endsection
