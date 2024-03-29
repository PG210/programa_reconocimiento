@extends('usuario.principa_usul')
@section('content')
<!--formulario de actualizacion-->
<div class="alert text-center titulo" role="alert">
<h3>ACTUALIZAR COMPORTAMIENTO</h3>
</div>
<form  method="POST" action ="{{route('actualizarcat', $cat[0]->idcat)}}" enctype="multipart/form-data" class="letraform">
    @csrf
<div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" class="form-control" id="nombre" name="nombre" value="{{$cat[0]->nombre}}">
  </div>
  <div class="form-group">
    <label for="com">Comportamiento</label>
    <select class="form-control" id="com" name="com">
    <option selected value="{{$cat[0]->id_comportamiento}}">{{$cat[0]->des}}</option>
      @foreach($com as $c)
      <option value="{{$c->id}}">{{$c->descripcion}}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <div class="row">
        <div class="col-6" style="border: 1px solid #ced4da;">
        <label>Imagen</label>
        <br>
        <img src="{{asset('imgpremios/'.$cat[0]->rutaimagen)}}" class="rounded" alt="..."  width= "50px" height="50px"  >
        </div>
        <div class="col-6" style="border: 1px solid #ced4da;">
        <div class="form-group">
            <label for="exampleFormControlFile1">Cambiar Imagen</label>
            <input type="file" class="form-control-file" id="imagen" name="imagen">
        </div>
        <br>
        </div>
    </div>
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
        history.back();
      }
    </script>
@endsection
