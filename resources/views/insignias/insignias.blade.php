@extends('usuario.principa_usul')
@section('content')
<div class="alert alert-success text-center" role="alert">
 Registro De Categorias
</div>
<br>
<form action="{{route('reginsignias')}}" method="POST"  enctype="multipart/form-data">
  @csrf
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre">
    </div>
    <div class="form-group col-md-6">
      <label for="des">Descripción</label>
      <input type="text" class="form-control" id="des" name="des"> 
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="scompor">Comportamiento</label>
      <select id="scompor" name="scompor" class="form-control">
        <!--<option selected>Elegir opción</option>-->
        @foreach($dat as $c)
        <option value="{{$c->id}}">{{$c->descripcion}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="imagen">Imagen</label>
      <input type="file" class="form-control" id="imagen" name="imagen">
    </div>
  </div>
 <button type="submit" class="btn btn-primary">Guardar</button>
 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visualizarmodal">
  Ver insignias
</button>
</form>
<!--instanciar el ajax para quitar el error no definido-->
<div class="modal fade" id="visualizarmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Premios Registrados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--tabla para ver los valores-->
            <table class="table">
              <thead class="table-warning">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Comportamiento</th>
                <th scope="col">Imagen</th>
              </tr>
            </thead>
            <tbody>
            @php
              $con = 1;
            @endphp
            @foreach($categ as $c)
                <tr>
                  <th scope="row">{{$con++}}</th>
                  <td>{{$c->nombre}}</td>
                  <td>{{$c->descripcion}}</td>
                  <td>{{$c->id_comportamiento}}</td>
                  <td>
                    <div class="text-center">
                    <img src="{{asset('imgpremios/'.$c->rutaimagen)}}" class="rounded" alt="..."  width= "50px" height="50px" >
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

@endsection