<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
    <li class="nav-item">
      <a href="{{route('inicio')}}" class="nav-link @if(Request::is('inicio')) active @endif">
        <i class="nav-icon fas fa-home"></i>
        <p>
          Inicio
        </p>
      </a>
    </li> 
    <li class="nav-header">Gestión de la empresa</li>

    <li class="nav-item">
      <a href="{{route('areas')}}" class="nav-link @if(Request::is('areas/empresa')) active @endif">
       <i class="nav-icon fas fa-industry"></i>
        <p>
          Empresa
        </p>
      </a>
    </li>

    <!--gestion de usuarios-->
    <li class="nav-item">
      <a href="#" class="nav-link ">
        <i class="nav-icon fas fa-users"></i>
        <p>
          Usuarios
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('reporteusuarios')}}" class="nav-link @if(Request::is('reporte/usuarios')) active @endif">
            &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
            &nbsp;<p>Registro</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('vistaGrupos')}}" class="nav-link @if(Request::is('users/grupos')) active @endif">
            &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
            &nbsp;<p>Grupos</p>
          </a>
        </li>
      </ul>
    </li>
    <!--end gestion de usuarios -->

    <li class="nav-header">Configuración <br>de Reconocimientos</li>
    
    <li class="nav-item">
      <a href="{{route('reg_categ')}}" class="nav-link @if(Request::is('Categorias/registro')) active @endif">
        <i class="nav-icon fas fa-sitemap"></i>
        <p>
          Categorias
        </p>
      </a>
    </li>
    <!--end modificar--->
    <li class="nav-item">
      <a href="{{route('insignia')}}" class="nav-link @if(Request::is('registro/insignias')) active @endif">
        <i class="nav-icon fas fa-medal"></i>
        <p>
          Insignias
        </p>
      </a>
    </li>
    <!--se modifico-->
    <li class="nav-item">
      <a href="{{route('premios_vis')}}" class="nav-link @if(Request::is('premios/reg')) active @endif">
        <i class="nav-icon fas fa-trophy"></i>
        <p>
          Recompensas
        </p>
      </a>
    </li>

    <li class="nav-header">Gestión de Participación</li>
    
    <li class="nav-item">
      <a href="{{route('habilitar_votacion')}}" class="nav-link @if(Request::is('admin/votacion')) active @endif">
        <i class="nav-icon fas fa-vote-yea"></i>
        <p>
          Control de votaciones
        </p>
      </a>
    </li>

    <li class="nav-header">Gestión de Comunicación</li>
    <!--- comunicaciones --->
    <li class="nav-item">
      <a href="{{route('comunicacion.index')}}" class="nav-link @if(Request::is('comunicacion')) active @endif nav-link">
        <i class="nav-icon fas fa-comments"></i>
        <p>
          Comunicación
        </p>
      </a>
    </li>
    <!--end comunicaciones-->
    
    <!---mdoludo de eventos--->
    <li class="nav-item">
      <a href="{{route('eventos')}}" class="nav-link @if(Request::is('empresa/eventos')) active @endif">
        <i class="nav-icon fas fa-calendar-alt"></i>
        <p>
          Eventos
        </p>
      </a>
    </li>
    <!---end eventos--->

    <li class="nav-header">Metricas</li>

    <!--===================metricas ============================= -->
    <li class="nav-item">
      <a href="#" class="nav-link ">
        <i class="nav-icon fas fa-chart-line"></i>
        <p>
          Métricas
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{route('metricasranking')}}" class="nav-link @if(Request::is('metricas/ranking')) active @endif">
            &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
            &nbsp;<p>Rec. Obtenidos</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('metricasEnvio')}}"
            class="nav-link @if(Request::is('reconocimientos/enviados/admin')) active @endif">
            &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
            &nbsp;<p>Rec. Enviados</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('metricasPuntos')}}" class="nav-link @if(Request::is('metricas/puntos')) active @endif">
            &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
            &nbsp;<p>Puntos</p>
          </a>
        </li>
      </ul>
    </li>
    <!-- ========================================================-->
    
    
    <li class="nav-header">Configuración</li>
    <!--se modifico esta parte -->
    <li class="nav-item">
      <a href="{{route('perfil')}}" class="nav-link @if(Request::is('perfil')) active @endif">
        <i class="nav-icon fas fa-user-cog"></i>
        <p>
          Perfil
        </p>
      </a>
    </li>
  </ul>
</nav>