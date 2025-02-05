<?php
  use Illuminate\Support\Facades\DB;

  $es = DB::table('estavotacion')->where('estado', '=', 1)->select('estado')->get();

?>
<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('inicio')}}" class="nav-link @if(Request::is('inicio')) active @endif">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inicio
              </p>
            </a>
          </li>    
         
          <li class="nav-item">
            <a href="{{route('perfil')}}" class="nav-link @if(Request::is('perfil')) active @endif">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Perfil
              </p>
            </a>
          </li>
          <!--==============--> 
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
             <li class="nav-item">
               <a href="{{route('metricasPuntos')}}" class="nav-link @if(Request::is('admin/puntos')) active @endif">
                 &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                 &nbsp;<p>Puntos</p>
               </a>
             </li>  
            </ul>
          </li>
          <!-- ========================================================-->
          <!--=================-->
          <li class="nav-item">
            <a href="{{route('listareconocer')}}" class="nav-link @if(Request::is('reconocimientos/usuario')) active ver @endif">
              <i class="nav-icon fas fa-award"></i>
              <p>
                Enviar
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('reporteinsignias')}}" class="nav-link @if(Request::is('reporte/insignias')) active @endif">
              <i class="nav-icon fas fa-trophy"></i>
              <p>
                Reconocimientos
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('recompensas_obtenidas')}}" class="nav-link @if(Request::is('reporte/recompensas')) active @endif">
            <i class="nav-icon fas fa-file-excel"></i>
              <p>
                Reportes
              </p>
             </a>
          </li>
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
       
        </ul>
      </nav>