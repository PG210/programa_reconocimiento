@extends('usuario.principa_usul')
@section('content')
<div class="text-center titulo">
 <h3>GESTIÓN DE GRUPOS </h3>
</div>
   <!--tabla para ver los valores-->
   @if(Session::has('exito'))
        <div id="exito-alert" class="alert alert-info alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('exito')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    @endif
    @if ($errors->any())
    <div id="exito-alert" class="alert alert-danger alert-dismissible fade show letraform" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li><strong>{{ $error }}</strong></li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
           </button>
        </div>
    @endif
    <!---carga-->
        <!-- Button trigger modal -->
       
        <!--=================== botones==========================-->
        <div class="btn-group" role="group" aria-label="Basic outlined example">
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#carga">
            <i class="fas fa-user-plus"></i> Grupos
            </button>
        </div>
        <!--=======================================================-->
       
        <!-- Modal -->
        <form action="{{route('nuevoGrupo')}}" method="POST">
        @csrf
        <div class="modal fade" id="carga" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header titulo">
                <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo grupo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body letraform">
               <!--formulario-->
               <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="text" class="form-control" name="grupo" id="grupo" placeholder="Nuevo grupo" accept="text" required>
                        <br>
                    </div>
                 </div>
               <!--formulario de carga-->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn confirmar">Registrar</button>
                <button type="button" class="btn salir" data-dismiss="modal">Salir</button>
            </div>
            </div>
        </div>
        </div>
        </form>
        
    <!--carga masiva-->
    <br>
    <div class="table-responsive">
    <table class="table">
              <thead class="tablaheader letraform">
              <tr>
                <th scope="col">Idgrupo</th>
                <th scope="col">Nombre</th>
                <th scope="col">No. Usuarios</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody class="letraform">
               @foreach($grupos as $grup)
                  <tr>
                    <td>{{$grup->id}}</td>
                    <td>{{$grup->descripcion}}</td>
                    <td>
                      @foreach($tot as $t)
                        @if($grup->id == $t->idgrupo)
                        {{$t->totusu}}
                        @endif
                      @endforeach
                    </td>
                    <td>
                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <a href="{{route('metricas', $grup->id)}}" type="button" class="btn btn-outline-info"><i class="fas fa-chart-line"></i></a>
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#editarGrupo{{$grup->id}}"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#listaUsers{{$grup->id}}"><i class="fas fa-users"></i></button>
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#eliminarGrupo{{$grup->id}}"><i class="fas fa-trash-alt"></i></button>
                    </div>
                    <!--========================================-->
                       <!--=============== usuarios ==============-->
                       <div class="modal fade" id="listaUsers{{$grup->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title letraform" id="exampleModalLabel">Agregar colaboradores al grupo: {{$grup->descripcion}}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body letraform">
                              <!--listado de usuarios-->
                              <div class="row">
                                <div class="col-12 text-end">
                                    <input type="text" class="form-control" id="searchTerm" onkeyup="doSearch()" placeholder="Buscar...">
                                </div>
                              </div>
                              <!--================================-->
                             <form action="{{route('grupUser', $grup->id)}}" method="POST">
                               @csrf
                              <div class="table-responsive">
                              <table class="table" id="tablaDate">
                                <thead>
                                  <tr>
                                    <th></th>
                                    <th>Nombres</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>imagen</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($usuarios as $user)
                                  <tr> 
                                    <td>
                                     
                                        <input type="checkbox" name="checkUsuarios[]" value="{{ $user->id }}" aria-label="Checkbox for following text input" @foreach($usugrupo as $usug) @if($user->id == $usug->idusu && $grup->id == $usug->idgrupo) checked @endif @endforeach>
                                     
                                    </td>
                                    <td>{{$user->name}} {{$user->apellido}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->rol}}</td>
                                    <td>
                                    <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                                      <div class="image">
                                        @if($user->imagen!=null && $user->imagen != 'ruta')
                                          <img src="{{asset('dist/imgperfil/'.$user->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
                                        @endif
                                        @if($user->imagen==null || $user->imagen == 'ruta')
                                        <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >
                                        @endif
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                  @endforeach
                                  <tr class='noSearch hide'>
                                    <td colspan="3"></td>
                                  </tr>
                                </tbody>
                              </table>
                              </div>
                              <!--lista users-->
                            </div>
                             <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>  
                                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Salir</button>
                              </div>
                              </form>
                          </div>
                        </div>
                      </div>
                        <!-- ============Modal ========== -->
                        <div class="modal fade" id="editarGrupo{{$grup->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Información del grupo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('actuGrupo')}}" method="POST">
                             @csrf
                            <div class="modal-body">
                                <!---==========-->
                                    <div class="form-group">
                                        <label for="descrip" class="col-form-label">Nombre</label>
                                        <textarea class="form-control" id="descrip" name="descrip">{{$grup->descripcion}}</textarea>
                                        <input type="number" id="idgrupo" name="idgrupo" value="{{$grup->id}}" hidden>
                                    </div>
                                <!--========-->
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                            </div>
                            </form>
                            </div>
                        </div>
                        </div>
                    <!--==========================-->
                    <div class="modal fade" id="eliminarGrupo{{$grup->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                               <p><small>
                               ¿Estás seguro de que deseas eliminar este grupo {{$grup->descripcion}}?
                               </small></p>
                            </div>
                            <div class="modal-footer">
                            <form action="{{ route('deleteGrupo', $grup->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Si</button>
                            </form>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                            </div>
                            </div>
                        </div>
                        </div>
                    <!--========================================-->
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
        $('#exito-alert').alert('close');
    }, 4000);
</script>
@endsection