@extends('usuario.principa_usul')
@section('content')
<div class="alert alert-primary text-center" role="alert">
 Registro De Premios
</div>
<br>
<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre</label>
      <input type="text" class="form-control" id="inputEmail4" placeholder="Ingrese nombre">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Descripción</label>
      <input type="text" class="form-control" id="inputPassword4" placeholder="Detalle">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Puntos</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="Ingrese puntos">
  </div>
  <div class="form-group">
  <label for="inputState">Elegir imagen</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>...</option>
      </select>
  </div>
  <button type="submit" class="btn btn-primary">Registrar</button>
  <button type="submit" class="btn btn-primary">Visualizar</button>
</form>


@endsection