@extends('usuario.principa_usul')
@section('content')

  @include('usuario.datatables')

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">

      <h1 class="m-0">
        <a href="/admin/votacion" class="btn btn-default mr-2" type="button" aria-controls="collapseOne">
        <i class="fas fa-home"></i> Regresar
        </a>
        Categoria: @if(isset($nomcat->descripcion)) {{ $nomcat->descripcion }} @endif
      </h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item active">Categoria de votación</li>
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
      <div class="px-3 mt-5 mb-2">
        <!--table-->
        <div class="table-responsive">
        <table class="table table-hover table-estadisticas" id="votacion">
          <thead class="tablaheader">
          <tr>
            <th scope="col">No</th>
            <th scope="col">Periodo</th>
            <th scope="col">Imagen </th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Cargo</th>
            <th scope="col">Area</th>
            <th scope="col">Votos</th>
          </tr>
          </thead>
          <tbody>
          <?php
            $conta = 1;
          ?>
          @foreach($cat as $c) @if(isset($c->categoria))
      <tr>
      <th scope="row">{{$conta++}}</th>
      <td>{{$c->anio}} - {{$c->periodo}}</td>
      <td>
      @if($c->imagen == NULL)
        <div class="user-panel mt-0 pb-0 mb-0 d-flex">
        <div class="image">
        <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1"
        alt="User Image" style="padding-bottom:2px;">
        </div>
        </div>
      @endif 
      @if($c->imagen != NULL)
        <!--imagen-->
        <div class="user-panel mt-0 pb-0 mb-0 d-flex">
        <div class="image">
        <img src="{{asset('dist/imgperfil/' . $c->imagen)}}" class="img-circle elevation-1"
        alt="User Image" style="padding-bottom:2px; width">
        </div>
        </div>
      @endif
      </td>
      <td>{{$c->name}}</td>
      <td>{{$c->apellido}}</td>
      <td>{{$c->nomcar}}</td>
      <td>{{$c->areanom}}</td>
      <td>{{$c->total}}</td>
      </tr>
      @endif 
      @endforeach
          </tbody>
        </table>
        </div>
        <!--end table-->
      </div>


      </div>
      <!-- /.card-body -->
    </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->

  <script>
    $('#votacion').DataTable({
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
    },
    });
  </script>

@endsection