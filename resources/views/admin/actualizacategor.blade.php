@extends('usuario.principa_usul')
@section('content')
<!--formulario de actualizacion-->
<div class="alert titulo text-center" role="alert">
<h3>ACTUALIZAR CATEGORíA</h3>
</div>
@if(Session::has('actualizado'))
<br>
<div class="alert alert-warning alert-dismissible fade show letraform" role="alert">
  <strong>{{Session::get('actualizado')}}</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
<form  method="POST" action ="{{route('guarcategoria', $cat[0]->id)}}" class="letraform" enctype="multipart/form-data">
    @csrf
<div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" class="form-control" id="des" name="des" value="{{$cat[0]->descripcion}}">
  </div>
  <div class="form-group">
    <label for="puntos">Imagen</label>
    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
  </div>
  <div class="form-group">
    <div class="row">
        <div class="col-2">
        </div>
        <div class="col-6">
        </div>
        <div class="col-4 text-right">
        <button type="submit" class="btn confirmar">Actualizar</button>
        <a href="#" type="button" class="btn salir" onclick="back()">Volver</a>
        </div>
    </div>
  </div>
  
</form>
<!--end formulario actualizacion-->
    <script type="text/javascript">
      function back(){
        window.location.href = "/Categorias/registro";
      }
    </script>
@endsection
