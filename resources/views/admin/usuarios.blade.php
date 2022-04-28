@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center" role="alert" style="background-color:#1ED5F4;">
 <h3>Gestion De Usuarios </h3>
</div>
   <!--tabla para ver los valores-->
   @if(Session::has('mensaje'))
        <br>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>{{Session::get('mensaje')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <br>
    @endif
   <table class="table">
              <thead class="table-warning">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Email</th>
                <th scope="col">Rol</th>
                <th scope="col">Cargo</th>
                <th scope="col">Area</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
                <?php
                $conta=1;
                ?>
                @foreach($lista as $c)
                        <tr>
                        <th scope="row">{{$conta++}}</th>
                        <td>{{$c->name}}</td>
                        <td>{{$c->apellido}}</td>
                        <td>{{$c->email}}</td>
                        <td>{{$c->rol}}</td>
                        <td>{{$c->nomcar}}</td>
                        <td>{{$c->nomarea}}</td>
                        <td>{{$c->esta}}</td>
                        <td>
                            <div class="text-center">
                            <a href="{{route('actualizaruser',$c->id)}}" data-toggle="tooltip" data-placement="bottom"  title="Editar"><i class="nav-icon fas fa-edit" style="color:  #e1b308;" ></i></a>
                    <!--#######################################3-->
                    <?php
                        if($c->esta == 'habilitado'){
                            ?>
                            <a type="button" data-toggle="modal" data-target="#cambiarPro{{$c->id}}" data-placement="bottom"  title="Deshabilitar"><i class="nav-icon fas fa-toggle-on" style="color: #64e108;"></i></a>
                            <?php
                        }else{
                            ?>
                            <a type="button" data-toggle="modal" data-target="#cambiarPro{{$c->id}}" data-placement="bottom"  title="Habilitar"><i class="nav-icon fas fa-toggle-off" style="color: #9cbe82;"></i></a>
                            <?php
                        }
                        ?>
                        <!-- Ventana modal para deshabilitar -->
                        <div class="modal fade" id="cambiarPro{{ $c->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:white !important;">
                                                <h4 class="modal-title text-center" style="color:black; text-align: center;">
                                                    <span>¿Cambiar el estado {{$c->esta}} del Usuario? </span>
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button> 
                                            </div>
                                            <div class="modal-body mt-2 text-center">
                                                <strong style="text-align: center !important"> 
                                                {{ $c->name }} - {{ $c->email}}
                                                </strong>
                                            </div>
                                            <div class="modal-footer">
                                                <a  class="btn btn-success" href="{{ route('cambiarestado', $c->id) }}">Cambiar</a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---fin ventana deshabilitar--->


                    <!---#######################################-->    
                        </div>
                        </td>
                        <!--  <td><button type="button" class="btn btn-success">Actualizar</button></td>
                        <td><button type="button" class="btn btn-danger">Eliminar</button></td>
                        -->
                        </tr>
                    @endforeach
            </tbody>
          </table>

        <!--end tabla-->

@endsection