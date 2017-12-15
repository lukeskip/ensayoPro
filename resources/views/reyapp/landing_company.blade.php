@extends('layouts.reyapp.main')
@section('body_class', 'landing')
@section('header')

<link rel="stylesheet" href="{{asset('plugins/owlcarrousel/assets/owl.carousel.css')}}">
<link rel="stylesheet" href="{{asset('plugins/videoback/src/youtubebackground.css')}}">
<link rel="stylesheet" href="{{asset('css/landing_company.css')}}">

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
        <h2>Ensaya con el amplo que siempre has querido</h2>
        <p class="show-for-medium">Encuéntralo en nuestra lista de las mejores salas de ensayo. </p>
      </div>
      
    </div>
    <div class="item">
      <div class="wrapper">
        <br><br><br>
        <h2>Encuentra un espacio chingón para ensayar</h2>
        <p class="show-for-medium">Califica y checa la opinión de otras bandas, además reserva aquí mismo tu ensayo en cualquier momento</p>
      </div>
    </div>
    
   
</div>
  <a class="button green large" href="/registro">REGÍSTRATE AHORA</a>
</div>


<!--STARTS: Benefits -->

<div class="top-company_landing">
  <h1>Es momento de que tu sala de ensayo te haga crecer.</h1>
  <p class="text-center landing-subtitle">En Ensayo pro buscamos compañías que quieren crecer y llevar su negocio más allá de su colonia, de su delegación, de su ciudad...</p>
  <div class="row a">
      <div class="columns medium-3 text-center">
        <img src="{{asset('img/company_1.png')}}" with='100%'/>
        <h2 class="text-center bullets-company">Obten más ingresos</h2>
        <p class="text-center description-salas">Ensayo Pro te permitirá tener una mayor visualización por parte de Músicos que están en búsqueda de Salas de Ensayo. En promedio más de 500 busquedas se hacen mensualmente en google... ¿Cómo lo sabemos? todas llegan orgánicamente a reydecibel.com.mx</p>
      </div>

      <div class="columns medium-3 text-center">
        <img src="{{asset('img/company_2.png')}}" with='100%'/>
        <h2 class="text-center bullets-company">Conoce a tu competencia</h2>
        <p class="text-center description-salas">Saber en donde te encuentras parado te dará mayores beneficios sin gastar un centavo en estudios de mercado o mistery shopers, desde ahora saber lo qué tu competencia ofrece y lo que los músicos búscan te llevará un paso adelante</p>
        
      </div>
      <div class="columns medium-3 text-center">
        <img src="{{asset('img/company_3.png')}}" with='100%'/>
        <h2 class="text-center bullets-company">Para cobrar están los bancos, tú estás para crecer.</h2>
        <p class="text-center description-salas">Las reservaciones se concretarán en cuanto el músico haya hecho el pago correspondiente a las horas seleccionadas</p>
        
      </div>

      <div class="columns medium-3 text-center">
        <img src="{{asset('img/company_4.png')}}" with='100%'/>
        <h2 class="text-center bullets-company">Consulta tu dashboard desde celular, tablet o pc.</h2>
        <p class="text-center description-salas">Desde cualquier dispositivo lleva el control de tus Salas de Ensayo, ingresa y forma parte de Ensayo Pro.</p>
      </div>
  </div>
</div>
</div>
  <a class="button green large" href="/registro">REGÍSTRATE AHORA</a>
</div>

{{-- ENDS: Benefits --}}

<!--STARTS: Feature -->
<div class="feature">
  <h2>Aquí encuentras la mejor sala para ensayar.</h2>
  <p  class="landing-subtitle text-center">Sabemos la importancia de los ensayos, por ello hemos puesto atención en los detalles</p>
  <div class="row b">
    <div class="feature-item small-12 medium-4 columns">
      <div class="icon"><i class="fa fa-star fa-2x" aria-hidden="true"></i></div>
      <h3 class="feature-title text-center">Ranking para mejorar</h3>
      <p class="marketing-site-features-desc">Con esto podremos contar con mejores servicios.</p>
    </div>
    <div class="feature-item small-12 medium-4 columns">
      <div class="icon"><i class="fa fa-comments-o fa-2x" aria-hidden="true"></i></div>
      <h3 class="feature-title text-center">Comentarios para todos</h3>
      <p class="marketing-site-features-desc">¿Las estrellas no lo es todo? Deja tu comentario sobre la Sala Pro que reservaste.</p>
    </div>
    <div class="feature-item small-12 medium-4 columns">
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
