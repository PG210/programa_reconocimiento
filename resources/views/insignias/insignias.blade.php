@extends('usuario.principa_usul')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
 <div class="container"> 
  <div class="row mb-2">
   <div class="col-sm-8">
    <h1 class="m-0"><a href="/Categorias/registro"  type="button" class="btn btn-default salir"><i class="fas fa-arrow-left"></i> Volver</a> Registro de comportamientos</h1>
   </div>
   <!-- /.col -->
   <div class="col-sm-4">
    <ol class="breadcrumb float-sm-right">
     <li class="breadcrumb-item"><a href="#">Inicio</a></li>
     <li class="breadcrumb-item"><a href="#">Empresa</a></li>
     <li class="breadcrumb-item active"> Comportamientos</li>
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
  <div class="mb-2" role="group" aria-label="Basic outlined example">
  
  <button type="button"  class="btn btn-warning confirmar letraform" data-toggle="modal" data-target="#visualizarmodal">Agregar</button>
</div>  
  <div class="card">

                    <div class="card-header">
                      Mostrar
                      <select class="form-select" id="recordsPerPage" onchange="changeRows()">
                          <option value="5">5 registros</option>
                          <option value="10" selected>10 registros</option>
                          <option value="25">25 registros</option>
                          <option value="50">50 registros</option>
                        </select> registros por página
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
                        
                            <div class="table-responsive">
                            <table class="table table-hover table-estadisticas" >
                            <!--tabla para ver los valores-->
      <thead class="tablaheader">
      <tr>
        <th scope="col">No</th>
        <th scope="col">Comportamiento</th>
        <th scope="col">Categoria</th>
        <th scope="col">Puntos</th>
        <th scope="col" class="text-center" style="width: 100px">Acción</th>
      </tr>
    </thead>
        <tbody>
          @if($b == 1)
            @php
              $con = 1;
            @endphp
            @foreach($categ as $c)
                <tr>
                  <th scope="row">{{$con++}}</th>
                  <td>{{$c->nombre}}</td>
                  <td>{{$c->compor}}</td>
                  <td>{{$c->puntos}}</td>
                  <td>
                    <!--=======================--->
                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <a type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#actualizarcom{{$c->id}}">
                      <i class="fas fa-edit"></i>
                    </a>
                    <!-- Colocar una ventana modal que pregunte si esta seguro de eliminar-->
                    <a href="{{route('deleteCom', $c->id)}}" type="button" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                    </div>
                     <!-- Button trigger modal -->
                    <!-- Modal -->
                    <div class="modal fade" id="actualizarcom{{$c->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Actualizar Comportamiento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form  method="POST" action ="{{route('actualizarcat', $c->id)}}" enctype="multipart/form-data" class="letraform">
                          <div class="modal-body">
                            <p>Modifica los detalles de este comportamiento para ajustarlo a la estrategia de reconocimiento.</p>
                            <!--============== aqui info-->
                             @csrf
                              <div class="form-group">
                                  <label for="nombrenew">Nombre</label>
                                  <p> Edita el nombre del comportamiento.</p>
                                  <textarea class="form-control" id="nombrenew" name="nombrenew" rows="3" required>{{$c->nombre}}</textarea>
                                </div>
                                <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="comnew">Comportamiento</label>
                                  <p>Selecciona la categoría a la que pertenece este comportamiento.</p>
                                  <select class="form-control" id="comnew" name="comnew" required>
                                  <option selected value="{{$c->id_comportamiento}}">{{$c->compor}}</option>
                                    @foreach($dat as $co)
                                     @if($co->id != $c->id_comportamiento)
                                      <option value="{{$co->id}}">{{$co->descripcion}}</option>
                                     @endif
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group col-md-6">
                                  <div class="row">
                                      <div class="col-lg-12 col-md-12">
                                       <label for="puntosnew">Puntos</label>
                                       <p>Asigna la cantidad de puntos que otorga este comportamiento.</p>
                                       <input type="number" class="form-control" id="puntosnew" name="puntosnew" value="{{$c->puntos}}" min="0" required>
                                      </div>
                                  </div>
                                </div>
                                
                            <!--=====================--->
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default salir" data-dismiss="modal">Salir</button>
                            <button type="submit" class="btn btn-success confirmar">Guardar</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!--=========================-->
                </td>
                </tr>

             @endforeach
              @else
                  <div class="alert alert-warning text-center letraform" role="alert">
                    No Hay Registros
                  </div>
              @endif
           
            </tbody>
          </table>

<!--end tabla-->
                            </div>
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
<div class="modal fade" id="visualizarmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title titulo" id="exampleModalLabel">Agregar Comportamiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('reginsignias')}}" method="POST"  enctype="multipart/form-data" class="letraform">
      <div class="modal-body">
        <p>Registra un nuevo comportamiento para reconocer acciones destacadas.</p>
      <!--========================================-->
        @csrf
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="nombre">Nombre</label>
            <p>Ingresa el nombre del comportamiento.</p>
            <textarea class="form-control" id="nombre" name="nombre" rows="3" required></textarea>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="scompor">Categoría</label>
            <p>Selecciona la categoría a la que pertenece este comportamiento.</p>
            <select id="scompor" name="scompor" class="form-control" required>
              <!--<option selected>Elegir opción</option>-->
              @foreach($dat as $c)
              <option value="{{$c->id}}">{{$c->descripcion}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="puntos">Puntos</label>
            <p>Asigna la cantidad de puntos que otorga este comportamiento.</p>
            <input type="number" class="form-control" id="puntos" name="puntos"  min="0" required>
          </div>
        </div>
      <!--========================================-->
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default salir" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-success confirmar">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection