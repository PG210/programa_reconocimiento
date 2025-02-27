@extends('usuario.principa_usul')
@section('content')

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
                      <div class="card-tools">
                        <div class="" style="display: flex;justify-content: space-around;gap: 10px;">
                          <div class="" style="width: 200px;">
                            <input class="form-control mr-sm-4" type="text" id="search" placeholder="Buscar por nombres...">
                          </div>
                        </div>
                      </div>
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
        <div class="table-responsive">
                            <table class="table table-hover table-estadisticas">
            <thead class="tablaheader">
                <tr>
                <th scope="col">No</th>
                <th scope="col">Cargo</th>
                <th scope="col">Area</th>
                <th scope="col" class="text-center" style="width: 100px">Acción</th>
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
                       <td class="text-center"><!-- Colocar una ventana modal que pregunte si esta seguro de eliminar la área-->
                        <div class="btn-group">
                          <a href="{{route('eliminarcargo',$f->idcar)}}" type="submit" class="btn btn-outline-danger btn-sm"> <i class="fas fa-trash-alt"></i></a>
                            <a type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal{{$f->idcar}}">
                              <i class="fas fa-edit" ></i>
                            </a>
                          
                        </div>
                           
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
                    @if($b==0)
                    <div class="alert alert-warning alert-dismissible fade show letraform" role="alert">
                    <strong>No hay registros disponibles</strong> Por favor, ingresa un cargo para continuar.
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
                        
                            
        
                            </div>
                    

                    
                    <div class="card-footer clearfix">
                      <div class="row">
                        <div class="col-sm-12 col-md-7">
                          <div class="dataTables_info">Showing 1 to 10 of 57 entries</div>
                        </div>
                        <div class="col-sm-12 col-md-5">
                          <div class="">
                            <ul class="pagination m-0">
                              <li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                              <li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                              <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                              <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                              <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
                              <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0" class="page-link">5</a></li>
                              <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li>
                              <li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->


   
  </div>
  <!-- /.row -->
 </div>
 <!-- /.container-fluid -->

</div>
  

<!--instanciar el ajax para quitar el error no definido-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

@endsection