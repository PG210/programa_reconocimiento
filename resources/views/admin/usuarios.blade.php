@extends('usuario.principa_usul')
@section('content')
@include('usuario.datatables')
<div class="text-center titulo">
 <h3>GESTIÓN DE USUARIOS </h3>
</div>
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
           <div class="col-md-10 col-lg-10 col-sm-6 col-6">
            @if(empty($licencias))
             <p class="letraform bg-info py-2">&nbsp;Para proceder con el registro de usuarios, por favor solicita las licencias al administrador.</p>
            @else
              @if($totaluser < $licencias->numlicencia)
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#carga"><i class="fas fa-file-excel"></i>&nbsp;Carga masiva</button>
                    <!---boton registro individual-->
                    <button type="button" class="btn btn-outline-success" data-toggle="collapse" href="#regusuarioindi" role="button" aria-expanded="false" aria-controls="collapseExample" >
                    <i class="fas fa-user-plus"></i>&nbsp;Usuario 
                    </button>
                    <!---==========================--->
                </div>
              @else
                <p class="letraform">&nbsp;Las licencias se han agotado. Para registrar más usuarios, por favor solicita nuevas licencias al administrador.</p>
              @endif
            @endif
            <!---mensaje-->
            @if($deshab == 1)
               <span class="badge badge-danger letraform">Licencias vencidas el día: {{$fecha}} </span>
            @endif
           </div>
           <div class="col-md-2 col-lg-2 col-sm-6 col-6 letraform">
            @if(isset($licencias->numlicencia))
              <h3 class="text-left badge badge-pill badge-info">Licencias</h3>
              <h4 class="text-left badge badge-pill badge-primary">{{$totaluser}} / {{ $licencias->numlicencia }}</h4>
            @endif
           </div>
            <!---=============================-->
            <div class="collapse mt-2" id="regusuarioindi">
                <div class="card card-body letraform">
                    <!---========= fromulario de registro individual ===========-->
                   <p> En esta sección se debe registrar a los colaboradores de manera individual, por favor complete todos los campos. Si presenta inconvenientes comuniquese con el administrador. </p>
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
               <!--formulario-->
               <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="form-control" name="archivosubido" id="archivosubido" placeholder="elegir" accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel" required>
                        <br>
                    </div>
                 </div>
               <!--formulario de carga-->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn confirmar">Importar</button>
                <button type="button" class="btn salir" data-dismiss="modal">Salir</button>
            </div>
            </div>
        </div>
        </div>
        </form>
        
    <!--carga masiva-->
    <!---buscador -->
    <!--end buscador-->
    <div class="table-responsive mt-2">
    <table class="table" id="votacion">
              <thead class="tablaheader letraform">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombres</th>
                <th scope="col">Email</th>
                <th scope="col">Cargo</th>
                <th scope="col">Area</th>
                <th scope="col">Acciones</th>
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
                        <td>{{$c->nomarea}}</td>
                        <td>
                         <div class="text-center">
                         <a href="{{route('actualizaruser',$c->id)}}" data-toggle="tooltip" data-placement="bottom"  title="Editar"><i class="nav-icon fas fa-edit" style="color:  #e1b308; font-size:20px;" ></i></a>
                        <!--#######################################3-->
                        @if($c->rol != 'admin')
                            @if($deshab != 1)
                                <a type="button" data-toggle="modal" data-target="#cambiarPro{{ $c->id }}" data-placement="bottom" title="{{ $c->esta == 'habilitado' ? 'Deshabilitar' : 'Habilitar' }}">
                                        <i class="nav-icon fas fa-toggle-{{ $c->esta == 'habilitado' ? 'on' : 'off' }}" style="color: {{ $c->esta == 'habilitado' ? '#64e108' : '#9cbe82' }}; font-size:20px;"></i>
                                </a>
                            @else
                               <i class="nav-icon fas fa-toggle-off" style="color: #9cbe82, font-size:20px;"></i>
                            @endif
                        <!--eliminar -->
                        <a href="{{route('eliminaruser',$c->id)}}" data-toggle="tooltip" data-placement="bottom"  title="Eliminar" onclick="return confirm('¿Realmente desea eliminar este usuario?');"><i class="nav-icon fas fa-trash" style="color:red; font-size:20px;" ></i></a>
                        @endif
                        <!-- Ventana modal para deshabilitar -->
                        <div class="modal fade" id="cambiarPro{{ $c->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color:white !important;">
                                                    <h4 class="modal-title text-center titulo" style="color:black; text-align: center;">
                                                        <span>¿Modificar el estado "{{$c->esta}}" del Usuario? </span>
                                                    </h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button> 
                                                </div>
                                                <div class="modal-body mt-2 text-center letraform">
                                                    <strong style="text-align: center !important"> 
                                                    {{ $c->name }} - {{ $c->email}}
                                                    </strong>
                                                </div>
                                                <div class="modal-footer">
                                                    <a  class="btn confirmar" href="{{ route('cambiarestado', $c->id) }}">Modificar</a>
                                                    <button type="button" class="btn salir" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!---fin ventana deshabilitar--->


                        <!---#######################################-->    
                        </div>
                        </td>      
                        </tr>
                    @endforeach
            </tbody>
          </table>
      </div>
        <!--end tabla-->
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