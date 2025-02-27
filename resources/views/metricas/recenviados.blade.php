@extends('usuario.principa_usul')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-9">
				<h1 class="m-0">Reconocimientos que Has Enviado</h1>
        <p>Cada reconocimiento fortalece el equipo. ¡Sigue motivando a tus compañeros! </p>
			</div>
			<!-- /.col -->
			<div class="col-sm-3">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item active">Reconocimientos enviados</li>
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
        <div class="card">
              
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong>🌟 Has enviado 12 reconocimientos este mes  </strong>
                    </p>

                    <div class="chart-container" style="height: 180px; width:100%;">
                      <canvas id="timelineChart"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <p class="text-center">
                      <strong>Csategorias</strong>
                    </p>

                    <div class="progress-group">
                      Participar
                      <span class="float-right"><b>160</b>/200</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 80%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group">
                      Aprender
                      <span class="float-right"><b>310</b>/400</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: 75%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              
            </div>
    <div class="card">

<div class="card-header">
  <div class="card-tools">
    <div class="" style="display: flex;justify-content: space-around;gap: 10px;">
      <div class="" style="width: 200px;">
        <input type="text" class="form-control" id="searchTerm" onkeyup="doSearch()" placeholder="Buscar...">
      </div>
    </div>
  </div>
</div>
<!-- /.card-header -->
<div class="">
  <div class="table-responsive">

  <table class="table table-hover table-estadisticas">
  <thead class="tablaheader">
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nombres</th>
      <th scope="col"></th>
      <!--<th scope="col">Fecha</th>-->
      <th scope="col">Categoría</th>
     <!-- <th scope="col">Comportamiento</th>-->
      <th scope="col">Detalle</th>
      <th scope="col">Peñutes</th>
    </tr>
  </thead>
  <tbody>
      <!--=====================-->
      @if(count($agrupados) != 0)
      @foreach ($agrupados as $iduser => $registros) 
      <tr>
        <th scope="row">{{ $loop->iteration }}</th>
        <td colspan="6">{{ $registros->first()->name }} {{ $registros->first()->apellido }}</td>
      </tr>
      @foreach ($registros as $info)
        <tr>
          <td colspan="3"></td> 
          <!--<td>{{ date('Y-m-d', strtotime($info->fecha)) }}</td>-->
          <td>{{ $info->cate }}</td>
          <!--<td>{{ $info->comportamiento }}</td>-->
          <td>{{ $info->detalle }}</td>
          <td>{{ $info->puntaje }}</td>
        </tr>
      @endforeach
    @endforeach
    @endif
    <!--====================-->   
     </tbody>
    </table>  <!--====================-->

    

  </div>

</div>
<!-- /.card-body -->
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

 
    </div>
  </div>
</div>
<!------###########################-->
@endsection
