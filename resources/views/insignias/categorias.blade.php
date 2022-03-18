@extends('usuario.principa_usul')
@section('content')
<div class="alert alert-success text-center" role="alert">
 Registro De Categorias De Comportamiento
</div>
<br>
<form id="formulario_categorias" name="formulario_categorias">
  @csrf
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="descrip">Descripción</label>
      <input type="text" class="form-control" id="descrip" name="descrip" required>
    </div>
    <div class="form-group col-md-6">
      <label for="puntos">Puntos</label>
      <input type="number" class="form-control" id="puntos" name="puntos" required>
    </div>
  </div>
  
 <button type="submit" class="btn btn-primary">Guardar</button>
 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
  Ver Categorias
</button>
</form>
<!--Modal mensaje-->
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Categorias Registradas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--tablas de informacion--> 
        <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">No</th>
      <th scope="col">Descripción</th>
      <th scope="col">Puntos</th>
      <th scope="col">Actualizar</th>
      <th scope="col">Deshabilitar</th>
    </tr>
  </thead>
  <tbody>
  @foreach($dat as $c)
    <tr>
      <th scope="row">{{$c->id}}</th>
      <td>{{$c->descripcion}}</td>
      <td>{{$c->puntos}}</td>
      <td><button type="button" class="btn btn-success">Actualizar</button></td>
      <td><button type="button" class="btn btn-danger">Eliminar</button></td>
    </tr>
    @endforeach
  </tbody>
</table>

        <!--end tabla-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
       <!-- <button type="button" class="btn btn-primary">Enviar</button>-->
      </div>
    </div>
  </div>
</div>
<!--instanciar el ajax para quitar el error no definido-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
  /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
  $('#formulario_categorias').submit(function(e){
    e.preventDefault();
    var descrip=$('#descrip').val();
    var puntos=$('#puntos').val();
    var _token = $('input[name=_token]').val();

    $.ajax({
      url:"{{route('regcategorias')}}",
      type: "POST",
      data:{
        descrip:descrip,
        puntos:puntos,
        _token:_token
      }, 
      success:function(response){
        if(response){
          $('#formulario_categorias')[0].reset();
          toastr.success('El registro se ingreso correctamente.', 'Nuevo Registro', {timeOut:3000});
        }
      }
    });
  });
 </script> 
@endsection