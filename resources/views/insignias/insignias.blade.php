@extends('usuario.principa_usul')
@section('content')
<div class="alert alert-success text-center" role="alert">
 Registro De Categorias
</div>
<br>
<form method="post" id="formudatos" name="formudatos" enctype="multipart/form-data">
  @csrf
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre">
    </div>
    <div class="form-group col-md-6">
      <label for="des">Descripción</label>
      <input type="text" class="form-control" id="des">
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
      <input type="file" class="form-control" id="imagen">
    </div>
  </div>
 <button type="submit" class="btn btn-primary">Guardar</button>
 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
  Ver insignias
</button>
</form>
<!--Modal mensaje-->
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Insignias Registradas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Enviar</button>
      </div>
    </div>
  </div>
</div>

<!--instanciar el ajax para quitar el error no definido-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
  /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
  $('#formudatos').submit(function(e){
    e.preventDefault();
    var nombre=$('#nombre').val();
    var descripcion=$('#des').val();
    var id=$('#scompor').val();
    var imagen=$('#imagen').val();
    var _token = $('input[name=_token]').val();

    $.ajax({
      type: "POST",
      url:"{{route('reginsignias')}}",
     
      data:{
        nombre:nombre,
        descripcion:descripcion,
        id:id,
        imagen:imagen,
        _token:_token
      }, 
      success:function(response){
        if(response){
          $('#formudatos')[0].reset();
          toastr.success('El registro se ingreso correctamente.', 'Nuevo Registro', {timeOut:3000});
        }
      }
    });
  });
 </script> 

@endsection