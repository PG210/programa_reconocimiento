@extends('usuario.principa_usul')
@section('content')
  @include('usuario.datatables')


  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">
      <h1 class="m-0"><a href="/areas/empresa" class="btn salir btn-default">&nbsp;&nbsp;Volver</a> Edición de Jefes
      </h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="#">Empresa</a></li>
        <li class="breadcrumb-item active">Edición de Jefes</li>
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
    <div class="row mb-2">
    <div class="col-12">

      <div class="card">

      <!-- /.card-header -->
      <div class="px-3">

        @if(Session::has('jefe'))
          <br>
          <div class="alert alert-dismissible fade show letraform" role="alert" style="background-color:#1ED5F4;">
          <strong>{{Session::get('jefe')}}</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
        @endif
        @if(Session::has('vincu'))
          <br>
          <div class="alert alert-dismissible fade show letraform" role="alert" style="background-color:#EC4857;">
          <strong>{{Session::get('vincu')}}</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
        @endif
        @if(Session::has('regis'))
          <br>
          <div class="alert alert-dismissible fade show letraform" role="alert" style="background-color:#1ED5F4;">
          <strong>{{Session::get('regis')}}</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
        @endif

        <div class="table-responsive mt-3">
        <table class="table table-hover table-estadisticas" id="dataTable01">
          <thead class="tablaheader">
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Email</th>
            <th scope="col">Rol</th>
            <th scope="col">Cargo</th>
            <th scope="col">Area</th>
            <th scope="col" class="text-center" style="width: 100px">Acción</th>
          </tr>
          </thead>
          <tbody>
     
          @foreach($lista as $c)
          <tr>
          <th scope="row">{{$loop->iteration}}</th>
          <td>{{$c->name}}</td>
          <td>{{$c->apellido}}</td>
          <td>{{$c->email}}</td>
          <td>{{$c->rol}}</td>
          <td>{{$c->nomcar}}</td>
          <td>{{$c->nomarea}}</td>
          <td class="text-center">
          <!-- Colocar una ventana modal que pregunte si esta seguro de eliminar la área-->
          <div class="btn-group">
            <!--#######################################3-->
            <a type="button" data-toggle="modal" data-target="#cambiarPro{{$c->id}}" data-placement="bottom"
            title="Editar" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></a>
            <a type="button" data-toggle="modal" data-target="#staticBackdrop{{$c->id}}"
            class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></a>
            <!-- Ventana modal para deshabilitar -->
            <form action="{{route('vinjefes')}}" method="POST" class="letraform">
                @csrf
                <div class="modal fade text-left" id="cambiarPro{{ $c->id }}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                  <h4 class="modal-title ">
                    Vincular a <span>{{ $c->name }} {{ $c->apellido }}</span> con un jefe
                  </h4>
                  </div>
                  <div class="modal-body mt-2 ">
                  <p>Asigna un líder para mejorar el seguimiento y reconocimiento de su desempeño.</p>
                  <strong style="text-align: center !important">
                  <!--select-->
                  <div class="form-group">
                  <select class="form-control" id="idreporta" name="idreporta">
                    <option value="elegir" selected>Elegir jefe...</option>
                    @foreach($lista as $a)
                        @if($c->name != $a->name && $c->id != $a->id)
                          <option value="{{$a->id}}">{{$a->name}} {{$a->apellido}}</option>
                        @endif
                    @endforeach
                  </select>
                  </div>
                  <!--end select--->
                  </strong>
                  </div>
                  <input type="text" name="idjefe" value="{{$c->id}}" hidden>
                  <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default salir" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-success confirmar">Seleccionar</button>
                  </div>
                </div>
                </div>
                </div>
            </form>
            <!---fin ventana deshabilitar--->
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop{{$c->id}}" data-backdrop="static" data-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Jefes Vinculados para: <span>{{$c->name}}
              {{$c->apellido}} </span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!----table--->
              <div class="table-responsive">
              <table class="table table-hover table-estadisticas">
              <thead class="tablaheader">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Cargo</th>
                <th scope="col">Area</th>
                <th scope="col">Acciones</th>
              </tr>
              </thead>
              <tbody>
              @if(isset($jefes))
                @foreach($jefes as $j)
                    @if($c->id == $j->id_jefe)
                    <tr>
                      <td> {{$loop->iteration}}</td>
                      <td> {{$j->nomjef}}</td>
                      <td> {{$j->apejef}}</td>
                      <td> {{$j->nomcar}}</td>
                      <td> {{$j->nomarea}}</td>
                      <td> <a href="/eliminar/jefes/{{$j->idjefes}}" class="btn"
                      style="background-color:#EC4857;"><i class="fas fa-trash-restore-alt"
                      style="background-color:white;"></i></a></td>
                    </tr>
                    @endif
                @endforeach
              @endif

              </tbody>
              </table>
              </div>
              <!---end table-->
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default salir" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
            </div>
            </div>
            <!---#######################################-->
          </div>
          </td>
          </tr>
           @endforeach
          </tbody>
        </table>
        </div>
      </div>
      <!--###########################--->

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

  </div>
  <script>
    $('#dataTable01').DataTable({
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
    },
    });
  </script>
@endsection