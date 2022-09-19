@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert">
 <h3>ACTUALIZAR INSIGNIAS</h3>
</div>
<br>
@if(Session::has('actualizainsig'))
<br>
<div class="alert alert-warning alert-dismissible fade show letraform" role="alert">
  <strong>{{Session::get('actualizainsig')}}</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<br>
@endif
<form action="{{route('registroinsigniasactu', $datosin[0]->id)}}" method="POST"  enctype="multipart/form-data" class="letraform">
  @csrf
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" value="{{$datosin[0]->name}}" required>
    </div>
    <div class="form-group col-md-6">
      <!---Seleccion-->
      <label for="descripcion">Nivel</label>
        <select class="form-control" id="descripcion" name="descripcion">
          <option value="{{$datosin[0]->descripcion}}" selected>{{$datosin[0]->descripcion}}</option>
          <option value="Oro">Oro</option>
          <option value="Plata">Plata</option>
          <option value="Bronce">Bronce</option>
        </select>
      <!--end Seleccion-->
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
      <!---Seleccion-->
      <label for="categoria">Categoria</label>
        <select class="form-control" id="categoria" name="categoria">
          <option value="{{$datosin[0]->idcateg}}">{{$datosin[0]->descateg}}</option>
        @foreach($categ as $ca)
          <option value="{{$ca->id}}">{{$ca->descripcion}}</option>
        @endforeach
        </select>
      <!--end Seleccion-->
    </div>
   <div class="form-group col-md-6">
    <label for="puntos">Puntos</label>
    <input type="text" class="form-control" id="puntos" name="puntos" value="{{$datosin[0]->puntos}}" required>
   </div>
   
  </div>

  <div class="form-group">
  <!---Colapso-->
  <label for="inputState">Elegir Recompensa</label>
  <div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
    <a class="btn btn-link btn-block text-right collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
    <i class="fas fa-angle-double-down"></i>
    </a>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <!--tabla-->
        <!--tabla para ver los valores-->
        <table class="table">
              <thead class="tablaheader">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Imagen</th>
                <th scope="col">Seleccionar</th>
              </tr>
            </thead>
            <tbody>
            @php
              $con = 1;
            @endphp
            @foreach($pre as $c)
                <tr>
                  <th scope="row">{{$con++}}</th>
                  <td>{{$c->name}}</td>
                  <td>{{$c->descripcion}}</td>
                  <td>
                    <div class="text-center">
                    <img src="{{asset('imgpremios/'.$c->rutaimagen)}}" class="rounded" alt="..."  width= "50px" height="50px" >
                  </div>
                </td>
                <td>
                <div>
                  <input type="radio" id="contactChoice1"
                  name="premio" value="{{$c->id}}">
                  <label for="contactChoice1"> </label>
                </div>
                </td>
                <!--  <td><button type="button" class="btn btn-success">Actualizar</button></td>
                  <td><button type="button" class="btn btn-danger">Eliminar</button></td>
                 -->
                </tr>
             @endforeach
            </tbody>
            <input type="radio" id="contactChoice1"  name="premio" value="{{$datosin[0]->idpremio}}" checked hidden>
          </table>

        <!--end tabla-->
        <!--end tabla-->
            </div>
            </div>
        </div>
        </div>


        <!---end colapso-->
        </div>
        
    <div class="form-group">
        <label for="img">Seleccionar Imagen</label>
        <input type="file" class="form-control form-control-file" name="img" id="img">
    </div>

  <br>
  <a href="/registro/insignias" type="button" class="btn salir" >Volver</a>
  <button type="submit" class="btn confirmar">Actualizar</button>
</form>
@endsection