@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert">
 <h3>REGISTRO DE COMPORTAMIENTOS</h3>
</div>
<br>
<form action="{{route('reginsignias')}}" method="POST"  enctype="multipart/form-data" class="letraform">
  @csrf
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="scompor">Categoria</label>
      <select id="scompor" name="scompor" class="form-control" required>
        <!--<option selected>Elegir opción</option>-->
        @foreach($dat as $c)
        <option value="{{$c->id}}">{{$c->descripcion}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="imagen">Imagen</label>
      <input type="file" class="form-control" id="imagen" name="imagen" required>
    </div>
  </div>
 <button type="submit" class="btn confirmar">Registrar</button>
 <button type="button" class="btn ver" data-toggle="modal" data-target="#visualizarmodal">
  Visualizar
</button> 
</form>
<!--instanciar el ajax para quitar el error no definido-->
<div class="modal fade" id="visualizarmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title titulo" id="exampleModalLabel">Comportamientos Registrados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--tabla para ver los valores-->
            <table class="table letraform">
              <thead class="tablaheader">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Comportamiento</th>
                <th scope="col">Categoria</th>
                <th scope="col">Imagen</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
          @if($b == 1)
            @php
              $con = 1;
            @endphp
            @foreach($categ as $c)
                <tr>
                  <th scope="row">{{$con++}}</th>
                  <td>{{$c->nombre}}</td>
                  <td>{{$c->compor}}</td>
                  <td>
                    <div class="text-center">
                    <img src="{{asset('imgpremios/'.$c->rutaimagen)}}" class="rounded" alt="..."  width= "50px" height="50px" >
                  </div>
                </td>
                <td><a href="{{route('formactucat', $c->id)}}" type="button" class="btn btn-success"><i class="fas fa-edit"></i></a>
                    <a href="#" type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                </td>
                </tr>

             @endforeach
              @else
                  <div class="alert alert-warning text-center letraform" role="alert">
                    No Hay Registros
                  </div>
              @endif
           
            </tbody>
          </table>

        <!--end tabla-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn salir" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

@endsection