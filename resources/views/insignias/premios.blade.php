@extends('usuario.principa_usul')
@section('content')
<div class="alert alert-primary text-center" role="alert">
 Registro De Premios
</div>
<br>
<form action="{{route('regpremio')}}" method="POST"  enctype="multipart/form-data">
  @csrf
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre" required>
    </div>
    <div class="form-group col-md-6">
      <label for="des">Descripción</label>
      <input type="text" class="form-control" id="des" name="des" placeholder="Detalle" required>
    </div>
  </div>
  <div class="form-group">
    <label for="punto">Puntos</label>
    <input type="text" class="form-control" id="punto" name="punto" placeholder="Ingrese puntos" required>
  </div>
  <div class="form-group">
     <label for="exampleFormControlFile1">Seleccionar Imagen</label>
    <input type="file" class="form-control-file" id="img" name="img" required>
  </div>
  
  <button type="submit" class="btn btn-primary">Registrar</button>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visualizar">
  Visualizar
</button>
</form>
<!--Modal visualizar imagenes-->

<!-- Modal -->
<div class="modal fade" id="visualizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Premios Registrados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--tabla para ver los valores-->
            <table class="table">
              <thead class="table-warning">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Puntos</th>
                <th scope="col">Imagen</th>
              </tr>
            </thead>
            <tbody>
            @foreach($dat as $c)
                <tr>
                  <th scope="row">{{$c->id}}</th>
                  <td>{{$c->name}}</td>
                  <td>{{$c->descripcion}}</td>
                  <td>{{$c->puntos}}</td>
                  <td>
                    <div class="text-center">
                    <img src="{{asset('imgpremios/'.$c->rutaimagen)}}" class="rounded" alt="..."  width= "50px" height="50px" >
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

@endsection