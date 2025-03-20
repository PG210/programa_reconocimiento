@extends('usuario.principa_usul')
@section('content')
  @include('usuario.datatables')

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">
      <h1 class="m-0">Registro de Categorías</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item active">Registro de Categorías</li>
      </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <div class="container">
    <div class="row">
    <div class="col-12">
      @if(Session::has('mensaje'))
        <div class="alert alert-warning alert-dismissible fade show letraform mb-2" role="alert">
        <strong>{{Session::get('mensaje')}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
      @endif
      <!--===============================================-->

      <div class="card">
      <div class="card-header">
        <div class="btn-group" role="group" aria-label="Basic outlined example">
        <button type="button" class="btn btn-primary confirmar letraform" data-toggle="modal"
          data-target="#staticBackdrop">Agregar</button>
        <a href="{{route('reg_insignia')}}" type="button" style="color: var(--dark);"
          class="btn btn-warning botonmorado">Comportamientos</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="px-3">
        <!--=================================================================---->
        <div class="table-responsive letraform mt-3 mb-3">
        <table class="table table-hover table-estadisticas" id="table01">
          <thead class="colortablas">
          <tr>
            <th scope="col" class="text-center" style="width: 50px">No</th>
            <th scope="col">Descripción</th>
            <th scope="col">Imagen</th>
            <th scope="col" class="text-center" style="width: 100px">Acción</th>
          </tr>
          </thead>
          <tbody>
          @foreach($dat as $c)
            <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$c->descripcion}}</td>
            <td>
            <div class="text-center">
              <img src="{{asset('imgpremios/' . $c->rutaimagen)}}" class="rounded zoomable" alt="..." width="50px"
              height="50px">
            </div>
            </td>
            <td>
            <!--=========Actualizar============--->
            <!-- Button trigger modal -->
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
              <a type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
              data-target="#actualizar{{$c->id}}"><i class="fas fa-edit"></i></a>
              <!-- Colocar una ventana modal que pregunte si esta seguro de eliminar-->
              <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal"
              data-target="#eliminarCat{{$c->id}}">
              <i class="fas fa-trash-alt"></i>
              </button>
            </div>
            <!---modal eliminar categoria---->
            <!--==========================-->
            <div class="modal fade" id="eliminarCat{{$c->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
              <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body text-left">
              <p>
                ¿Seguro que quieres eliminar la categoría "{{$c->descripcion}}"?
              </p>
              </div>
              <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <form action="{{ route('eliminarcat') }}" method="POST">
                @csrf
                <input type="hidden" name="idcat" id="idcat{{$c->id}}" value="{{$c->id}}">
                <button type="submit" class="btn btn-success">Eliminar</button>
              </form>
              </div>
              </div>
              </div>
            </div>
            <!--========================================-->
            <!-- Modal -->
            <div class="modal fade" id="actualizar{{$c->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
              <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Actualizar Categoría</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <form method="POST" action="{{route('guarcategoria', $c->id)}}" class="letraform"
              enctype="multipart/form-data">
              <div class="modal-body">
                <p>Modifica los detalles de la categoría para mantenerla actualizada.</p>
                <!---datos-->
                @csrf
                <div class="form-group">
                <label for="nombre">Nombre</label>
                <p>Edita el nombre de la categoría.</p>
                <input type="text" class="form-control" id="des" name="des" value="{{$c->descripcion}}">
                </div>
                <div class="form-group">
                <label for="puntos">Imagen</label>
                <p>Cambia o actualiza la imagen representativa.</p>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                </div>
                <!---end datos-->
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default salir" data-dismiss="modal">Salir</button>
                <button type="submit" class="btn btn-success confirmar">Guardar</button>
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

      </div>
      </div>
      <!-- /.card-body -->
      <!--=================================================================-->
      <!-- Modal -->
      <div class="modal fade letraform" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
          <p>Crea y personaliza nuevas categorías para los reconocimientos.</p>
          @csrf
          <div class="form-row letraform">
            <div class="form-group col-md-12">
            <label for="descrip">Nombre</label>
            <p>Ingresa el nombre de la categoría.</p>
            <input type="text" class="form-control" id="descrip" name="descrip" required>
            </div>
            <!-- <div class="form-group col-md-6">
          <label for="puntos">Puntos</label>
          <input type="number" class="form-control" id="puntos" name="puntos" required>
        </div>-->
            <div class="form-group col-md-12">
            <label for="puntos">Imagen</label>
            <p>Sube una imagen representativa para esta categoría.</p>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
            </div>
          </div>
          <!--end tabla-->
          </div>
          <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default salir" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success confirmar">Guardar</button>
          </div>
        </form>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!--instanciar el ajax para quitar el error no definido-->
  <style>
    .zoomable {
    transition: transform 0.2s;
    /* Agrega una transición suave */
    }

    .zoomable:hover {
    transform: scale(3.3);
    /* Aplica un aumento de escala al pasar el ratón */
    }
  </style>
  <script>
    $('#table01').DataTable({
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
    },
    });
  </script>
@endsection