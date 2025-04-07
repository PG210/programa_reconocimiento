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
              <!--primer valor-->
              @if($cate->first())
                @php
                    //validar la division por cero y limitar el porcentaje al 100 por ciento, tambien el valor 2000 debe ser ajustable en categorias
                    $widbarra = min(100, ($cate->first()->ptotal * 100) / max(2000, 1));
                @endphp
                <p class="m-0">Categoría más activa:</p>
                <p class="m-0">" {{ $cate->first()->nomcat }} " con</p>
                <h5>{{ $cate->first()->ptotal }} Puntos</h5>
                <div class="progress-group">
                  Avance
                  <span class="float-right"><b> {{ $cate->first()->ptotal }}  | {{ $widbarra }}% </b></span>
                  <div class="progress progress-sm">
                  <div class="progress-bar bg-warning" style="width: {{ $widbarra }}% "></div>
                  </div>
                </div> 
              @else
                <p class="m-0">Aún no hay una categoría destacada.</p>
              @endif          
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
            @if($cate->last())
              @php
                  //validar la division por cero y limitar el porcentaje al 100 por ciento, tambien el valor 2000 debe ser ajustable en categorias
                  $minbarra = min(100, ($cate->last()->ptotal * 100) / max(2000, 1));
              @endphp
              <p class="m-0">Categoría menos reconocida:</p>
              <p class="m-0">"{{ $cate->last()->nomcat }}" con</p>
							<h5>{{ $cate->last()->ptotal }} Puntos</h5>
              <div class="progress-group">
								Avance
                <span class="float-right"><b>{{ $cate->last()->ptotal }} |  {{ $minbarra }}% </b></span>
                <div class="progress progress-sm">
                  <div class="progress-bar bg-warning" style="width: {{ $minbarra }}% "></div>
                </div>
               </div>
            @else
               <p class="m-0">Aún no hay una categoría menos reconocida.</p>
            @endif 
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
            @if(isset($usupuntos))
							<p class="m-0">Top Colaborador:  </p>
							<h5>{{ $usupuntos->nomusu }} {{ $usupuntos->apeusu }}</h5>
							<p class="m-0"> {{ $usupuntos->ptotal }} puntos acumulados</p>
              <p class="m-0"> {{ $usupuntos->total }} reconocimientos recibidos</p>
						</div>
						<div class="icon">
							<i class="ion ion-person-add"></i>
						</div>
            <a href="#" class="small-box-footer">¡Felicítalo! <i class="fas fa-arrow-circle-right"></i></a>
            @else
              <p class="m-0">Aún no hay un colaborador destacado.</p>
            @endif
						
					</div>
				</div>
				<!-- ./col -->
			</div>
			<!-- /.row -->
		</div>
    
		<div class="col-lg-9 col-12">
			<!-- Gráficos -->
			<div class="row">
      @if(count($ptime) > 0)
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
      @endif

      @if(count($pcat) > 0)
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
			@endif	
			</div>
            <div class="row">
  <div class="col-12">
  <div class="card">

    <div class="card-body">
   <!--tabla para ver los valores-->
   <div class="container mt-5 letraform">
   @foreach($cate as $cat)
        @php
            //validar la division por cero y limitar el porcentaje al 100 por ciento, tambien el valor 2000 debe ser ajustable en categorias
            $anchoBarra = min(100, ($cat->ptotal * 100) / max(2000, 1));
        @endphp
        <li class="mt-2">Categoría: {{ $cat->nomcat }}, Total de puntos: {{ $cat->ptotal }}, Total de reconocimientos: {{ $cat->total }}</li>
        <div class="progress mt-2">
            <div class="progress-bar bg-success" style="width: {{ number_format($anchoBarra, 2) }}%">
                {{ number_format($anchoBarra, 1) }} %
            </div>
        </div>
    @endforeach
    <div class="row table-responsive letraform">
    <!---tabla mejorada --->
    <table class="table table-hover table-estadisticas">
        <thead>
            <tr>
                <th scope="col">Colaborador</th>
                <th scope="col">Categoría</th>
                <th scope="col">Reconocimientos obtenidos</th>
                <th scope="col">Puntaje</th>
            </tr>
        </thead>
        <tbody>
            @php $usuario_actual = null; @endphp
            @foreach ($datos as $dato)
                <tr>
                    @if ($usuario_actual !== $dato['idusu'])
                        <td rowspan="{{ collect($datos)->where('idusu', $dato['idusu'])->count() }}">
                            {{ $dato['nomusu'] }} {{ $dato['apeusu'] }}
                        </td>
                        @php $usuario_actual = $dato['idusu']; @endphp
                    @endif
                    <td>{{ $dato['nomcat'] }}</td>
                    <td>{{ $dato['total'] }}</td>
                    <td>{{ $dato['ptotal'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!--=======end tabla==========--->
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
<script>
  window.recmes = @JSON($ptime);
  window.totcat = @JSON($pcat);
  window.label2 = "Cantidad de puntos";
</script>
@endsection