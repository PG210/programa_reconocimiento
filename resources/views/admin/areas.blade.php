@extends('usuario.principa_usul')
@section('content')
@include('usuario.datatables')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h1 class="m-0">Configuración de la empresa</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Empresa</li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@if(Auth::user()->superadmin != 0)
  <!---licencias-->
  <div class="container">
    <form action="{{route('reglicencias')}}" method="post">
    @csrf
    <div class="row mb-3">

      <div class="col-lg-4 col-12">
      <div class="col-12">
        <!-- small box -->
        <div class="small-box bg-warning">
        <div class="inner">
          <p class="m-0">Licencias</p>

          @if(isset($licencias->numlicencia))
            <h5>{{$totaluser}} / {{ $licencias->numlicencia }}</h5>
            <p class="m-0"><b>{{ $licencias->numlicencia - $totaluser }}</b> Licencias disponibles.</p>
          @endif
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
          <a href="#" class="small-box-footer">Comprar más <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      </div>
      <div class="col-lg-8 col-12">
      <div class="card p-4 mb-2">
        <div class="form-row" style="align-items: flex-end;">
        <div class="form-group col-md-3">
          <label for="inputPassword4">Ocupadas</label>
          <input type="number" min="0" value="{{$totaluser}}" class="form-control" id="ocupadas" name="ocupadas"
          readonly>
        </div>
        <div class="form-group col-md-3">
          <label for="inputEmail4">Asignadas</label>
          <input type="number" min="{{$totaluser}}" value="{{ $licencias->numlicencia ?? '' }}" class="form-control"
          id="asig" name="asig" required>
        </div>
        <div class="form-group col-md-3">
          <label for="vencimiento">Vencimiento </label>
          <input type="date" class="form-control" min="{{$date}}"
          value="{{ \Carbon\Carbon::parse($licencias->vencimiento ?? '')->format('Y-m-d') }}" id="vencimiento"
          name="vencimiento" required>
        </div>
        <div class="form-group col-md-3 mt-4">
          <button type="submit" class="btn btn-primary w-100">Modificar</button>
        </div>
        </div>
    </form>
  </div>
  </div>
  </div>
  </div>
  <!-- end licencias -->
@endif

<!--##################--->
@if(Session::has('mensaje'))
<div class="alert alert-info alert-dismissible fade show letraform" role="alert">
  <strong>{{Session::get('mensaje')}}</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
@if(Session::has('mensajeerror'))
<div class="alert alert-danger alert-dismissible fade show letraform" role="alert">
  <strong>{{Session::get('mensajeerror')}}</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<div class="container">
  <div class="row mb-2">
    <div class="col-12">

      <div class="card">

        <div class="card-header">
          <!---- buttons group -->
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn" data-toggle="modal" data-target="#staticBackdrop"
              style="background-color:#5959D1; color:#FFF;">
              <i class="fas fa-pen-alt"></i>&nbsp;Areas
            </button>
            <a type="button" href="{{route('vistacargo')}}" class="btn" style="background-color:#FFBD03; color:#FFF;">
              <i class="fas fa-pen-alt"></i>&nbsp;Cargos</a>
            <a type="button" href="{{route('vincular_jefes')}}" class="btn btn-info" style="color:white;"><i
                class="fas fa-users"></i>&nbsp;Vincular Jefes</a>
          </div>
          <!--- end buttons group---->
        </div>
        <!-- /.card-header -->
        <div class="px-3 mt-3 mb-3">
          <div class="table-responsive">
            <table class="table table-hover table-estadisticas" id="dataTable01">
              <thead class="tablaheader">
                <tr>
                  <th scope="col" class="text-center" style="width: 100px">No.</th>
                  <th scope="col" class="text-center" style="width: 100px">ID interno</th>
                  <th scope="col">Área</th>
                  <th scope="col" class="text-center" style="width: 100px">Acción</th>
                </tr>
              </thead>
              <tbody>
                @foreach($areas as $area)
                  <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-center">{{$area->id}}</td>
                    <td>{{$area->nombre}}</td>
                    <td class="text-center">
                    <!-- Colocar una ventana modal que pregunte si esta seguro de eliminar la área-->
                  
                    <!---modal-->
                    <div class="btn-group">
                      <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#eliminarArea{{$area->id}}">
                          <i class="fas fa-trash-alt"></i>
                      </button>
                    </div>
                      <!--==========================-->
                      <div class="modal fade" id="eliminarArea{{$area->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                               ¿Seguro que quieres eliminar el área "{{$area->nombre}}"?
                               </p>
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <form action="{{ route('deleteArea') }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="idarea" id="idarea{{ $area->id }}" value="{{ $area->id }}">
                                  <button type="submit" class="btn btn-success">Eliminar</button>
                              </form>  
                            </div>
                            </div>
                        </div>
                        </div>
                    <!--========================================-->
                    <!--end modal -->
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>


<div class="container row letraform">

</div>
<div class="row">
  <div class="col-md-12">
    <!-- Modal -->
    <form action="{{route('guardararea')}}" method="post">
      @csrf
      <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header titulo">
              <h5 class="modal-title" id="staticBackdropLabel">Adicionar una nueva área</h5>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body letraform">
              <p>Escriba la área de la empresa que desea crear en el sistema</p>
              <!--##############-->

              <div class="form-row">
                <div class="col">
                  <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
              </div>
              <!----############--->
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default salir" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-success confirmar">Adicionar</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $('#dataTable01').DataTable({
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
    },
  });
</script>
@endsection