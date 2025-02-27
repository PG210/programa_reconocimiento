<?php
  use Illuminate\Support\Facades\DB; 

  $es = DB::table('estavotacion')->where('estado', '=', 1)->select('estado')->get();

?>
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
          <li class="nav-header">Reconocimientos</li>

          <li class="nav-item">
            <a href="{{route('listareconocer')}}" class="nav-link @if(Request::is('reconocimientos/usuario')) active ver @endif">
              <i class="nav-icon fa fa-paper-plane"></i>
              <p>
              Enviar reconocimiento
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('reporteinsignias')}}" class="nav-link @if(Request::is('reporte/insignias')) active @endif">
              <i class="nav-icon fas fa-trophy"></i>
              <p>
              Mis reconocimientos
              </p>
            </a>
          </li>

          <li class="nav-header">Votaciones</li>

          @if(isset($es[0]->estado))
          @if($es[0]->estado==1)
          <li class="nav-item">
            <a href="{{route('votacion_user')}}" class="nav-link @if(Request::is('vista/votacion')) active @endif">
            <i class="nav-icon fas fa-vote-yea"></i>
              <p>
              Participar en votación
              </p>
            </a>
          </li>
          @endif
          @endif

          <li class="nav-header">Estadisticas</li>
          
          <li class="nav-item">
            <a href="{{route('metricasusers')}}" class="nav-link @if(Request::is('metricas/ranking')) active @endif">
            <i class="nav-icon fas fa-chart-bar"></i>
              <p>
              Mi Posición en el Ranking 
              </p>
            </a>
          </li>  
          
         
          <li class="nav-item">
            <a href="{{route('recenviados')}}" class="nav-link @if(Request::is('reconocimientos/enviados')) active @endif">
            <i class=" nav-icon fas fa-gift"></i>
              <p>
               Reconocimientos Enviados
              </p>
            </a>
          </li> 
          
          <li class="nav-header">Configuración</li>
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