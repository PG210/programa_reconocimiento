@extends('usuario.principa_usul')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">
      <h1 class="m-0">Actualizar usuario:</h1>
        <h5  class="m-0">{{$dat[0]->name}} {{$dat[0]->apellido}}</h5>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Actualizar usuario</li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>

<div class="container">
<div class="row mb-2">
  <div class="col-12">
  <div class="card">

                    <div class="card-body">
@if(Session::has('mensaje'))
        <br>
        <div class="alert alert-info alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('mensaje')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <br>
@endif
@if(Session::has('menerror'))
        <br>
        <div class="alert alert-danger alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('menerror')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <br>
@endif
<form action="{{route('actudatos')}}" method="POST" class="letraform">
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
   <!---fechas -->
   <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputfechan">Fecha de nacimiento</label>
      <input type="date" class="form-control" id="inputfechan" readonly="readonly" value="{{$dat[0]->fecna}}">
    </div>
    <div class="form-group col-md-6">
      <label for="inputfechanv">Fecha de ingreso a la empresa</label>
      <input type="date" class="form-control" id="inputfechanv"  readonly="readonly" value="{{$dat[0]->fecingreso}}">
    </div>
  </div>
  <!--- end fechas-->
  <div class="form-row">
   <div class="form-group col-md-6">
    <label for="inputAddress">Email</label>
    <input type="email" class="form-control" id="inputAddress" name="correo"  value="{{$dat[0]->email}}">
    </div>
    <div class="form-group col-md-6">
    <label for="inputAddress">Contraseña</label>
    <input type="password" class="form-control" id="inputAddress" name="pass" placeholder="***************">
    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-6">
        <div class="form-group">
           <label for="exampleFormControlSelect1">Seleccionar Cargo</label>
             <select class="form-control" id="cargo" name="cargo">
              <option value="{{$dat[0]->idcar}}" selected>{{$dat[0]->nombre}}</option>
              @foreach($cargo as $c)
                    <option value="{{$c->id}}">{{$c->nombre}}</option>
              @endforeach
             </select>
        </div>
    </div>
    <div class="form-group col-md-4">
    <div class="form-group">
           <label for="exampleFormControlSelect1">Seleccionar Area</label>
             <select class="form-control" id="area" name="area">
              <option value="{{$dat[0]->idar}}" selected>{{$dat[0]->nomarea}}</option>
              @foreach($area as $a)
                    <option value="{{$a->id}}">{{$a->nombre}}</option>
              @endforeach
             </select>
        </div>
    </div>
    <div class="form-group col-md-2">
    <div class="form-group">
           <label for="exampleFormControlSelect1">Seleccionar Rol</label>
             <select class="form-control" id="rol"  name="rol">
              <option value="{{$dat[0]->idrol}}" selected>{{$dat[0]->descripcion}}</option>
              @foreach($rol as $r)
                    <option value="{{$r->id}}">{{$r->descripcion}}</option>
              @endforeach
             </select>
        </div>
    </div>
  </div>
  <div class="row">
      <div class="col-md-12 modal-footer justify-content-between">
      <input type="text" class="form-control" id="inputCity" name="id"   value="{{$dat[0]->idusu}}" hidden>
        
        <a type="button" href="/reporte/usuarios" class="btn btn-default salir">Volver</a>
        <button type="submit" class="btn btn-success confirmar">Actualizar</button>
      </div>
      <div class="col-md-6">
        
      </div>
  </div>
</form>
</div>
</div>
</div>
</div>
</div>
@endsection

