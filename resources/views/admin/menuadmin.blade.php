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
         <!--se modifico esta parte -->
          <li class="nav-item">
            <a href="{{route('perfil')}}" class="nav-link @if(Request::is('perfil')) active @endif">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Perfil 
              </p>
            </a>
          </li>
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
                Votación
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('areas')}}" class="nav-link @if(Request::is('areas/empresa')) active @endif">
            &nbsp;<i class="fas fa-industry"></i>
              <p>
                &nbsp;&nbsp;Empresa
              </p>
            </a>
          </li>
            <!-- <li class="nav-header">EXAMPLES</li>
          <li class="nav-header">MISCELLANEOUS</li>-->
          
        </ul>
      </nav>