<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reconocimiento</title>
  <link rel="icon" href="{{asset('dist/img/favicon.png')}}">
  @include('usuario.stylecss')
  @include('usuario.letras')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('dist/img/logo_evo.png')}}" alt="cargando ..." height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color:#15AFBA;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color:white;"></i></a>
      </li>
     @if(Auth::user()->id_rol==1) <!--Logeado como administrador-->
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link letra1" style="color:white;"><b>Administrador</b></a>
      </li>
     @endif
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto" >
      <!-- Navbar Search -->
      <!-- Messages Dropdown Menu -->
    <!--  <li class="nav-item dropdown">
      </li>-->
      <!-- Notifications Dropdown Menu -->
      @include('usuario.notifi')
      <!---end notificaciones-->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt" style="color:white;"></i>
        </a>
      </li>
      <!--cerrar sesion-->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-user-circle fa-lg" style="color:white;"></i>
        <!--pantallas pequeñas <span class="d-none d-lg-block"> --> 
       </a>
        
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!---item--2-->
          <div class="row"> 
            <div class="col-12 letra1"> 
            <span>{{ Auth::user()->name }} {{ Auth::user()->apellido }}</span>
            </div>
          </div>
        <!---end item--2-->
        <div class="row"> 
          <div class="col-12"> 
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <div class="dropdown-divider"></div>
              <a href="route('logout')" class="dropdown-item"  onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt fa-lg"></i> Cerrar sesión
              </a>
            </form>
          </div>
        </div>  
        </div>
      </li>

      <!----->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-3" style="background-color:#082e41;">
    <!-- Brand Logo -->
    <a href="https://www.evolucion.co/" class="brand-link">
      <img src="{{ asset('dist/img/logo_evo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light"><h3 style="color:white; font-weight: bold;">Evolución</h3></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/imgperfil/'.Auth::user()->imagen)}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/perfil" class="d-block" style="color:#FFFFFF;">{{Auth::user()->name}} {{ Auth::user()->apellido }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
       <!-- <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>-->
      </div>
      <div class="letra2">
      @if(Auth::user()->id_rol==1) <!--Logeado como administrador-->
          @include('admin.menuadmin')
      @endif
      @if(Auth::user()->id_rol==2) <!--Logeado como usuario-->
           @include('user.menusuario')
      @endif
      @if(Auth::user()->id_rol==3) <!--Logeado como jefe-->
          @include('jefe.menujefe')
      @endif
      @if(Auth::user()->id_rol==4) <!--Logeado como jefe-->
          @include('gerente.menugerente')
      @endif
    </div>
      <!-- Sidebar Menu -->
      
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
     
    <!-- Main content -->
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  <footer class="main-footer letra1 text-left" style="background-color:#15AFBA; color:white;">
    <strong>Copyright &copy; 2022 <a href="https://www.evolucion.co/" style="color:white;">Evolución</a>.</strong>
    <b>Todos los derechos reservados</b>
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@include('usuario.stylejs')

</body>
</html>
