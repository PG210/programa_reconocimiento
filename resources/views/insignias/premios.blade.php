@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert">
 <h3>REGISTRO DE RECOMPENSAS</h3>
</div>
<br>
@if(Session::has('eliminarexit'))
<br>
<div class="alert alert-warning alert-dismissible fade show letraform" role="alert">
  <strong>{{Session::get('eliminarexit')}}</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<br>
@endif
<form action="{{route('regpremio')}}" method="POST" class="letraform"  enctype="multipart/form-data">
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
     <label for="exampleFormControlFile1">Seleccionar Imagen</label>
    <input type="file" class="form-control-file form-control" id="img" name="img" required>
  </div>
  <br>
  <button type="submit" class="btn confirmar">Registrar</button>
  <button type="button" class="btn ver" data-toggle="modal" data-target="#visualizar">
  Visualizar
</button>
</form>
<!--Modal visualizar imagenes-->

<!-- Modal -->
<div class="modal fade" id="visualizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title titulo" id="exampleModalLabel">Listado De Recompensas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body letraform">
        <!--tabla para ver los valores-->
            <table class="table">
              <thead class="tablaheader">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Imagen</th>
                <th scope="col"></th>
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
                 <td><a href="{{route('actualizarpremio',$c->id)}}" type="button" class="btn btn-success">Actualizar</a></td>
                 <td><a href="{{route('eliminarpremio',$c->id)}}" type="button" class="btn btn-danger">Eliminar</button></td>
                </tr>
             @endforeach
            </tbody>
          </table>

        <!--end tabla-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn salir" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

@endsection