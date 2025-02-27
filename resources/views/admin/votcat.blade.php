@extends('usuario.principa_usul') @section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">

        <h1 class="m-0">
      <a href="/admin/votacion" class="btn btn-default mr-2" type="button"  aria-controls="collapseOne">
         <i class="fas fa-home"></i> Regresar
      </a>
      Categoria: Participar</h1>
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

        <div class="card-header">
          Mostrar
          <select class="form-select" id="recordsPerPage" onchange="changeRows()">
                          <option value="5">5 registros</option>
                          <option value="10" selected>10 registros</option>
                          <option value="25">25 registros</option>
                          <option value="50">50 registros</option>
                        </select> registros por página
          <div class="card-tools">
            <div class="" style="display: flex;justify-content: space-around;gap: 10px;">
              <div class="" style="width: 200px;">
                <input class="form-control mr-sm-4" type="text" id="search" placeholder="Buscar por nombres...">
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="px-3">
          <!--table-->
          <div class="table-responsive">
            <table class="table table-hover table-estadisticas">
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
                    $conta=1;
                ?>
                  @foreach($cat as $c) @if(isset($c->categoria))
                  <tr>
                    <th scope="row">{{$conta++}}</th>
                    <td>{{$c->anio}} - {{$c->periodo}}</td>
                    <td>
                      @if($c->imagen==NULL)
                      <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                        <div class="image">
                          <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
                        </div>
                      </div>
                      @endif @if($c->imagen!=NULL)
                      <!--imagen-->
                      <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                        <div class="image">
                          <img src="{{asset('dist/imgperfil/'.$c->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width">
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
                  @endif @endforeach
              </tbody>
            </table>
          </div>
          <!--end table-->
        </div>


        <div class="card-footer clearfix">
          <div class="row">
            <div class="col-sm-12 col-md-7">
              <div class="dataTables_info">Showing 1 to 10 of 57 entries</div>
            </div>
            <div class="col-sm-12 col-md-5">
              <div class="">
                <ul class="pagination m-0">
                  <li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                  <li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                  <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                  <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                  <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
                  <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0" class="page-link">5</a></li>
                  <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li>
                  <li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /.container-fluid -->

@endsection