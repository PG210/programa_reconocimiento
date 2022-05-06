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
                &nbsp; &nbsp;<i class="far fa-circle nav-icon"></i>
                &nbsp;<p>Ver Perfil</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-award"></i>
              <p>
                Reconocer
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('enviar')}}" class="nav-link">
                &nbsp; &nbsp;<i class="far fa-circle nav-icon"></i>
                &nbsp;<p>Enviar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('reporteinsignias')}}" class="nav-link">
                &nbsp; &nbsp;<i class="far fa-circle nav-icon"></i>
                &nbsp;<p>Reconocimientos</p>
                </a>
              </li> 
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-medal"></i>
              <p>
                Insignias
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
           
            <li class="nav-item">
                <a href="{{route('insignia')}}" class="nav-link">
                 &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                 &nbsp;<p>Registrar Insignia</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('reg_categ')}}" class="nav-link">
                &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                &nbsp;<p>Categoria</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('reporte_re')}}" class="nav-link">
                &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                &nbsp;<p>Insignias</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-trophy"></i>
              <p>
                Recompensas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('premios_vis')}}" class="nav-link">
                &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                &nbsp;  <p>Registrar</p>
                </a>
              </li>
                      
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-vote-yea"></i>
              <p>
                Votación
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/tables/simple.html" class="nav-link">
                &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Simple Tables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/data.html" class="nav-link">
                &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>DataTables</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-medal"></i>
              <p>
                Reportes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">  
              <li class="nav-item">
                <a href="{{route('reporteusuarios')}}" class="nav-link">
                &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                &nbsp;<p>Usuarios</p>
                </a>
              </li>        
            </ul>
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