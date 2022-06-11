<?php
  use Illuminate\Support\Facades\DB;

  $es = DB::table('estavotacion')->select('estado')->get();

?>
<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('inicio')}}" class="nav-link active">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inicio
              </p>
            </a>
          </li>    
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Perfil <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('perfil')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ver Perfil</p>
                </a>
              </li>
            </ul>
          </li>
   
          <li class="nav-item">
            <a href="/gerente/informe/1" class="nav-link">
            <i class="nav-icon fas fa-medal"></i>
              <p>
                Reportes
              </p>
             </a>
          </li>
          <li class="nav-item">
            <a href="{{route('visinsignias')}}" class="nav-link">
              <i class="nav-icon fas fa-trophy"></i>
              <p>
                Recompensas
              </p>
            </a>
          </li>
          @if($es[0]->estado==1)
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-vote-yea"></i>
              <p>
                Votación
              </p>
            </a>
          </li>
          @endif
        <!-- <li class="nav-header">EXAMPLES</li>
    
          <li class="nav-header">MISCELLANEOUS</li>-->
          
        </ul>
      </nav>