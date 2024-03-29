@extends('usuario.principa_usul')
@section('content')
  <!-- Button trigger modal -->
<div class="alert text-center titulo" role="alert">
 <h3>GESTIÓN DE CARGOS </h3>
</div>
<br>
  <div class="row letraform">
      <div class="col-md-10">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        <i class="fas fa-pen-alt"></i>&nbsp;Registrar
       </button>
      </div>
      <div class="col-md-2">
        <a type="button" href="{{route('areas')}}" class="btn salir float-right">Volver</a>
      </div>
   </div> 

       <!-- Modal -->
       <form id="formu" action="{{route('guardarcargo')}}" method="POST" class="letraform">
                @csrf
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Formulario De Cargos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--##############-->
                              <!---##########-->
                        
                              <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre Cargo</label>
                                <input type="text" class="form-control" id="cargo" name="cargo">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Seleccionar Area</label>
                                <select class="form-control" id="idarea" name="idarea">
                                @foreach($area as $a)
                                <option value="{{$a->id}}">{{$a->nombre}}</option>
                                @endforeach
                                </select>
                            </div>
                           
                        <!--###########-->
                        <!----############--->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn confirmar">Guardar</button>
                        <button type="button" class="btn salir" data-dismiss="modal">Cancelar</button>
                    </div>
                    </div>
                </div>
                </div>
                </form>
       <!--##################--->
      @if(Session::has('mensaje'))
        <br>
        <div class="alert alert-info alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('mensaje')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @endif
        @if(Session::has('mensajeerror'))
        <br>
        <div class="alert alert-danger alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('mensajeerror')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @endif 
    <div class="row">
    <div class="col-md-12"> 
        <br>
        <div class="table-responsive">
        <table class="table letraform">
            <thead class="tablaheader">
                <tr>
                <th scope="col">No</th>
                <th scope="col">Cargo</th>
                <th scope="col">Area</th>
                <th scope="col" class="text-center">Acción</th>
                </tr>
            </thead>
                <tbody>
                    @if($b==1)
                    <?php
                      $conta=1;
                    ?>
                    @foreach($info as $f)
                    <tr>
                       <td>{{$conta++}}</td>
                       <td>{{$f->cargonom}}</td>
                       <td>{{$f->areanom}}</td>
                       <td class="text-center">
                           <a href="{{route('eliminarcargo',$f->idcar)}}" type="submit" class="btn btn-danger float-none"> <i class="fas fa-trash-alt"></i></a>
                           <a type="button" class="btn btn-primary float-none" data-toggle="modal" data-target="#exampleModal{{$f->idcar}}">
                           <i class="nav-icon fas fa-edit" style="color:white;" ></i>
                          </a>
                          <!-- Modal -->
                          <form id="for" action="{{route('actualizarcargo')}}" method="POST">
                            @csrf
                                <div class="modal fade" id="exampleModal{{$f->idcar}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Cargo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="text-align:left;">
                                         <!--##############-->
                                            <!---##########-->
                                        
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Nombre Cargo</label>
                                                <input type="text" class="form-control" id="car" name="car" value="{{$f->cargonom}}">
                                                <input type="text" class="form-control" id="idcargo" name="idcargo" value="{{$f->idcar}}" hidden>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Seleccionar Area</label>
                                                <select class="form-control" id="idar" name="idar">
                                                <option value="{{$f->idarea}}s">{{$f->areanom}}</option>
                                                @foreach($area as $a)
                                                <option value="{{$a->id}}">{{$a->nombre}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        
                                        <!--###########-->
                                        <!----############--->
                                    </div>
                                    <div class="modal-footer letraform">
                                        <button type="submit" class="btn confirmar">Guardar</button>
                                        <button type="button" class="btn salir" data-dismiss="modal">Cancelar</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <!--modal editar-->
                            </form>
                        </td>
                       
                    </tr>
                    @endforeach
                    @endif
                    @if($b==0)
                    <div class="alert alert-warning alert-dismissible fade show letraform" role="alert">
                    <strong>No hay registros!</strong> Por favor ingresa un cargo.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    @endif
                </tbody>
        </table>
      </div>
    </div>
</div>
<!--###########################--->
<!---Modal editar-->
<!-- Button trigger modal -->

<!--instanciar el ajax para quitar el error no definido-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

@endsection