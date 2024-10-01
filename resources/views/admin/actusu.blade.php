@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert">
 <h3>ACTUALIZAR EL USUARIO: {{$dat[0]->name}} {{$dat[0]->apellido}}</h3>
</div>
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
      <div class="col-md-6">
      <input type="text" class="form-control" id="inputCity" name="id"   value="{{$dat[0]->idusu}}" hidden>
        <button type="submit" class="btn confirmar">Actualizar</button>
        <a type="button" href="/reporte/usuarios" class="btn salir">Volver</a>
      </div>
      <div class="col-md-6">
        
      </div>
  </div>
</form>
@endsection

