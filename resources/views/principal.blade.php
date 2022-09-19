<!DOCTYPE html>
<html lang="es">
<head>
<title>Reconocimiento</title>
<link rel="icon" href="{{asset('dist/img/favicon.png')}}">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="{{ asset('layouts_inicio/style/layout.css') }}" rel="stylesheet" type="text/css" media="all">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@200;500;700&display=swap" rel="stylesheet">
</head>
<style>
  .letra1{
       font-family: 'Roboto Slab', serif;
       font-size:18px;
       line-height: 1.3;
       font-weight: 200;
       text-align:center; 
  }
  .letra2{
       font-family: 'Roboto Slab', serif;
       font-size:18px;
       line-height: 1.3;
       font-weight: 200;
       text-align:left;
  }
  .letra_peq{
       font-family: 'Roboto Slab', serif;
       font-size:16px;
       line-height: 1.3;
       font-weight: 200;
       text-align:left; 
  }
</style>
<body id="top">
<!-- ################################################################################################ -->

<!-- Top Background Image Wrapper -->
<div class="bgded" style="background-image:url('dist/img/fondo2.png');"> 
  <!-- ################################################################################################ -->
  <div class="wrapper row1" style="background-color:white; color:black;">
    <header id="header" class="hoc clear">
      <div id="logo" class="fl_left"> 
        <!-- ################################################################################################ -->
        <div class="block clear"><img src="dist/img/evolucion_fondo_2.jpg" alt="cargando imagen ,,,"></div>
        <!-- ################################################################################################ -->
      </div>
      <nav id="mainav" class="fl_right"> 
        <!-- ################################################################################################ -->
        <ul class="clear" >
          <li class="active letra1"><a href="{{ url('/') }}" style="color:black;"><b>Principal</b></a></li>
          <!--<li><a class="drop" href="#" style="color:black;"><b>Información</b></a>
            <ul>
              <li><a href="{{url('/pro')}}" style="color:white;">Programa de Reconocimiento</a></li>
              <li><a href="{{url('/reconocimientos')}}" style="color:white;">Reconocimientos</a></li>
              <li><a href="{{url('/contacto')}}" style="color:white;">contactos</a></li>
            </ul>
          </li>-->
          <!--login-->
          @if (Route::has('login'))
           @auth
             <li><a class="letra1" href="{{ url('/dashboard') }}"><b>Volver</b></a></li>
            @else
             <li><a class="letra1" href="{{url('/reg') }}"><b>Iniciar</b></a></li>
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
      <div class="block clear letra2"><h3>Contáctanos</h3></div>
        <div class="block clear letra_peq"><i class="fas fa-map-marker-alt"></i><h5>Centro comercial La Fontana Oficina 146</h5></div><br>
        <div class="block clear letra_peq" style="color:black;"><i class="fas fa-phone"></i><h5>(57) 312-2894289</h5></div><br>
        <div class="block clear letra_peq" style="color:black;"><i class="fas fa-envelope"></i><a href="mailto:info@envolucion.co"><h5>info@envolucion.co</h5></a></div>
      </li>
      <li class="one_quarter">
        <div class="block clear letra2"><h3>Nuestros Servicios</h3></div>
        <div class="block clear letra_peq"><a href="https://www.evolucion.co/didaktica/" target="_blank"><h5>Didaktica</h5></a></div>
        <div class="block clear letra_peq"><a href="https://www.evolucion.co/gamificacion/" target="_blank"><h5>Gamificación</h5></a></div>
        <div class="block clear letra_peq"><a href="https://www.evolucion.co/play-box/" target="_blank"><h5>Play Box</h5></a></div>
        <div class="block clear letra_peq"><a href="https://www.evolucion.co/formaccion/" target="_blank"><h5>FormAcción</h5></a></div>
      </li>
      <li class="one_quarter">
        <div class="block clear letra2"><a href="#"></a><h3>Sobre Nosotros</h3></div>
        <div class="block clear letra_peq"><a href="https://www.evolucion.co/clientes/" target="_blank"><h5>Clientes</h5></a></div>
        <div class="block clear letra_peq"><a href="https://www.evolucion.co/contactanos/" target="_blank"> <h5>Contactos</h5></a></div>
       
      </li>
      <li class="one_quarter">
        <br>
        <div class="block clear"><a href="https://www.evolucion.co/" target="_blank"><img src="dist/img/evolucion_fondo.png" alt=""></a></div>
      </li>
    </ul>

    <!--############################################################################--->
    <!-- ################################################################################################ -->
  </section>
</div>

<!-- ################################################################################################ -->
<div class="wrapper row5"  style="background-color:#15AFBA; color:black;">
  <div id="copyright" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <p class="fl_left letra1"><b>Copyright &copy; 2022 - Todos los derechos reservados -</b> <a href="https://www.evolucion.co/" style="background-color:#15AFBA; color:black;"><b>Evolucion.co</b></a></p>
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