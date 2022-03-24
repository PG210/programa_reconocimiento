@extends('usuario.principa_usul')
@section('content')
<div class="alert alert-primary text-center" role="alert">
 Registro De Insignias
</div>
<br>
<form  action="{{route('registroinsignias')}}" method="POST"  enctype="multipart/form-data">
  @csrf
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
    </div>
    <div class="form-group col-md-6">
      <label for="descripcion">Descripción</label>
      <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción">
    </div>
  </div>
  <div class="form-group">
    <label for="puntos">Puntos</label>
    <input type="text" class="form-control" id="puntos" name="puntos" placeholder="Ejm: 100">
  </div>

  <div class="form-group">
  <!---Colapso-->
  <label for="inputState">Elegir premio</label>
  <div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Icono
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <!--tabla-->
        <!--tabla para ver los valores-->
        <table class="table">
              <thead class="table-warning">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Puntos</th>
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
                  <td>{{$c->puntos}}</td>
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


  <button type="submit" class="btn btn-primary">Registrar</button>
  <button type="submit" class="btn btn-primary">Visualizar</button>
</form>

@endsection