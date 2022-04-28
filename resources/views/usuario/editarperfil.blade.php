@extends('usuario.principa_usul')
@section('content')

<div class="alert text-center" role="alert" style="background-color:#1ED5F4;">
 <h3>Actualizar Datos De: {{$dat[0]->name}} {{$dat[0]->apellido}}</h3>
</div>
@if(Session::has('mensaje'))
        <br>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>{{Session::get('mensaje')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <br>
@endif
@if(Session::has('menerror'))
        <br>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{Session::get('menerror')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <br>
@endif  
<form action="{{route('datosper')}}" method="POST" enctype="multipart/form-data">
@csrf
<div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre</label>
      <input type="text" class="form-control" id="inputEmail4" name="nombre" value="{{$dat[0]->name}}">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Apellido</label>
      <input type="text" class="form-control" id="inputPassword4"  name="apellido" value="{{$dat[0]->apellido}}">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Dirección</label>
      <input type="text" class="form-control" id="inputEmail4"name="direccion" value="{{$dat[0]->direccion}}">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Telefono</label>
      <input type="text" class="form-control" id="inputPassword4" name="telf"  value="{{$dat[0]->telefono}}">
    </div>
  </div>
  <div class="form-row">
   <div class="form-group col-md-4">
    <label for="inputAddress">Email</label>
    <input type="email" class="form-control" id="inputAddress" name="correo"  value="{{$dat[0]->email}}">
    </div>
    <div class="form-group col-md-4">
    <label for="inputAddress">Contraseña</label>
    <input type="password" class="form-control" id="inputAddress" name="pass" placeholder="***************">
    </div>
    <div class="form-group col-md-4">
     <label for="exampleFormControlFile1">Seleccionar Imagen</label>
    <input type="file" class="form-control" id="img" name="img" required>
    </div>
   </div>
  <div class="row">
      <div class="col-md-6">
      <input type="text" class="form-control" id="inputCity" name="id"   value="{{$dat[0]->idusu}}" hidden>
        <button type="submit" class="btn btn-info">Guardar Cambios</button>
        <a type="button" href="/perfil" class="btn btn-success">Volver</a>
      </div>
      <div class="col-md-6">
        
      </div>
  </div>
</form>

@endsection