@extends('usuario.principa_usul')
@section('content')
<!--formulario de actualizacion-->
<div class="alert alert-success text-center" role="alert">
Actualizar Categoria
</div>
@if(Session::has('actualizado'))
<br>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>{{Session::get('actualizado')}}</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
<form  method="POST" action ="{{route('guarcategoria', $cat[0]->id)}}">
    @csrf
<div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" class="form-control" id="des" name="des" value="{{$cat[0]->descripcion}}">
  </div>
  <div class="form-group">
    <label for="des">Puntos</label>
    <input type="text" class="form-control" id="puntos" name="puntos" value="{{$cat[0]->puntos}}">
  </div>
  <div class="form-group">
    <div class="row">
        <div class="col-2">
        </div>
        <div class="col-8">
        </div>
        <div class="col-2">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="#" type="button" class="btn btn-warning" onclick="back()">Volver</a>
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
