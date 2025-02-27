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
          
          <li class="nav-header">Metricas</li>
         
          
   
          <li class="nav-item">
            <a href="/gerente/informe/1" class="nav-link @if(Request::is('gerente/informe/1')) active @endif">
            <i class="nav-icon fas fa-medal"></i>
              <p>
                Recompensas
              </p>
             </a>
          </li>
          <li class="nav-item">
            <a href="{{route('visinsignias')}}" class="nav-link @if(Request::is('reporte/visualizar/recompensas')) active @endif">
              <i class="nav-icon fas fa-trophy"></i>
              <p>
              Insignias a Obtener
              </p>
            </a>
          </li>
          @if(isset($es[0]->estado))
          @if($es[0]->estado==1)
          <li class="nav-item">
            <a href="{{route('votacion_user')}}"  class="nav-link @if(Request::is('vista/votacion')) active @endif">
            <i class="nav-icon fas fa-vote-yea"></i>
              <p>
                Votación
              </p>
            </a>
          </li>
          @endif
          @endif

          <li class="nav-header">Configuración</li>
          
          <li class="nav-item">
            <a href="{{route('perfil')}}"  class="nav-link @if(Request::is('perfil')) active @endif">
            <i class="nav-icon fas fa-user-cog"></i>
             <p>
                Perfil 
              </p>
            </a>
          </li>
        <!-- <li class="nav-header">EXAMPLES</li>
    
          <li class="nav-header">MISCELLANEOUS</li>-->
          
        </ul>
      </nav>