<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Evolución</title>
  <link rel="icon" href="{{asset('dist/img/favicon.png')}}">
  @include('usuario.stylecss')
  @include('usuario.letras')
  <style>
    .info-contenedor {
      border: 2px solid #032F5B;
      /* Cambia el color del borde según tu preferencia */
      box-shadow: 2px 2px 5px 1px rgba(213, 214, 215, 0.4);
      /* Sombra */
      border-radius: 7px;
      /* Opcional: Bordes redondeados */
      padding: 0px;
      /* Opcional: Espaciado interior */
      margin: 0px;
      /* Opcional: Espaciado exterior */
    }
  </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{ asset('dist/img/logo-reconoser-icono.png')}}"
        alt="Logo Reconoser cargando..." height="59" width="85">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        @if(Auth::user()->id_rol != 1 && Auth::user()->id_rol != 4)
        <li class="nav-item d-none d-sm-inline-block">
          <button onclick="window.location.href='{{ route('listareconocer') }}'" class="btn btn-warning font-weight-bold">¡Reconoce ahora!</button>
        </li>
        @endif
        @if(Auth::user()->id_rol == 1) <!--Logeado como administrador-->
          <li class="nav-item d-none d-sm-inline-block">
            <a href="/inicio" class="nav-link letra1" style="color:black;"><b>Administrador</b></a>
          </li>
        @endif
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <!-- Messages Dropdown Menu -->
        <!--  <li class="nav-item dropdown">
      </li>-->
        <!-- Notifications Dropdown Menu -->
        @include('usuario.notifi')
        <!---end notificaciones-->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <!--cerrar sesion-->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="nav-icon far fa-user"></i>
            <!--pantallas pequeñas <span class="d-none d-lg-block"> -->
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!---item--2-->
            <div class="dropdown-item dropdown-header">
              <span>{{ Auth::user()->name }} {{ Auth::user()->apellido }}</span>
            </div>
            <!--<div class="dropdown-divider"></div>-->
            <!---end item--2-->
            <div class="dropdown-item">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <div class="dropdown-divider"></div>
                <a href="route('logout')" class="dropdown-item"
                  onclick="event.preventDefault(); this.closest('form').submit();">
                  <i class="fas fa-sign-out-alt fa-lg"></i> Cerrar sesión
                </a>
              </form>
            </div>
          </div>
        </li>

        <!----->
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link p-1">
        <img src="{{ asset('dist/img/logo-reconoser-2.png')}}" alt="Reconoser Logo" class="text-center">
        <!--<span class="brand-text font-weight-light"><h3 style="color:white; font-weight: bold;">Reconoser</h3></span>-->
      </a>
      <!-- Sidebar -->
      <div
        class="sidebar os-host os-theme-light os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition os-host-overflow os-host-overflow-y">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-2 pb-2 d-flex">
          <div class="image">
            @if(Auth::user()->imagen)
              <img src="{{asset('dist/imgperfil/' . Auth::user()->imagen)}}" class="img-circle" style="width: 3rem; height: 3rem;" alt="User Image"
                alt="Cargando imagen ....">
            @endif
          </div>
          <div class="info">
            <a href="/perfil" class="d-block" style="color:#FFFFFF;">{{Auth::user()->name}}
              {{ Auth::user()->apellido }}</a>
          </div>
        </div>
        <!-- SidebarSearch Form -->
        <div class="letra2">
          @if(Auth::user()->id_rol == 1) <!--Logeado como administrador-->
            @include('admin.menuadmin')
          @endif
              @if(Auth::user()->id_rol == 2) <!--Logeado como usuario-->
            @include('user.menusuario')
          @endif
              @if(Auth::user()->id_rol == 3) <!--Logeado como jefe-->
            @include('jefe.menujefe')
          @endif
              @if(Auth::user()->id_rol == 4) <!--Logeado como jefe-->
            @include('gerente.menugerente')
          @endif
        </div>
        <!-- Sidebar Menu -->
        <!-- /.sidebar-menu -->
      </div>
      <div class="sidebar-custom">
        <button href="#" class="btn btn-link"><i class="fas fa-cogs"></i></button>
        <button onclick="window.location.href='mailto:info@envolucion.co?subject=Soporte&body=Hola, necesito ayuda con...'" class="btn btn-warning hide-on-collapse pos-right">
          Ayuda
      </button>
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
    </div>

    <!-- /.content-wrapper -->
    <footer class="main-footer letra1 text-left" style="background-color:#FFFFFF; color:black;">
      <strong>Copyright &copy; 2024 <a href="https://evolucion.co/" target="_blank">Evolución</a>.</strong>
      <span><b>Todos los derechos reservados</b></span>
      <div class="float-right d-none d-sm-inline-block">
        <span style="color:black;"><b>Version</b> 2.0.0</span>
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