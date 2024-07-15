@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert">
 <h3>REGISTRO DE COMPORTAMIENTOS</h3>
</div>
<div class="btn-group mb-2" role="group" aria-label="Basic outlined example">
  <a href="/Categorias/registro"  type="button" class="btn float-right salir"><i class="fas fa-arrow-left"></i></a>
  <button type="button"  class="btn confirmar letraform" data-toggle="modal" data-target="#visualizarmodal">Agregar</button>
</div>  

  <!--tabla para ver los valores-->
  <table class="table letraform">
      <thead class="tablaheader">
      <tr>
        <th scope="col">No</th>
        <th scope="col">Comportamiento</th>
        <th scope="col">Categoria</th>
        <th scope="col">Puntos</th>
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
                  <td>{{$c->puntos}}</td>
                  <td>
                    <!--=======================--->
                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <a type="button" class="btn btn-success" data-toggle="modal" data-target="#actualizarcom{{$c->id}}">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{route('deleteCom', $c->id)}}" type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                    </div>
                     <!-- Button trigger modal -->
                    <!-- Modal -->
                    <div class="modal fade" id="actualizarcom{{$c->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Actualizar Comportamiento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form  method="POST" action ="{{route('actualizarcat', $c->id)}}" enctype="multipart/form-data" class="letraform">
                          <div class="modal-body">
                            <!--============== aqui info-->
                             @csrf
                              <div class="form-group">
                                  <label for="nombrenew">Nombre</label>
                                  <textarea class="form-control" id="nombrenew" name="nombrenew" rows="3" required>{{$c->nombre}}</textarea>
                                </div>
                                <div class="form-group">
                                  <label for="comnew">Comportamiento</label>
                                  <select class="form-control" id="comnew" name="comnew" required>
                                  <option selected value="{{$c->id_comportamiento}}">{{$c->compor}}</option>
                                    @foreach($dat as $co)
                                     @if($co->id != $c->id_comportamiento)
                                      <option value="{{$co->id}}">{{$co->descripcion}}</option>
                                     @endif
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group">
                                  <div class="row">
                                      <div class="col-lg-12 col-md-12">
                                       <label for="puntosnew">Puntos</label>
                                       <input type="number" class="form-control" id="puntosnew" name="puntosnew" value="{{$c->puntos}}" min="0" required>
                                      </div>
                                  </div>
                                </div>
                                
                            <!--=====================--->
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn salir" data-dismiss="modal">Salir</button>
                            <button type="submit" class="btn confirmar">Guardar</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!--=========================-->
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
      <form action="{{route('reginsignias')}}" method="POST"  enctype="multipart/form-data" class="letraform">
      <div class="modal-body">
      <!--========================================-->
        @csrf
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="nombre">Nombre</label>
            <textarea class="form-control" id="nombre" name="nombre" rows="3" required></textarea>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="scompor">Categoría</label>
            <select id="scompor" name="scompor" class="form-control" required>
              <!--<option selected>Elegir opción</option>-->
              @foreach($dat as $c)
              <option value="{{$c->id}}">{{$c->descripcion}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="puntos">Puntos</label>
            <input type="number" class="form-control" id="puntos" name="puntos"  min="0" required>
          </div>
        </div>
      <!--========================================-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn salir" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn confirmar">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection