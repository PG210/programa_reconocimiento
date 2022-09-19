@extends('usuario.principa_usul')
@section('content')

<div class="alert text-center titulo" role="alert">
 <h3>ACTUALIZAR RECOMPENSAS</h3>
</div>
<br>
@if(Session::has('actualizadopre'))
<br>
<div class="alert alert-warning alert-dismissible fade show letraform" role="alert">
  <strong>{{Session::get('actualizadopre')}}</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<br>
@endif
<form action="{{route('regpremioactu', $datos[0]->id)}}" method="POST" class="letraform"  enctype="multipart/form-data">
  @csrf
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" value="{{$datos[0]->name}}" required>
    </div>
    <div class="form-group col-md-6">
      <label for="des">Descripción</label>
      <input type="text" class="form-control" id="des" name="des"  value="{{$datos[0]->descripcion}}" required>
    </div>
  </div>
  <div class="form-group">
     <label for="exampleFormControlFile1">Seleccionar Imagen</label>
    <input type="file" class="form-control-file form-control" id="img" name="img">
  </div>
  <br>
  <a href="/premios/reg" type="button" class="btn salir">Volver</a>
  <button type="submit" class="btn confirmar">Actualizar</button>
</form>
<!--Modal visualizar imagenes-->


@endsection