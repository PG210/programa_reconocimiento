@extends('usuario.principa_usul')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
 <div class="container"> 
  <div class="row mb-2">
   <div class="col-sm-8">
    <h1 class="m-0">Registros de recompensas</h1>
   </div>
   <!-- /.col -->
   <div class="col-sm-4">
    <ol class="breadcrumb float-sm-right">
     <li class="breadcrumb-item"><a href="#">Inicio</a></li>
     <li class="breadcrumb-item active">Registros de recompensas</li>
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

                    
@if(Session::has('eliminarexit'))
<div class="alert alert-warning alert-dismissible fade show letraform" role="alert">
  <strong>{{Session::get('eliminarexit')}}</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<!--Modal visualizar imagenes-->
<div class="card-header">
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <button type="button" class="btn btn-warning confirmar letraform" data-toggle="modal" data-target="#visualizar">Agregar</button>
                        </div>
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
                            <table class="table table-hover table-estadisticas">
              <thead class="tablaheader">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Imagen</th>
                <th scope="col" class="text-center" style="width: 100px;">Acciones</th>
              </tr>
            </thead>
            <tbody>
            @foreach($dat as $c)
                <tr>
                  <th scope="row">{{$c->id}}</th>
                  <td>{{$c->name}}</td>
                  <td>{{$c->descripcion}}</td>
                  <td>
                    <div class="text-center">
                    <img src="{{asset('imgpremios/'.$c->rutaimagen)}}" class="rounded" alt="..."  width= "50px" height="50px" >
                  </div>
                 </td>
                 <td  class="text-center">
                  <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <a href="{{route('actualizarpremio',$c->id)}}" type="button" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></a>
                    <a href="{{route('eliminarpremio',$c->id)}}" type="button" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                  </div>
                </td>
                </tr>
             @endforeach
            </tbody>
          </table>
    </div>
<!--end tabla-->
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
  
<!-- Modal -->
<div class="modal fade" id="visualizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title titulo" id="exampleModalLabel">Registrar Nueva Recompensa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('regpremio')}}" method="POST" class="letraform"  enctype="multipart/form-data">
      <div class="modal-body letraform">
        <p>¡Dale un incentivo especial a tus colaboradores!</p>
        <!--==========================--->
          @csrf
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="nombre">Nombre</label>
              <p>Ingresa el nombre de la recompensa.</p>
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre" required>
            </div>
            <div class="form-group col-md-12">
              <label for="des">Descripción</label>
              <p>Explica brevemente en qué consiste.</p>
              <textarea class="form-control" id="des" name="des" placeholder="Detalle" required rows="2"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="exampleFormControlFile1">Seleccionar Imagen</label>
            <p>Sube una imagen representativa para esta recompensa.</p>
            <input type="file" class="form-control-file form-control" id="img" name="img" required>
          </div>      
        <!---===========================-->
      </div>
      <div class="modal-footer justify-content-between ">
        <button type="button" class="btn btn-default salir" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-success confirmar">Registrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
                        </div>
                      </div>
                    </div>
@endsection