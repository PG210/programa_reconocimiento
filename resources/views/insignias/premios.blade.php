@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert">
 <h3>REGISTRO DE RECOMPENSAS</h3>
</div>
@if(Session::has('eliminarexit'))
<div class="alert alert-warning alert-dismissible fade show letraform" role="alert">
  <strong>{{Session::get('eliminarexit')}}</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
<div class="btn-group" role="group" aria-label="Basic outlined example">
<button type="button" class="btn confirmar letraform" data-toggle="modal" data-target="#visualizar">Agregar</button>
</div>
<!--Modal visualizar imagenes-->
  <!--tabla para ver los valores-->
<div class="table-responsive letraform mt-2">
            <table class="table">
              <thead class="tablaheader">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Imagen</th>
                <th scope="col">Acciones</th>
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
                    <a href="{{route('actualizarpremio',$c->id)}}" type="button" class="btn btn-success"><i class="fas fa-edit"></i></a>
                    <a href="{{route('eliminarpremio',$c->id)}}" type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                  </div>
                </td>
                </tr>
             @endforeach
            </tbody>
          </table>
    </div>
<!--end tabla-->
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
        <!--==========================--->
          @csrf
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="nombre">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre" required>
            </div>
            <div class="form-group col-md-6">
              <label for="des">Descripción</label>
              <textarea class="form-control" id="des" name="des" placeholder="Detalle" required rows="2"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="exampleFormControlFile1">Seleccionar Imagen</label>
            <input type="file" class="form-control-file form-control" id="img" name="img" required>
          </div>      
        <!---===========================-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn salir" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn confirmar">Registrar</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection