<!DOCTYPE html>
<html lang="es">
<head>
<title>Reconocimiento</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="{{ asset('layouts_inicio/style/layout.css') }}" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- ################################################################################################ -->

<!-- Top Background Image Wrapper -->
<div class="bgded" style="background-image:url('images/demo/backgrounds/01.png');"> 
  <!-- ################################################################################################ -->
  <div class="wrapper row1">
    <header id="header" class="hoc clear">
      <div id="logo" class="fl_left"> 
        <!-- ################################################################################################ -->
        <h1><a href="index.html">Evolución</a></h1>
        <!-- ################################################################################################ -->
      </div>
      <nav id="mainav" class="fl_right"> 
        <!-- ################################################################################################ -->
        <ul class="clear">
          <li class="active"><a href="{{ url('/') }}">Home</a></li>
          <!--login-->
          @if (Route::has('login'))
           @auth
             <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            @else
             <li><a href="{{url('/reg') }}">Iniciar</a></li>
              @if (Route::has('register'))
               <li><a href="{{ route('register') }}">Registrar</a></li>
               @endif
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
 <div class="wrapper coloured">
  <section id="ctdetails" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <ul class="nospace clear">
      <li class="one_quarter first">
        <div class="block clear"><a href="#"><i class="fas fa-phone"></i></a> <span><strong>Give us a call:</strong> +00 (123) 456 7890</span></div>
      </li>
      <li class="one_quarter">
        <div class="block clear"><a href="#"><i class="fas fa-envelope"></i></a> <span><strong>Send us a mail:</strong> support@domain.com</span></div>
      </li>
      <li class="one_quarter">
        <div class="block clear"><a href="#"><i class="fas fa-clock"></i></a> <span><strong> Monday - Saturday:</strong> 08.00am - 18.00pm</span></div>
      </li>
      <li class="one_quarter">
        <div class="block clear"><a href="#"><i class="fas fa-map-marker-alt"></i></a> <span><strong>Come visit us:</strong> Directions to <a href="#">our location</a></span></div>
      </li>
    </ul>
    <!-- ################################################################################################ -->
  </section>
</div>

<!-- ################################################################################################ -->
<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <p class="fl_left">Copyright &copy; 2018 - All Rights Reserved - <a href="#">Domain Name</a></p>
    <p class="fl_right">Template by <a target="_blank" href="https://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
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