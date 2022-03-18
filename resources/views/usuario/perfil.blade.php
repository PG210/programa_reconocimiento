@extends('usuario.principa_usul')
@section('content')

<div class="d-flex justify-content-center alert alert-primary" role="alert">
    <h1 >Perfil Usuario</h1>
</div>
<br>
<figure class="figure">
  <img src="{{url('dist/img/avatar5.png')}}" class="figure-img img-fluid rounded" alt="cargando imagen..." width="100px" height="150px">
</figure>
<br>
<form>

<div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre</label>
      <input type="text" class="form-control" id="inputEmail4" readonly="readonly" value="{{$dat[0]->name}}">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Apellido</label>
      <input type="text" class="form-control" id="inputPassword4"  readonly="readonly" value="{{$dat[0]->apellido}}">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Dirección</label>
      <input type="text" class="form-control" id="inputEmail4" readonly="readonly" value="{{$dat[0]->direccion}}">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Telefono</label>
      <input type="text" class="form-control" id="inputPassword4"  readonly="readonly" value="{{$dat[0]->telefono}}">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Email</label>
    <input type="email" class="form-control" id="inputAddress"  readonly="readonly" value="{{$dat[0]->email}}">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Cargo</label>
      <input type="text" class="form-control" id="inputCity"  readonly="readonly" value="{{$dat[0]->nombre}}">
    </div>
    <div class="form-group col-md-4">
      <label for="inputCity">Rol</label>
      <input type="text" class="form-control" id="inputCity"   readonly="readonly" value="{{$dat[0]->descripcion}}">
    </div>
    <div class="form-group col-md-2">
      <label for="inputCity">Estado</label>
      <input type="text" class="form-control" id="inputCity"  readonly="readonly" value="{{$dat[0]->descrip}}">
    </div>
  </div>
</form>
  
@endsection