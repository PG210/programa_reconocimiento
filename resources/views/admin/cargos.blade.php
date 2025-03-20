@extends('usuario.principa_usul')
@section('content')
@include('usuario.datatables')

<!-- Content Header (Page header) -->
<div class="content-header">
 <div class="container"> 
  <div class="row mb-2">
   <div class="col-sm-8">
    <h1 class="m-0"><a type="button" href="{{route('areas')}}" class="btn btn-default salir">Volver</a> Gestión de cargos</h1>
   </div>
   <!-- /.col -->
   <div class="col-sm-4">
    <ol class="breadcrumb float-sm-right">
     <li class="breadcrumb-item"><a href="#">Inicio</a></li>
     <li class="breadcrumb-item"><a href="#">Empresa</a></li>
     <li class="breadcrumb-item active">Gestión de cargos</li>
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
<div class="row mb-2">
  <div class="col-12">
    
  <div class="card">

  <div class="card-header">
      <!---- buttons group -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
          <i class="fas fa-pen-alt"></i>&nbsp;Adicionar cargos
      </button>
    <!--- end buttons group---->
  </div>
  <!-- /.card-header -->
  <div class="px-3">
      <!-- Modal -->
       <form id="formu" action="{{route('guardarcargo')}}" method="POST" class="letraform">
                @csrf
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Adicionar un Nuevo Cargo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <p>Registra un nuevo cargo y asígnalo a su área correspondiente.</p>
                        <!--##############-->
                              <!---##########-->
                        
                              <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre del Cargo</label>
                                <p>Ingresa el nombre del nuevo cargo.</p>
                                <input type="text" class="form-control" id="cargo" name="cargo">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Seleccionar Área</label>
                                <p>Elige el área a la que pertenece este cargo.</p>
                                <select class="form-control" id="idarea" name="idarea">
                                @foreach($area as $a)
                                <option value="{{$a->id}}">{{$a->nombre}}</option>
                                @endforeach
                                </select>
                            </div>
                           
                        <!--###########-->
                        <!----############--->
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default salir" data-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-success confirmar">Adicionar</button>
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
        <div class="table-responsive mt-3 mb-3">
            <table class="table table-hover table-estadisticas" id="dataTable01">
            <thead class="tablaheader">
                <tr>
                <th scope="col">No</th>
                <th scope="col">ID interna</th>
                <th scope="col">Cargo</th>
                <th scope="col">Area</th>
                <th scope="col" class="text-center" style="width: 100px">Acción</th>
                </tr>
            </thead>
                <tbody>
                    @if(isset($info))
                    @foreach($info as $f)
                    <tr>
                       <td>{{ $loop->iteration }}</td>
                       <td>{{ $f->idcar }}</td>
                       <td>{{ $f->cargonom }}</td>
                       <td>{{ $f->areanom }}</td>
                       <td class="text-center"><!-- Colocar una ventana modal que pregunte si esta seguro de eliminar la área-->
                        <div class="btn-group">
                           <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#eliminarCargo{{$f->idcar}}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <a type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal{{$f->idcar}}">
                              <i class="fas fa-edit" ></i>
                            </a>
                          
                        </div>
                         <!---modal eliminar--->
                          <!---modal-->
                            <!--==========================-->
                            <div class="modal fade" id="eliminarCargo{{$f->idcar}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body text-left">
                                    <p>
                                    ¿Seguro que quieres eliminar el cargo "{{  $f->cargonom  }}"?
                                    </p>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                  <form action="{{ route('eliminarcargo') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="idcargo" id="idcargo{{ $f->idcar }}" value="{{ $f->idcar }}">
                                        <button type="submit" class="btn btn-success">Eliminar</button>
                                    </form>  
                                  </div>
                                  </div>
                              </div>
                              </div>
                          <!--========================================-->
                          <!--end modal -->
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
                                      <p>Modifica y asigna el cargo correcto dentro de la organización.</p>
                                         <!--##############-->
                                            <!---##########-->
                                        
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Nombre del Cargo</label>
                                                <p>Ingresa el nuevo nombre del cargo.</p>
                                                <input type="text" class="form-control" id="car" name="car" value="{{$f->cargonom}}">
                                                <input type="text" class="form-control" id="idcargo" name="idcargo" value="{{$f->idcar}}" hidden>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Seleccionar Área</label>
                                                <p>Elige el área a la que pertenece este cargo.</p>
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
                                    <div class="modal-footer justify-content-between">
                                      <button type="button" class="btn btn-default salir" data-dismiss="modal">Cerrar</button>
                                      <button type="submit" class="btn btn-success confirmar">Actualizar</button>
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
              </tbody>
        </table>
      </div>
    </div>
</div>
<!--###########################--->
<!---Modal editar-->
 </div>
</div>
<!-- /.card-body -->
</div>
  <!-- /.row -->
</div>
 <!-- /.container-fluid -->
</div>
  
<script>
  $('#dataTable01').DataTable({
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
    },
  });
</script>

@endsection