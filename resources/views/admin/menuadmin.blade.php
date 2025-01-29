<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('inicio')}}" class="nav-link @if(Request::is('inicio')) active @endif">
              <i class="nav-icon fas fa-th"></i>
              <i class="nav-icon fas fa-th"></i><ion-icon name="home-outline"></ion-icon>
              <p>
                Inicio
              </p>
            </a>
          </li>    
          
         <!--se modifico esta parte -->
          <li class="nav-item">
            <a href="{{route('perfil')}}" class="nav-link @if(Request::is('perfil')) active @endif">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Perfil 
              </p>
            </a>
          </li> 
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
               <a href="{{route('metricasEnvio')}}" class="nav-link @if(Request::is('reconocimientos/enviados/admin')) active @endif">
                 &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                 &nbsp;<p>Rec. Enviados</p>
               </a>
             </li>  
            </ul>
          </li>
          <!-- ========================================================-->
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
            <a  href="{{route('insignia')}}" class="nav-link @if(Request::is('registro/insignias')) active @endif">
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
          <li class="nav-item">
            <a href="{{route('habilitar_votacion')}}" class="nav-link @if(Request::is('admin/votacion')) active @endif">
            <i class="nav-icon fas fa-vote-yea"></i>
              <p>
               Control de votaciones
              </p>
            </a>
          </li>
          <!--- comunicaciones --->
          <li class="nav-item">
            <a href="{{route('comunicacion.index')}}" class="@if(Request::is('comunicacion')) active @endif nav-link">
            <i class="nav-icon fas fa-comments"></i>
              <p>
               Comunicación
              </p>
            </a>
          </li>
          <!--end comunicaciones-->
          <li class="nav-item">
            <a href="{{route('areas')}}" class="nav-link @if(Request::is('areas/empresa')) active @endif">
            &nbsp;<i class="fas fa-industry"></i>
              <p>
                &nbsp;&nbsp;Empresa
              </p>
            </a>
          </li>
          <!---mdoludo de eventos--->
          <li class="nav-item">
            <a href="{{route('eventos')}}" class="nav-link @if(Request::is('empresa/eventos')) active @endif">
            &nbsp;<i class="fas fa-calendar-alt"></i>
              <p>
                &nbsp;&nbsp;Eventos
              </p>
            </a>
          </li>
          <!---end eventos--->
        </ul>
      </nav>