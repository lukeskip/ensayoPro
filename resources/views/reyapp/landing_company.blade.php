@extends('layouts.reyapp.main')
@section('body_class', 'landing')
@section('header')

<link rel="stylesheet" href="{{asset('css/landing_company.css')}}">

@endsection

@section('content')
<div class="hero-full-screen">
  <div class="middle-content-section">
    <h1>Es momento de que tu sala de ensayo te haga crecer.</h1>
      <div class="bottom-content-section" data-magellan data-threshold="0">
        <a href="#main-content-section"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 12c0-6.627-5.373-12-12-12s-12 5.373-12 12 5.373 12 12 12 12-5.373 12-12zm-18.005-1.568l1.415-1.414 4.59 4.574 4.579-4.574 1.416 1.414-5.995 5.988-6.005-5.988z"/></svg></a>
      </div>
  </div>
</div>

<div id="main-content-section" data-magellan-target="main-content-section">

 <!--STARTS: Benefits -->

  <div class="top-company_landing">
    <section class="four-up-feature">
    <div class="row align-spaced">
    <div class="small-12 medium-6 columns">
      <img class="four-up-feature-image" src="{{asset('img/company_3.png')}}" alt="icon">
      <h4>Ingresos seguros</h4>
      <p class="four-up-feature-text">Mediante el cobro de los ensayos vía oxxo, las reservaciones ahora serán más seguras.</p>
    </div>
    <div class="small-12 medium-6 columns">
      <img class="four-up-feature-image" src="{{asset('img/company_2.png')}}" alt="icon">
      <h4>Conoce a tu competencia</h4>
      <p class="four-up-feature-text">Al tener el listados de las salas de ensayo podrás conocer lo que tu competencia hace e ir un paso adelante.</p>
    </div>
    <div class="small-12 medium-6 columns">
      <img class="four-up-feature-image" src="{{asset('img/company_1.png')}}" alt="icon">
      <h4>Más clientes para un mayor crecimiento</h4>
      <p class="four-up-feature-text">Tus salas estarán disponibles para miles de músicos, deja que ellos agenden y aumenta tus ingresos.</p>
    </div>
    <div class="small-12 medium-6 columns">
      <img class="four-up-feature-image" src="{{asset('img/company_4.png')}}" alt="icon">
      <h4>Lo mejor de todo: es gratis</h4>
      <p class="four-up-feature-text">Sólo pagarás la comisión para que Ensayo Pro siga de pie, el resto de la plataforma no cuesta NA-DA</p>
    </div>
        <div>
      <a class="button green large" style="margin-bottom: 90px;" href="/registro">REGÍSTRATE AHORA</a>
    </div>
    </div>
    </section>
  </div>

{{-- ENDS: Benefits --}}
</div>

@endsection

@section('scripts')

@endsection
