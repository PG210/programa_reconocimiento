@extends('usuario.principa_usul')
@section('content')
@include('usuario.datatables')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h1 class="m-0">Gestión de usuarios</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Gestión de usuarios</li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<div class="container">

<div class="row mb-3">
<div class="col-12">
    <!---mensaje-->
    @if($deshab == 1)
    <div class="alert alert-danger" role="alert">
    ⚠️ <strong>Licencias vencidas:</strong> Tu licencia expiró el <b>{{$fecha}}</b>. Por favor, renueva para continuar. 
</div> 
            @endif
</div>
            @if(empty($licencias))
            <div class="card"> 
              <div class="card-body">
					<!-- small box -->
                     <h5>🔑 Licencias Requeridas</h5>
					<p class="letraform">
                    Para registrar nuevos usuarios, solicita las licencias al administrador.  </p>
                    </div>
                    </div>
            @else
              @if($totaluser < $licencias->numlicencia)
              <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">

                <h5>Crear usuario</h5>
                <p class="m-0">Sube todos los usuarios de una sola vez de forma rápida.</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
                    <!---boton registro individual-->
                    <a type="button" class="small-box-footer" data-toggle="collapse" href="#regusuarioindi" role="button" aria-expanded="false" aria-controls="collapseExample" >
                    Crear nuevo usuario <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    <!---==========================--->
            </div>
          </div>
        
                    <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">

                <h5>Carga masiva</h5>
                <p class="m-0">Sube todos los usuarios de una sola vez de forma rápida.</p>
              </div>
              <div class="icon">
                <i class="fas fa-file-excel"></i>
              </div>
              <a type="button" class="small-box-footer" data-toggle="modal" data-target="#carga">Sube tu archivo <i class="fas fa-arrow-circle-right"></i></a>
              
            </div>
          </div>

          
              @else
              <div class="col-lg-8 col-6">
              <div class="card"> 
              <div class="card-body">
					<!-- small box -->
                     <h5>⚠️ Licencias Agotadas</h5>
					<p class="letraform">
                    No puedes registrar más usuarios. Solicita nuevas licencias al administrador para continuar. </p>
                    </div>
                    </div>
                    </div>
              @endif
            @endif
            
            <div class="col-lg-4 col-6">
					<!-- small box -->
					<div class="small-box bg-warning">
						<div class="inner">
							<p class="m-0">Licencias</p>
							
              @if(isset($licencias->numlicencia))
                <h5>{{$totaluser}} / {{ $licencias->numlicencia }}</h5>
              @endif
							<p class="m-0"><b>0</b> Licencias disponibles.</p>
						</div>
						<div class="icon">
							<i class="ion ion-person-add"></i>
						</div>
						<a href="#" class="small-box-footer">Asignar más <i class="fas fa-arrow-circle-right"></i></a>
					</div>
                    </div>
          
				</div>
      </div>
      
    </div>
    <div class="container">
    <div class="row mb-2">
  <div class="col-12">
    
  <div class="card">
    <div class="card-header">
   <!--tabla para ver los valores-->
   @if(Session::has('mensaje'))
        <div class="alert alert-info alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('mensaje')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    @endif
    @if(session()->has('regexit'))
    <div class="alert alert-info alert-dismissible fade show letraform" role="alert" id="alert">
        {{ session('regexit') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session()->has('regfalse'))
    <div class="alert alert-danger alert-dismissible fade show letraform" role="alert" id="alert">
        {{ session('regfalse') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
       <!-- Mostrar mensajes de éxito -->
    @if(session('success'))
        <div class="alert alert-info alert-dismissible fade show letraform" role="alert" id="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Mostrar mensajes de error -->
    @if(session('error'))
     <div class="alert alert-danger alert-dismissible fade show letraform" role="alert" id="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <!---carga-->
        <!-- Button trigger modal -->
        <div class="row mt-1">
            <!---=============================-->
            <div class="col-12 collapse mt-2" id="regusuarioindi">
                <div class="card card-body letraform">
                    <!---========= fromulario de registro individual ===========-->
                    <h5>Registro Individual de Colaboradores</h5>
                   <p class="m-0"> Añade nuevos colaboradores de forma individual completando todos los campos.</p>
                   <p class=""> Si tienes algún inconveniente, comunícate con el administrador.</p>
                     <form method="POST" action="{{route('addUser')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="nombres" class="col-sm-2 col-lg-2 col-form-label">Nombres</label>
                            <div class="col-sm-4 col-lg-4">
                              <input type="text" class="form-control" id="nombres" name="nombres" required>
                            </div>
                            <label for="apellidos" class="col-sm-2 col-lg-2 col-form-label">Apellidos</label>
                            <div class="col-sm-4 col-lg-4">
                               <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="direccion" class="col-sm-2 col-lg-2 col-form-label">Dirección</label>
                            <div class="col-sm-4 col-lg-4">
                              <textarea class="form-control" id="direccion" name="direccion" rows="2" required></textarea>
                            </div>
                            <label for="telefono" class="col-sm-2 col-lg-2 col-form-label">Celular</label>
                            <div class="col-sm-4 col-lg-4">
                             <input type="text" class="form-control" id="telefono" name="telefono" maxlength="20" minlength="10" pattern="\+[0-9]{10,15}" placeholder="+573109006780" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-lg-2 col-form-label">Email</label>
                            <div class="col-sm-4 col-lg-4">
                              <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <label for="pass" class="col-sm-2 col-lg-2 col-form-label">Contraseña</label>
                            <div class="col-sm-4 col-lg-4">
                            <!---=========================-->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                   <a id="togglePassword" type="button" onclick="togglePasswordVisibility()">
                                     <i id="eyeIcon" class="fas fa-eye-slash"></i>
                                   </a>
                                 </span>
                                </div>
                                <input type="password" class="form-control" id="pass" name="pass" aria-label="Username" aria-describedby="basic-addon1" required>
                            </div>
                            <!---===================-->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rol" class="col-sm-2 col-lg-2 col-form-label">Rol</label>
                            <div class="col-sm-10 col-lg-10">
                              <select class="form-control" id="rol" name="rol" required>
                                @foreach($roles as $rol)
                                 <option value="{{$rol->id}}">{{$rol->descripcion}}</option>
                                @endforeach
                             </select>
                            </div>
                        </div>
                        <div class="form-group row float-right">
                            <button class="btn btn-outline-primary float-end" type="submit">Registrar</button>
                        </div>
                     </form>   
                    <!--========= end formulario =========================-->
                </div>
            </div>
            <!--===============================-->
        </div>
        <!--=======================================================-->
        <!-- Modal -->
        <form action="{{route('usuariosImport')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="carga" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header titulo">
                <h5 class="modal-title" id="exampleModalLabel">Carga Masiva De Usuarios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body letraform">
                <p>Sube y registra múltiples usuarios de forma rápida y sencilla.</p>
               <!--formulario-->
               <div class="input-group mb-3">
                    <div class="custom-file">
                        <p class="m-0">Selecciona el archivo y confirma la carga:</p>
                        <input type="file" class="form-control" name="archivosubido" id="archivosubido" placeholder="elegir" accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel" required>
                        
                    </div>
                 </div>
               <!--formulario de carga-->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default salir" data-dismiss="modal">Salir</button>
                <button type="submit" class="btn btn-success confirmar">Importar</button>
                
            </div>
            </div>
        </div>
        </div>
        </form>
        
    <!--carga masiva-->
    <!---buscador -->
    <!--end buscador-->
    <div class="table-responsive">
    <table class="table table-hover table-estadisticas" id="votacion">
              <thead class="tablaheader letraform">
              <tr>
                <th scope="col" style="witdh: 50px;" class="text-center">No</th>
                <th scope="col">Nombres</th>
                <th scope="col">Email</th>
                <th scope="col">Cargo</th>
                <th scope="col">Area</th>
                <th scope="col" style="witdh: 100px !important;" class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody class="letraform">
                <?php
                $conta=1;
                ?>
                @foreach($lista as $c)
                        <tr>
                        <th scope="row">{{$conta++}}</th>
                        <td>{{$c->name}} {{$c->apellido}}</td>
                        <td>{{$c->email}}</td>
                        <td>{{$c->nomcar}}</td>
                        <td >{{$c->nomarea}}</td>
                        <td style="witdh: 100px !important;" class="text-center">
                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        
                        <a href="{{route('actualizaruser',$c->id)}}" data-toggle="tooltip" data-placement="bottom" class="btn btn-outline-primary btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                         
                         
                         
                        <!--#######################################3-->
                        @if($c->rol != 'admin')
                        <!--eliminar -->
                        <a href="{{route('eliminaruser',$c->id)}}" data-toggle="tooltip" data-placement="bottom"   class="btn btn-outline-danger btn-sm" title="Eliminar" onclick="return confirm('¿Realmente desea eliminar este usuario?');"><i class="fas fa-trash" ></i></a>
                        </div>
                            @if($deshab != 1)
                                <a type="button" data-toggle="modal" data-target="#cambiarPro{{ $c->id }}" data-placement="bottom" title="{{ $c->esta == 'habilitado' ? 'Deshabilitar' : 'Habilitar' }}">
                                        <i class="nav-icon fas fa-toggle-{{ $c->esta == 'habilitado' ? 'on' : 'off' }}" style="color: {{ $c->esta == 'habilitado' ? '#64e108' : '#9cbe82' }}; font-size:20px;"></i>
                                </a>
                            @else
                               <i class="nav-icon fas fa-toggle-off" style="color: #9cbe82, font-size:20px;"></i>
                            @endif
                       
                        @endif
                        <!-- Ventana modal para deshabilitar -->
                        <div class="modal fade" id="cambiarPro{{ $c->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content text-left">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" style="color:var(--dark);">
                                                        Modificar Estado del Usuario "{{$c->esta}}"
                                                    </h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button> 
                                                </div>
                                                <div class="modal-body letraform">
                                                    <p>¿Deseas cambiar el estado de este usuario?</p>
                                                    <p class="m-0">👤 Nombre: <b>{{ $c->name }}</b></p>
                                                    <p class="m-0">📧 Correo: <b>{{ $c->email}}</b></p>

                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default salir" data-dismiss="modal">Cerrar</button>
                                                <a  class="btn btn-success confirmar" href="{{ route('cambiarestado', $c->id) }}">Modificar</a>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!---fin ventana deshabilitar--->


                        <!---#######################################-->    
                        
                        </td>      
                        </tr>
                    @endforeach
            </tbody>
          </table>
      </div>
        <!--end tabla-->
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
<script src="{{ asset('js/buscador.js')}}"></script>
<script>
    setTimeout(function() {
        document.getElementById('alert').style.display = 'none';
    }, 5000); // 3 segundos en milisegundos

    //=====================
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("pass");
    var eyeIcon = document.getElementById("eyeIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    }
}
</script>
<script> 
  $('#votacion').DataTable({
      "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
  });
</script>
@endsection