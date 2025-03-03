@extends('usuario.principa_usul')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">
      <h1 class="m-0">Métricas del grupo: {{$grupo->descripcion}} </h1>
      <p class="m-0">Seguimiento del desempeño y participación de los colaboradores en el grupo.</p>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Métricas del grupo</li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>

<div class="container">

<div class="row">
		<div class="col-lg-3 col-12">
			<div class="row">
            <div class="col-12">

					<!-- small box -->
					<div class="small-box bg-success">
						<div class="inner">
							<p class="m-0">Categoría más activa:</p>
                            <p class="m-0">"Participar" con</p>
							<h5>850 Puntos</h5>
                            
                            <div class="progress-group">

																		Avance

																		<span class="float-right"><b>15 |   71.4% </b></span><b>
																		<div class="progress progress-sm">
																			<div class="progress-bar bg-warning" style="width:   71.4% "></div>
																		</div>
																	</b></div>
                            
						</div>
						<div class="icon">
							<i class="ion ion-stats-bars"></i>
						</div>
						<a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
                <div class="col-12">
					<!-- small box -->
					<div class="small-box bg-danger">
						<div class="inner">
                            <p class="m-0">Categoría menos reconocida:</p>
                            <p class="m-0">"Aprender" con</p>
							<h5>50 Puntos</h5>
                            <div class="progress-group">

																		Avance

																		<span class="float-right"><b>15 |   71.4% </b></span><b>
																		<div class="progress progress-sm">
																			<div class="progress-bar bg-warning" style="width:   71.4% "></div>
																		</div>
																	</b></div>
						</div>
						<div class="icon">
							<i class="ion ion-stats-bars"></i>
						</div>
						<a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-12">
					<!-- small box -->
					<div class="small-box bg-warning">
						<div class="inner">
							<p class="m-0">Top Colaborador:  </p>
							<h5>Manuel Apellido</h5>
							<p class="m-0">con 450 puntos</p>
						</div>
						<div class="icon">
							<i class="ion ion-person-add"></i>
						</div>
						<a href="#" class="small-box-footer">¡Felicítalo! <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
			</div>
			<!-- /.row -->
		</div>
		<div class="col-lg-9 col-12">
			<!-- Gráficos -->
			<div class="row">
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
							<p>La evolución de los puntos del grupo en el tiempo.</p>
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
							<h3 class="card-title">¿Dónde brilla más tu equipo?:</h3>

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
							<p>Comparación del total de puntos de cada categoría.</p>

							<div class="chart-container">
								<canvas id="categoryChart-grupo"></canvas>
							</div>
						</div>
						<!-- /.card-body -->
					</div>
				</div>
				
			</div>
            <div class="row">
  <div class="col-12">
  <div class="card">

                    <div class="card-body">
   <!--tabla para ver los valores-->
   @if(Session::has('exito'))
        <div id="exito-alert" class="alert alert-info alert-dismissible fade show letraform" role="alert">
        <strong>{{Session::get('exito')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    @endif
   <div class="container mt-5 letraform">
   @foreach($cate as $cat)
        @php
            $totalPuntos = isset($puntaje[$cat->id]) ? $puntaje[$cat->id] : 0;
            $anchoBarra = ($totalPuntos * 100) / 2000;
        @endphp
        <li class="mt-2">Categoría: {{ $cat->descripcion }}, Total de puntos: {{ $totalPuntos }}</li>
       <div class="progress mt-2">
          <div class="progress-bar bg-success" style="width: {{ $anchoBarra }}%">{{ $anchoBarra }} %</div>
        </div>
    @endforeach
    <div class="row table-responsive letraform">
    <table class="table table-hover table-estadisticas">
    <thead>
        <tr>
            <th scope="col">Colaborador</th>
            <th scope="col">Categoría</th>
            <th scope="col"  style="witdh: 100px !important;" class="text-center">Total de puntos</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($totusu as $idUsuario => $puntosPorCategoria)
            <tr>
                <td rowspan="{{ count($puntosPorCategoria) }}">
                    @foreach($users as $us)
                       @if($idUsuario == $us->id) 
                         {{$us->name}}  {{$us->apellido}}
                       @endif
                    @endforeach
                </td>
                @foreach ($puntosPorCategoria as $idCategoria => $totalPuntos)
                    @if ($loop->index != 0)
                        <tr>
                    @endif
                    <td>
                    @foreach($cate as $c)
                        @if($c->id == $idCategoria)
                           {{ $c->descripcion }}
                        @endif
                    @endforeach
                    </td>
                    <td style="witdh: 100px !important;" class="text-center">{{ $totalPuntos }}</td>
                    @if ($loop->index != 0)
                        </tr>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>


        <!--=================--->
      </div>
     
    </div>
   </div>
   </div>
   </div>
   </div>

		</div>
		<!-- /.row -->
	</div>


   </div>
   </div>
<!--end tabla-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



@endsection