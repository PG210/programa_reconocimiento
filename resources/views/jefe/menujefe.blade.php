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
          <!-- ========================================================-->
          <!--=================-->
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
          <li class="nav-header">Administración</li>
          <li class="nav-item">
            <a href="{{route('recompensas_obtenidas')}}" class="nav-link @if(Request::is('reporte/recompensas')) active @endif">
            <i class="nav-icon fas fa-file-excel"></i>
              <p>
                Mis metricas
              </p>
             </a>
          </li>
          <li class="nav-header">Votaciones</li>
          <!---===========-->
          <li class="nav-item">
            <a href="{{route('habilitar_votacion')}}" class="nav-link @if(Request::is('admin/votacion')) active @endif">
            <i class="nav-icon fas fa-tasks"></i>
              <p>
               Control de votaciones
              </p>
            </a>
          </li>
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
          <li class="nav-header">Configuración</li>
          <!--==============--> 
            <!--===================metricas ============================= -->
            <li class="nav-item">
            <a href="#" class="nav-link ">
            <i class="nav-icon ion-stats-bars"></i>
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
          <li class="nav-item">
            <a href="{{route('perfil')}}" class="nav-link @if(Request::is('perfil')) active @endif">
              <i class="nav-icon ion-ios-body-outline"></i>
              <p>
                Mi perfil
              </p>
            </a>
          </li>
        </ul>
      </nav>