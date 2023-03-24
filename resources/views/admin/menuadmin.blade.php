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
         <!--se modifico esta parte -->
          <li class="nav-item">
            <a href="{{route('perfil')}}" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Perfil 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('reg_categ')}}" class="nav-link">
            <i class="nav-icon fas fa-sitemap"></i>
              <p>
                Categorias
              </p>
            </a>
          </li>
          <!--end modificar--->
          <li class="nav-item">
            <a  href="{{route('insignia')}}" class="nav-link">
            <i class="nav-icon fas fa-medal"></i>
              <p>
                Insignias
              </p>
            </a>
          </li>
          <!--se modifico-->
          <li class="nav-item">
            <a href="{{route('premios_vis')}}" class="nav-link">
              <i class="nav-icon fas fa-trophy"></i>
              <p>
                Recompensas
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('reporteusuarios')}}" class="nav-link">
            <i class="nav-icon fas fa-file-excel"></i>
              <p>
                Reportes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('habilitar_votacion')}}" class="nav-link">
            <i class="nav-icon fas fa-vote-yea"></i>
              <p>
                Votación
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('areas')}}" class="nav-link">
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