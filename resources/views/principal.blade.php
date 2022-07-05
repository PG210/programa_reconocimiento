<!DOCTYPE html>
<html lang="es">
<head>
<title>Reconocimiento</title>
<link rel="icon" href="{{asset('dist/img/favicon.png')}}">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="{{ asset('layouts_inicio/style/layout.css') }}" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- ################################################################################################ -->

<!-- Top Background Image Wrapper -->
<div class="bgded" style="background-image:url('dist/img/fondo2.png');"> 
  <!-- ################################################################################################ -->
  <div class="wrapper row1" style="background-color:#1ED5F4; color:black;">
    <header id="header" class="hoc clear">
      <div id="logo" class="fl_left"> 
        <!-- ################################################################################################ -->
        <h1><a href="index.html">Evolución</a></h1>
        <!-- ################################################################################################ -->
      </div>
      <nav id="mainav" class="fl_right"> 
        <!-- ################################################################################################ -->
        <ul class="clear" >
          <li class="active"><a href="{{ url('/') }}" style="color:black;"><b>Home</b></a></li>
          <li><a class="drop" href="#" style="color:black;"><b>Información</b></a>
            <ul>
              <li><a href="{{url('/pro')}}" style="color:white;">Programa de Reconocimiento</a></li>
              <li><a href="{{url('/reconocimientos')}}" style="color:white;">Reconocimientos</a></li>
              <li><a href="{{url('/contacto')}}" style="color:white;">contactos</a></li>
            </ul>
          </li>
          <!--login-->
          @if (Route::has('login'))
           @auth
             <li><a href="{{ url('/dashboard') }}"><b>Volver</b></a></li>
            @else
             <li><a href="{{url('/reg') }}"><b>Iniciar</b></a></li>
           @endauth
          @endif
        </ul>
        <!-- ################################################################################################ -->
      </nav>
    </header>
  </div>
  <!-- ################################################################################################ -->
 <!--colocar contenido-->
   @yield('content')
 <!--Finalizar contendio-->
 <footer>
 <div class="wrapper coloured"  style="background-color:white; color:black;">
 <section id="ctdetails" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <ul class="nospace clear">
      <li class="one_quarter first">
      <div class="block clear"><h3>Contáctanos</h3></div>
        <div class="block clear"><i class="fas fa-map-marker-alt"></i><span>Centro comercial La Fontana Oficina 146</span></div><br>
        <div class="block clear" style="color:black;"><i class="fas fa-phone"></i><span> (57) 312-2894289</span></div><br>
        <div class="block clear" style="color:black;"><i class="fas fa-envelope"></i><span>info@envolucion.co</span></div>
      </li>
      <li class="one_quarter">
        <div class="block clear"><h3>Nuestros Servicios</h3></div>
        <div class="block clear"><a href="#"></a> <span>Didaktica</span></div>
        <div class="block clear"><a href="#"></a> <span>Gamificación</span></div>
        <div class="block clear"><a href="#"></a> <span>Play Box</span></div>
      </li>
      <li class="one_quarter">
        <div class="block clear"><a href="#"><i class="fas fa-clock"></i></a> <h3>Sobre Nosotros</h3></div>
        <div class="block clear"><a href="#"></a> <span>Clientes</span></div>
        <div class="block clear"><a href="#"></a> <span>Contactos</span></div>
       
      </li>
      <li class="one_quarter">
        <br>
        <div class="block clear"><a href="#"><i class="fas fa-map-marker-alt"></i></a> <img src="dist/img/evolucion_fondo.png" alt=""></a></div>
      </li>
    </ul>

    <!--############################################################################--->
    <!--
    <ul class="nospace clear">
      <li class="one_quarter first">
        <div class="block clear"  style=" color:black; "><b>Contáctanos</b></div>
      </li>
      <li class="one_quarter">
        <div class="block clear"  style="color:black;"><b>Nuestros Servicios</b></div>
      </li>
      <li class="one_quarter">
        <div class="block clear"><b>Sobre Nosotros</b></div>
      </li>
      <li class="one_quarter first">
        <i class="fas fa-map-marker-alt"></i><span>&nbsp&nbspCentro comercial La Fontana Oficina 146</span>
        <ul class="nospace clear">
          <i class="fas fa-phone"></i><span>&nbsp&nbsp (2) 403 0559</span>
        </ul>
        <ul class="nospace clear">
          <i class="fas fa-mobile"></i><span>&nbsp&nbsp (57) 312-2894289</span>
        </ul>
        <ul class="nospace clear">
        <i class="fas fa-envelope"></i><span>&nbsp&nbspinfo@envolucion.co</span>
        </ul>
      </li>
     
        <li class="one_quarter" style="margin-left: 30px;">
         
          <span>&nbsp&nbspFormacción</span>
        <ul class="nospace clear">
          <span>&nbsp&nbspDidaktica</span>
        </ul>
        <ul class="nospace clear">
          <span>&nbsp&nbspGamificación</span>
        </ul>
        <ul class="nospace clear">
          <span>&nbsp&nbspPlay Box</span>
        </ul>
      </li>
      </li>
      <li class="one_quarter">
     
          <br>
          <span>&nbsp&nbspAcerca</span>
        <ul class="nospace clear">
          <span>&nbsp&nbspClientes</span>
        </ul>
        <ul class="nospace clear">
          <span>&nbsp&nbspContáctos</span>
        </ul>
      </li>
        <li class="one_quarter">
          <div class="block clear" >
          <figure><a  href="#"><img src="dist/img/evolucion_fondo.png" alt=""></a>
          </figure>
          </div>
        </li>
      </ul>-->
    <!-- ################################################################################################ -->
  </section>
</div>

<!-- ################################################################################################ -->
<div class="wrapper row5"  style="background-color:#1ED5F4; color:black;">
  <div id="copyright" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <p class="fl_left">Copyright &copy; 2022 - Todos los derechos reservados - <a href="https://www.evolucion.co/" style="background-color:#1ED5F4; color:black;">Evolucion.co</a></p>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<a id="backtotop" href="#top"><i class="fas fa-chevron-up"></i></a>
</footer>
<!-- JAVASCRIPTS -->
<script  src="{{ asset('layouts_inicio/js/jquery.min.js') }}"></script>
<script  src="{{ asset('layouts_inicio/js/jquery.backtotop.js') }}"></script>
<script  src="{{ asset('layouts_inicio/js/jquery.mobilemenu.js') }}"></script>
</body>
</html>