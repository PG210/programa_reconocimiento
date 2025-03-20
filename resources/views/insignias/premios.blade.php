@extends('usuario.principa_usul')
@section('content')
@include('usuario.datatables')
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
<div class="alert alert-warning alert-dismissible fade show letraform mb-2" role="alert">
  <strong>{{Session::get('eliminarexit')}}</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<br>
@endif

@if(Session::has('actualizadopre'))
<div class="alert alert-warning alert-dismissible fade show letraform mb-2" role="alert">
  <strong>{{Session::get('actualizadopre')}}</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<br>
@endif

<!--Modal visualizar imagenes-->
<div class="card-header">
    <div class="btn-group" role="group" aria-label="Basic outlined example">
      <button type="button" class="btn btn-warning confirmar letraform" data-toggle="modal" data-target="#visualizar">Agregar</button>
    </div>
</div>
   <!-- /.card-header -->
    <div class="px-3">
                        
      <div class="table-responsive mt-3 mb-3">
         <table class="table table-hover table-estadisticas" id="table02">
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
                 <td>
                  <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button  type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editar{{ $c->id }}"><i class="fas fa-edit"></i></button>
            
                    <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#eliminarPre{{$c->id}}">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </div>
                    <!-- Modal registrar insignias -->
                    <div class="modal fade" id="editar{{ $c->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content ">
                          <div class="modal-header">
                            <h5 class="modal-title titulo" id="exampleModalLabel">Actualización recompensas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="{{route('regpremioactu')}}" method="POST" class="letraform"  enctype="multipart/form-data">
                              @csrf
                            <!-- Content Header (Page header) -->
                            <div class="modal-body">
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="nombre">Nombre</label>
                                  <input type="text" class="form-control" id="nombreupdate{{ $c->id }}" name="nombreupdate" value="{{$c->name}}" required>
                                  <input type="hidden" value="{{ $c->id }}" name="idupdate" id="idupdate{{ $c->id }}">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="des">Descripción</label>
                                  <input type="text" class="form-control" id="desupdate{{ $c->id }}" name="desupdate"  value="{{$c->descripcion}}" required>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="exampleFormControlFile1">Seleccionar Imagen</label>
                                <input type="file" class="form-control-file form-control" id="imgupdate{{ $c->id }}" name="imgupdate">
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between ">
                              <button type="button" class="btn btn-default salir" data-dismiss="modal">Salir</button>
                              <button type="submit" class="btn btn-success #confirmar">Actualizar</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!---end modal-->
                    <!---modal para confirmar eliminar -->
                    <div class="modal fade" id="eliminarPre{{$c->id}}" tabindex="-1"
                      aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                ¿Seguro que quieres eliminar el premio "{{$c->name}}"?
                              </p>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <form action="{{ route('eliminarpremio') }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="idpre" id="idpre{{$c->id}}" value="{{$c->id}}">
                                  <button type="submit" class="btn btn-success">Eliminar</button>
                                </form>
                              </div>
                            </div>
                        </div>
                    </div>
                  <!--end modal confirmar-->
                </td>
                </tr>
             @endforeach
            </tbody>
          </table>
    </div>
<!--end tabla-->
</div>     

<!-- Modal registrar recompensas -->
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
<!---end modal-->
</div>
  </div>
</div>
</div>

<script>
  $('#table02').DataTable({
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
    },
  });
</script>
@endsection