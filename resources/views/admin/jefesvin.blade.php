@extends('usuario.principa_usul')
@section('content')

@if(Session::has('jefe'))
        <br>
        <div class="alert alert-dismissible fade show letraform" role="alert" style="background-color:#1ED5F4;">
        <strong>{{Session::get('jefe')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
@endif
@if(Session::has('vincu'))
        <br>
        <div class="alert alert-dismissible fade show letraform" role="alert" style="background-color:#EC4857;">
        <strong>{{Session::get('vincu')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
@endif
@if(Session::has('regis'))
        <br>
        <div class="alert alert-dismissible fade show letraform" role="alert" style="background-color:#1ED5F4;">
        <strong>{{Session::get('regis')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
@endif

<div class="table-responsive">
    <table class="table letraform" >
              <thead class="tablaheader">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Email</th>
                <th scope="col">Rol</th>
                <th scope="col">Cargo</th>
                <th scope="col">Area</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
                <?php
                $con=1;
                ?>
                @foreach($lista as $c)
                        <tr>
                        <th scope="row">{{$con++}}</th>
                        <td>{{$c->name}}</td>
                        <td>{{$c->apellido}}</td>
                        <td>{{$c->email}}</td>
                        <td>{{$c->rol}}</td>
                        <td>{{$c->nomcar}}</td>
                        <td>{{$c->nomarea}}</td>
                        <td>
                            <div class="text-center">
                    <!--#######################################3-->
                            <a type="button" data-toggle="modal" data-target="#cambiarPro{{$c->id}}" data-placement="bottom"  title="Deshabilitar"><i class="nav-icon fas fa-edit" style="color:#e1b308; font-size:20px;" ></i></a>
                            <a type="button" data-toggle="modal" data-target="#staticBackdrop{{$c->id}}"><i class="fas fa-eye" style="font-size:20px;"></i></a>
                            <!-- Ventana modal para deshabilitar -->
                             <form action="{{route('vinjefes')}}" method="POST" class="letraform">
                                @csrf
                               <div class="modal fade" id="cambiarPro{{ $c->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div  style="background-color:white !important;">
                                                <h4 class="modal-title text-center" style="color:black; text-align: center;">
                                                    <br>
                                                   <span>Vincular a <span style="background-color:yellow;"> {{ $c->name }} {{ $c->apellido }}</span> con un jefe </span>
                                                   <hr>
                                                </h4>
                                            </div>
                                            <div class="modal-body mt-2 text-center">
                                                <strong style="text-align: center !important"> 
                                                  <!--select-->
                                                  <div class="form-group">
                                                    <select class="form-control" id="idreporta" name="idreporta">
                                                      <option value="elegir" selected>Elegir jefe...</option>
                                                       @foreach($lista as $a)
                                                        @if($c->name != $a->name && $c->id  != $a->id)
                                                        <option value="{{$a->id}}">{{$a->name}} {{$a->apellido}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                  <!--end select--->
                                                </strong>
                                            </div>
                                                 <input type="text" name="idjefe" value="{{$c->id}}" hidden>
                                                <div class="modal-footer">
                                                <button class="btn btn-success" type="submit">Seleccionar</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               </form>
                                <!---fin ventana deshabilitar--->
                                <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop{{$c->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                        <div class="modal-header titulo">
                                            <h5 class="modal-title" id="staticBackdropLabel">Jefes Vinculados para: <span style="background-color:yellow">{{$c->name}} {{$c->apellido}} </span></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        <!----table--->
                                        <div class="table-responsive">
                                        <table class="table table-bordered letraform">
                                            <thead class="tablaheader">
                                                <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Apellido</th>
                                                <th scope="col">Cargo</th>
                                                <th scope="col">Area</th>
                                                <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                             $conta=1;
                                            ?>
                                            @if($jefes != null)
                                                @foreach($jefes as $j)
                                                @if($c->id == $j->id_jefe)
                                                <tr>
                                                <td> {{$conta++}}</td>
                                                <td> {{$j->nomjef}}</td>
                                                <td> {{$j->apejef}}</td>
                                                <td> {{$j->nomcar}}</td>
                                                <td> {{$j->nomarea}}</td>
                                                <td> <a href="/eliminar/jefes/{{$j->idjefes}}" class="btn" style="background-color:#EC4857;"><i class="fas fa-trash-restore-alt" style="background-color:white;"></i></a></td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            @endif
                                                                                      
                                            </tbody>
                                            </table>
                                        </div>
                                        <!---end table-->
                                        </div>
                                        <div class="modal-footer letraform">
                                            <button type="button" class="btn salir" data-dismiss="modal">Cerrar</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>

      
                           <!---#######################################-->    
                        </div>
                        </td>
                        </tr>
                    @endforeach
            </tbody>
          </table>
      </div>
      <!--button-->
      <div class="row letraform">
         <div class="col-12">
          <a href="/areas/empresa" class="btn salir float-right">&nbsp;&nbsp;Volver</a>
         </div>
      </div>
        <!--end tabla-->

    <!-- Button trigger modal -->
@endsection


