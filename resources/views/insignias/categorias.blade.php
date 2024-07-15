@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert">
 <h3>REGISTRO DE CATEGORÍAS</h3>
</div>

@if(Session::has('mensaje'))
<div class="alert alert-warning alert-dismissible fade show letraform mb-2" role="alert">
  <strong>{{Session::get('mensaje')}}</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
<!--===============================================-->
<div class="btn-group mb-2" role="group" aria-label="Basic outlined example">
  <button type="button"  class="btn confirmar letraform" data-toggle="modal" data-target="#staticBackdrop">Agregar</button>
  <a href="{{route('reg_insignia')}}" type="button" class="btn float-right letraform botonmorado">Comportamientos</a>
</div>
<!--=================================================================---->
<div class="table-responsive letraform">
<table class="table">
  <thead class="colortablas">
    <tr>
      <th scope="col">No</th>
      <th scope="col">Descripción</th>
      <th scope="col">Imagen</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $contador = 0;
  ?>
  @foreach($dat as $c)
    <tr>
      <th scope="row">{{$contador+=1}}</th>
      <td>{{$c->descripcion}}</td>
      <td>
           <div class="text-center">
            <img src="{{asset('imgpremios/'.$c->rutaimagen)}}" class="rounded zoomable" alt="..."  width= "50px" height="50px" >
          </div>
      </td>
      <td>
        <!--=========Actualizar============--->
        <!-- Button trigger modal -->
        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
          <a type="button" class="btn btn-success" data-toggle="modal" data-target="#actualizar{{$c->id}}"><i class="fas fa-edit"></i></a>
          <a href="{{route('eliminarcat', $c->id)}}" type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="actualizar{{$c->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form  method="POST" action ="{{route('guarcategoria', $c->id)}}" class="letraform" enctype="multipart/form-data">
              <div class="modal-body">
                <!---datos-->
                    @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="des" name="des" value="{{$c->descripcion}}">
                  </div>
                  <div class="form-group">
                    <label for="puntos">Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                  </div>
                <!---end datos-->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn salir letraform" data-dismiss="modal">Salir</button>
                <button type="submit" class="btn letraform confirmar">Guardar</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        <!---end actualizar================-->
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
<!--=================================================================-->
<!-- Modal -->
<div class="modal fade letraform" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Registro De Categorías</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('regcategorias')}}" enctype="multipart/form-data" method="POST">
      <div class="modal-body">
          @csrf
          <div class="form-row letraform">
            <div class="form-group col-md-6">
              <label for="descrip">Nombre</label>
              <input type="text" class="form-control" id="descrip" name="descrip" required>
            </div>
          <!-- <div class="form-group col-md-6">
              <label for="puntos">Puntos</label>
              <input type="number" class="form-control" id="puntos" name="puntos" required>
            </div>-->
            <div class="form-group col-md-6">
              <label for="puntos">Imagen</label>
              <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
            </div>
          </div>
        <!--end tabla-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn salir letraform" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn letraform confirmar">Guardar</button>
      </div>
       </form>
    </div>
  </div>
</div>
<!--instanciar el ajax para quitar el error no definido-->
<style>
  .zoomable {
        transition: transform 0.2s; /* Agrega una transición suave */
    }

    .zoomable:hover {
        transform: scale(3.3); /* Aplica un aumento de escala al pasar el ratón */
    }
</style>
@endsection