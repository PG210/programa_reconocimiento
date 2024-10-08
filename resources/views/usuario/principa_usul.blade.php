<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Evolución</title>
  <link rel="icon" href="{{asset('dist/img/favicon.png')}}">
  @include('usuario.stylecss')
  @include('usuario.letras')
  <style>
        .info-contenedor {
            border: 2px solid #032F5B; /* Cambia el color del borde según tu preferencia */
            box-shadow: 2px 2px 5px 1px rgba(213, 214, 215, 0.4); /* Sombra */
            border-radius: 7px; /* Opcional: Bordes redondeados */
            padding: 0px; /* Opcional: Espaciado interior */
            margin: 0px; /* Opcional: Espaciado exterior */
        }
  </style>
  <?php
    use App\Models\RecibeCatMoldel\RecibirCat;
    use App\Models\Reconocimientos\ReconocimientosModal;

    $idusu = Auth::user()->id;
    $totreconocimiento = RecibirCat::where('id_user_recibe', '=', $idusu)->count(); //total de reconocimientos
    
    $totrecom = ReconocimientosModal::where('id_usuario', '=', $idusu)->count(); // insignias obtenidas

    $valor = RecibirCat::where('id_user_recibe', '=', $idusu)->selectRaw('SUM(puntos) as p')->get();

    if(empty($valor[0]->p)){
      $totpuntos = 0;
    }else{
      $totpuntos = $valor[0]->p;
    }

  ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Preloader -->
  <!--<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('dist/img/logo_evo.png')}}" alt="cargando ..." height="60" width="60">
  </div>-->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color:#FFFFFF;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color:black;"></i></a>
      </li>
     @if(Auth::user()->id_rol==1) <!--Logeado como administrador-->
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link letra1" style="color:black;"><b>Administrador</b></a>
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
          <i class="fas fa-expand-arrows-alt" style="color:black;"></i>
        </a>
      </li>
      <!--cerrar sesion-->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-user-circle fa-lg" style="color:black;"></i>
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
  
    <a href="#" class="brand-link">
      <img src="{{ asset('dist/img/logo_evo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light"><h3 style="color:white; font-weight: bold;">Evolución</h3></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 d-flex">
        <div class="image">
          @if(Auth::user()->imagen)
          <img src="{{asset('dist/imgperfil/'.Auth::user()->imagen)}}" class="img-circle elevation-2" alt="User Image" alt="....">
          @endif
        </div>
        <div class="info">
          <a href="/perfil" class="d-block" style="color:#FFFFFF;">{{Auth::user()->name}} {{ Auth::user()->apellido }}</a>
        </div>
      </div>
      <!-- SidebarSearch Form -->
      @if(Auth::user()->id_rol!=1)
      <div class="info-contenedor mb-3">
        <div class="row mt-1">
          <div class="col-lg-4 col-md-4 col-xs-4 col-4 text-center">
          <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Reconocimientos recibidos">
            <i class="fas fa-award" style="color:#ffbd03; font-size:24px;"></i><br>
              <span class="badge badge-info text-left" style="color:black; font-size: 0.875em;"> 
                {{$totreconocimiento}}
              </span>   
           </button>                             
          </div>
          <div class="col-lg-4 col-md-4 col-xs-4 col-4 text-center">
          <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Recompensas">
             <i class="fas fa-trophy" style="color:#ffbd03; font-size:24px;"></i><br>
                <span class="badge badge-info text-left" style="color:black; font-size: 0.875em;"> 
                  {{$totrecom}}
                </span>  
            </button>    
          </div>
          <div class="col-lg-4 col-md-4 col-xs-4 col-4 text-center">
           <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Puntos">
             <i class="fas fa-star" style="color:#ffbd03; font-size:24px;"></i><br>
               <span class="badge badge-info text-left" style="color:black; font-size: 0.875em;"> 
                {{$totpuntos}}
               </span>  
              </button>    
          </div>
        </div>
      </div>
      @endif
      
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
