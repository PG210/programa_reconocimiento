@extends('usuario.principa_usul') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h1 class="m-0">Reconocimientos Enviados: Impacto y Tendencias</h1> Analiza cómo se fortalece la cultura de reconocimiento en tu equipo y motiva su crecimiento. 🚀
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Rec. Envíados</li>
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
    <div class="col-md-12">
      <!---filtros de busqueda -->
      <!---filtros de busqueda -->
      <!---filtros de busqueda -->

      <form action="{{route('filterReconocimientoEnviadoTotal')}}" method="POST">
        @csrf
        <div class="form-group row m-0" style="display: flex;align-items: center;">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha inicial y final</label>
          <div class="col-sm-10 filtro-fecha">
            <input type="date" aria-label="First name" class="form-control" name="fecini" id="fecini" max="{{ $fecha }}" value="{{ $fecini }}" required>
            <input type="date" aria-label="Last name" class="form-control" name="fecfin" id="fecfin" max="{{ $fecha }}" value="{{ $fecfin }}" required>
            <button class="btn btn-primary" role="button" type="submit"> <i class="fas fa-search"></i></button>
          </div>

        </div>
      </form>

      <!--end filtros-->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container-fluid -->

<div class="container">
  <div class="row">
    <div class="col-lg-3 col-12">
      <div class="row">
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <p class="m-0">En este periodo, </p>
              <h5>Manuel Apellido</h5>
              <p class="m-0">ha envíado más reconocimientos que nadie.</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">¡Felicítalo! <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <p class="m-0">Categoría más movida: </p>
              <h5>Empatía y vocación de servicio. </h5>
              <p class="m-0">Tus colaboradores valoran más esta actitud. ¿Cómo podemos impulsar otras competencias?</p>

            </div>
            <div class="icon">
              <i class="fas fas fa-trophy"></i>
            </div>
            <a href="#" class="small-box-footer">Ver más información <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <p class="m-0">Parece que </p>
              <h5>Manuel Apellido</h5>
              <p class="m-0">No ha envíado reconocimientos. ¿Tal vez necesite un pequeño empujon?</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">Envíar mensaje <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>+15%</h3>
              <p class="m-0">En este periodo, el reconocimiento en la empresa ha crecido un +15% comparado con el anterior.”</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
    </div>
    <div class="col-lg-9 col-12">
      <!-- Gráficos -->
      <div class="row mb-4">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Línea de Tiempo:</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
              </div>
            </div>
            <div class="card-body">
              <p>La evolución del envío de reconocimientos en tu equipo.</p>
              <div class="chart-container">
                <canvas id="trendChart"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>

        </div>
        <div class="col-md-6">

          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">¿Dónde están reconociendo más tu equipo?</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
              </div>
            </div>
            <div class="card-body">
              <p>Descubre qué aspectos valoran más tus colaboradores.</p>

              <div class="chart-container">
                <canvas id="categoryChart-grupo"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Equilibrio en la Cultura:</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
              </div>
            </div>
            <div class="card-body">
              <p>¿Cómo se distribuyen los reconocimientos?</p>

              <div class="chart-container" style="height: 280px;">
                <canvas id="radarChart"> </canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>

        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Momentos de Reconocimiento:</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
              </div>
            </div>
            <div class="card-body">
              <p>Descubre cuándo se genera más impacto.</p>

              <b id="mostActiveDay" class="text-center mt-3"></b>

              <!-- Gráficos -->
              <div class="chart-container">
                <canvas id="heatmapChart"></canvas>
              </div>
              <div class="legend-mapa">
                <span style="background-color: #439A86;"></span> Bajo
                <span style="background-color: #EBB93B; margin-left: 10px;"></span> Medio
                <span style="background-color: #DB636B; margin-left: 10px;"></span> Alto
              </div>

            </div>
            <!-- /.card-body -->
          </div>

        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container-fluid -->
<div class="container">
  <div class="row mb-3">




    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
              <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="pt-2 px-3">
                  <h3 class="card-title">Consulta:</h3></li>
                <li class="nav-item">
                  <a class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                      Reconocimientos envíados
                    </a>
                </li>
                <li class="pt-2 px-3">

                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                  <!-- Acciones Rápidas del Administrador -->
                  <div class="card p-4 mb-2">
                    <h4 class="card-title" style="color: #716f6e;font-size: 1.5rem;font-weight: 600;">Reconocimientos que se han enviado</h4>
                    <p>⚡ Acciones Rápidas para Impulsar la Participación</p>
                    <div class="row text-center">
                      <div class="col-md-4">
                        <button class="btn btn-primary w-100 mb-2">📢 Enviar Recordatorios</button>
                        <p class="small m-0">Notificar a los equipos con baja participación.</p>
                      </div>
                      <div class="col-md-4">
                        <button class="btn btn-success w-100 mb-2">📊 Ver Tendencias por Equipo</button>
                        <p class="small m-0">Analizar qué equipos están participando más.</p>
                      </div>
                      <div class="col-md-4">
                        <form action="{{route('downloadgive')}}" method="POST">
                          @csrf
                          <input type="date" aria-label="First name" class="form-control" name="fecinifil" id="fecinifil" max="{{ $fecha }}" value="{{ $fecini }}" hidden>
                          <input type="date" aria-label="Last name" class="form-control" name="fecfinfil" id="fecfinfil" max="{{ $fecha }}" value="{{ $fecfin }}" hidden>
                          <button type="submit" class="btn btn-warning w-100 mb-2" data-toggle="tooltip" data-placement="top" title="Generar reporte en Excel.">
                            📁 Generar Reportes
                          </button>
                        </form>
                        <p class="small m-0">Descargar datos clave en Excel/PDF.</p>
                      </div>
                    </div>
                  </div>
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
                            <input type="text" class="form-control" id="searchTerm" onkeyup="doSearch()" placeholder="Buscar...">
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="">
                      <div class="table-responsive">
                        <table class="table table-hover table-estadisticas" id="tablaDate">
                          <thead class="tablaheader">
                            <tr>
                              <th scope="col">No</th>
                              <th scope="col">Nombres</th>
                              <th scope="col">Primer reconocimiento</th>
                              <th scope="col">Ultimo reconocimiento</th>

                              @foreach($categoria as $cat)
                              <th scope="col">{{$cat->descripcion}}</th>
                              @endforeach
                              <th scope="col">Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!--=========================-->
                            <?php
                              $contador = 0;
                            ?>
                              @if(count($recibidos) > 0) @foreach ($recibidos as $conjuntoUsuarios) @if (!empty($conjuntoUsuarios)) @foreach ($conjuntoUsuarios as $usuario)
                              <tr>
                                <th scope="row">{{ $contador+=1 }}</th>
                                <td>{{ $usuario->nombre }} {{ $usuario->ape }}</td>
                                <td>{{ $usuario->fecmin ?? '--' }} </td>
                                <td>{{ $usuario->fecmax ?? '--' }} </td>

                                @foreach($categoria as $cate)
                                <td>
                                  <div class="progress-group">
                                    Total por categoría
                                    <span class="float-right"><b>{{ $usuario->{'c' . $cate->id} ?? 0 }} |  @if($usuario->tot != 0) {{round($usuario->{'c' . $cate->id}*100/$usuario->tot, 1)}}% @else 0%  @endif</b></span>
                                    <div class="progress progress-sm">
                                      <div class="progress-bar bg-success" style="width:@if($usuario->tot != 0) {{round($usuario->{'c' . $cate->id}*100/$usuario->tot, 1)}}% @else 0%  @endif"></div>
                                    </div>
                                  </div>
                                </td>
                                @endforeach
                                <td>
                                  <b>{{ $usuario->tot ?? 0 }} <!--| @if($usuario->tot != 0) 100% @else 0% @endif--></b>
                                </td>
                              </tr>
                              @endforeach @endif @endforeach @endif
                              <tr class='noSearch hide'>
                                <td colspan="3"></td>
                              </tr>
                              <!--====================-->
                          </tbody>
                        </table>

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
                <!--======================================-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>

<!--==========================================-->
<script src="{{ asset('js/buscador.js')}}"></script>
<script src="{{ asset('js/buscador_2.js')}}"></script>
<script>
  document.getElementById('fecini').addEventListener('change', function() {
  			              var fecini = document.getElementById('fecini').value;
  			              document.getElementById('fecfin').min = fecini;
  			   });
  			
  <!------###########################-->
     document.getElementById('fecini').addEventListener('change', function() {
                var fecini = document.getElementById('fecini').value;
                document.getElementById('fecfin').min = fecini;
     });
  
</script>
@endsection