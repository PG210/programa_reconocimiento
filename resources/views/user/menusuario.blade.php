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
          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-award"></i>
              <p>
                Reconocer
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('listareconocer')}}" class="nav-link @if(Request::is('reconocimientos/usuario')) active ver @endif">
                &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                &nbsp;<p>Enviar</p>
                </a>
              </li>
              <li class="nav-item">
               <a href="{{route('reporteinsignias')}}" class="nav-link @if(Request::is('reporte/insignias')) active @endif">
                 &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                 &nbsp;<p>Reconocimiento</p>
               </a>
             </li>  
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('reporte_re')}}" class="nav-link @if(Request::is('reconocimientos/listar')) active @endif">
              <i class="nav-icon fas fa-trophy"></i>
              <p>
                Recompensas
              </p>
            </a>
          </li>
          @if(isset($es[0]->estado))
          @if($es[0]->estado==1)
          <li class="nav-item">
            <a href="{{route('votacion_user')}}" class="nav-link @if(Request::is('vista/votacion')) active @endif">
            <i class="nav-icon fas fa-vote-yea"></i>
              <p>
                Votación
              </p>
            </a>
          </li>
          @endif
          @endif
        <!-- <li class="nav-header">EXAMPLES</li>
    
          <li class="nav-header">MISCELLANEOUS</li>-->
          
        </ul>
      </nav>