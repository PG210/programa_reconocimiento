@extends('usuario.principa_usul') 
@section('content')

@include('usuario.datatables')

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-8">
				<h1 class="m-0">Impacto del Reconocimiento en Tu Equipo</h1> Descubre cómo avanza la cultura de reconocimiento en tu equipo y toma acciones para fortalecerla.🚀
			</div>
			<!-- /.col -->
			<div class="col-sm-4">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item active">Rec. Obtenidos</li>
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

			<form action="{{route('filterReconocimientoTotal')}}" method="POST">
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
						@if (!empty($hightpeople->name))
							<p class="m-0">En este periodo, </p>
							<h5>{{ $hightpeople->name }} {{ $hightpeople->apellido }}</h5>
							<p class="m-0">ha recibido más reconocimientos que nadie.</p>
						@else
							<p class="m-0">En este periodo, ninguno de tus colaboradores ha recibido reconocimientos.</p>
						@endif
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
						@if (!empty( $hightcat->des ))
							<p class="m-0">Categoría con Más Reconocimientos: </p>
							<h5>
							   {{ $hightcat->des }} 
							</h5>
							<p class="m-0">Tus colaboradores valoran esta actitud. ¿Cómo podemos impulsar otras competencias?</p>
						@else
						    <p class="m-0">En este periodo, aún no hay una categoría destacada en reconocimientos.</p>
						@endif
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
							<!--dropdown-->
							@if ($userstot->isNotEmpty())
								<p class="m-0">Parece que </p>
								<h5>{{ $userstot->first()->name }} {{ $userstot->first()->apellido }}</h5>
                                <h6>
									<a class="" data-toggle="collapse" href="#collapseUsers" role="button" aria-expanded="false" aria-controls="collapseUsers">
										Ver más <i class="fas fa-plus"></i>
									</a>
								</h6>
								<div class="collapse" id="collapseUsers">
									<div class="">
										<ul class="list-group list-group-flush">
										  @foreach ($userstot->skip(1) as $utot)
											<li class="list-item"> <h5>{{ $utot->name }} {{ $utot->apellido }}</h5></li>
										   @endforeach
										</ul>
									</div>
								</div>
								<!--end dropdown-->
							<p class="m-0">ha recibido pocos reconocimientos. ¿Tal vez necesite más apoyo o visibilidad en su trabajo?</p>
							@else
								<p class="m-0">No hay usuarios para mostrar en este periodo.</p>
							@endif
						</div>
						<div class="icon">
							<i class="ion ion-stats-bars"></i>
						</div>
						<a href="#" class="small-box-footer">Envíar reconocimientos <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->

				<div class="col-12">
					<!-- small box -->
					<div class="small-box bg-danger">
						<div class="inner">
							@if (isset($increment))
							<h3>{{ $increment }}%</h3>
							<p class="m-0">En este periodo, el reconocimiento en la empresa ha
								 @if ($increment > 0)
								     crecido un {{ $increment }}%
								 @else
								     decrecido un {{ $increment }}%
								 @endif 
								 comparado con el anterior.
							</p>
							@endif
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
							<p>La evolución del reconocimiento en tu equipo.</p>
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
							<p>Comparación de categorías más y menos reconocidas.</p>

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
									Reconocimientos recibidos
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
									Insignias recibidas
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
										<h4 class="card-title" style="color: #716f6e;font-size: 1.5rem;font-weight: 600;">Reconocimientos recibidos</h4>
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
												<a class="btn btn-warning w-100 mb-2" data-toggle="collapse" href="#collapseReporteOne" role="button" aria-expanded="false" aria-controls="collapseExample" data-toggle="tooltip" data-placement="top" title="Generar reporte.">
												  📁 Generar Reportes
												</a>
												<div class="collapse" id="collapseReporteOne">
													<div class="card card-body">
													
													<form id="reportForm" action="{{route('downloadGet')}}" method="POST">
														@csrf
														<input type="date" class="form-control" name="fecinifil" id="fecinifil" max="{{ $fecha }}" value="{{ $fecini }}" hidden>
														<input type="date" class="form-control" name="fecfinfil" id="fecfinfil" max="{{ $fecha }}" value="{{ $fecfin }}" hidden>

														<!-- Boton 1 para generar reporte en Excel -->
														<input type="hidden" name="reportetipo" id="reportetipo" value="">

														<button type="submit" class="btn btn-info w-100 mb-2" data-toggle="tooltip" data-placement="top" title="Generar reporte en Excel." onclick="setReportType(1)">
															<i class="fas fa-file-excel"></i> Generar reporte en Excel.
														</button>

														<!-- Boton 2 para generar reporte en PDF -->
														<button type="submit" class="btn btn-info w-100" data-toggle="tooltip" data-placement="top" title="Generar reporte en PDF." onclick="setReportType(2)">
															<i class="fas fa-file-pdf"></i> Generar reporte en PDF.
														</button>
													</form>

													</div>
												</div>
												<p class="small m-0">Descargar datos clave en Excel/PDF.</p>
											</div>
										</div>
									</div>
									<div class="card">

										<!-- /.card-header -->
										<div class="card-header mt-3">
											<div class="table-responsive">
												<table class="table table-hover table-estadisticas" id="tabla1">
													<thead class="colortablas">
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
														<?php
														$contador = 0;
														?>
															@foreach ($recibidos as $conjuntoUsuarios) @if (!empty($conjuntoUsuarios)) @foreach ($conjuntoUsuarios as $usuario)
															<tr>
																<th scope="row">{{ $contador+=1 }}</th>
																<td>{{ $usuario->nombre }} {{ $usuario->ape }}</td>
																<td>{{ $usuario->fecmin ? \Carbon\Carbon::parse($usuario->fecmin)->format('d/m/Y') : '--' }}
																</td>
																<td>{{ $usuario->fecmax  ? \Carbon\Carbon::parse($usuario->fecmax )->format('d/m/Y') : '--' }}
																</td>
																@foreach($categoria as $cate)
																<td>

																	<div class="progress-group">

																		Total por categoría

																		<span class="float-right"><b>{{ $usuario->{'c' . $cate->id} ?? 0 }} |  @if($usuario->tot != 0) {{round($usuario->{'c' . $cate->id}*100/$usuario->tot, 1)}}% @else 0%  @endif</span>
																		<div class="progress progress-sm">
																			<div class="progress-bar bg-success" style="width:  @if($usuario->tot != 0) {{round($usuario->{'c' . $cate->id}*100/$usuario->tot, 1)}}% @else 0%  @endif"></div>
																		</div>
																	</div>
																</td>
																@endforeach
																<td><b>{{ $usuario->tot ?? 0 }}</b>
																	<!--| @if($usuario->tot != 0) 100% @else 0% @endif-->
																</td>
															</tr>
															@endforeach 
															@endif
															@endforeach
															
													</tbody>
												</table>
											</div>

										</div>
										<!-- /.card-body -->
										
									</div>

								</div>
								<!--======================================-->


								<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
									<!-- Acciones Rápidas del Administrador -->
									<div class="card p-4 mb-2">
										<h4 class="card-title" style="color: #716f6e;font-size: 1.5rem;font-weight: 600;">Insignias recibidas</h4>
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
												
												<a class="btn btn-warning w-100 mb-2" data-toggle="collapse" href="#collapseReportetwo" role="button" aria-expanded="false" aria-controls="collapseExample" data-toggle="tooltip" data-placement="top" title="Generar reporte.">
												  📁 Generar Reportes
												</a>
												<div class="collapse" id="collapseReportetwo">
													<div class="card card-body">
													
													<form id="reportForm02" action="{{route('downloadGetInsignias')}}" method="POST">
														@csrf
														<input type="date" class="form-control" name="fecinifil02" id="fecinifil02" max="{{ $fecha }}" value="{{ $fecini }}" hidden>
														<input type="date" class="form-control" name="fecfinfil02" id="fecfinfil02" max="{{ $fecha }}" value="{{ $fecfin }}" hidden>

														<!-- Boton 1 para generar reporte en Excel -->
														<input type="hidden" name="reportetipo02" id="reportetipo02" value="">

														<button type="submit" class="btn btn-info w-100 mb-2" data-toggle="tooltip" data-placement="top" title="Generar reporte en Excel." onclick="setReportType02(1)">
															<i class="fas fa-file-excel"></i> Generar reporte en Excel.
														</button>

														<!-- Boton 2 para generar reporte en PDF -->
														<button type="submit" class="btn btn-info w-100" data-toggle="tooltip" data-placement="top" title="Generar reporte en PDF." onclick="setReportType02(2)">
															<i class="fas fa-file-pdf"></i> Generar reporte en PDF.
														</button>
													</form>

													</div>
												</div>

												<p class="small m-0">Descargar datos clave en Excel/PDF.</p>
											</div>
										</div>
									</div>
									<div class="card">
										<!-- /.card-header -->
										<div class="card-header mt-3">
											<div class="table-responsive">
												<table class="table table-hover table-estadisticas" id="tabla2">
													<thead class="colortablas">
														<tr>
															<th scope="col">No</th>
															<th scope="col">Nombres</th>
															<th scope="col">Apellidos</th>
															<th scope="col">Oro</th>
															<th scope="col">Plata</th>
															<th scope="col">Bronce</th>
															<th scope="col">Total</th>
														</tr>
													</thead>
													<tbody>
														@foreach ($insigrecibidas as $irec)
														<tr>
															<td>{{ $loop->iteration }}</td>
															<td>{{ $irec->name }}</td>
															<td>{{ $irec->ape }}</td>
															<td>
															   <div class="progress-group">
																	Cantidad en Oro
																	<span class="float-right"><b>{{ $irec->oro }} | @if($irec->total != 0){{ number_format($irec->oro * 100 / $irec->total, 0) }}% @else 0% @endif</span>
																	<div class="progress progress-sm">
																		<div class="progress-bar bg-warning" style="width:   @if($irec->total != 0){{ number_format($irec->oro * 100 / $irec->total, 0) }}% @else 0% @endif">
																		</div>
																	</div>
																</div>
															</td>
															<td>
															    <div class="progress-group">
																	Cantidad en plata
																	<span class="float-right"><b>{{ $irec->plata }} | @if($irec->total != 0){{ number_format($irec->plata*100/$irec->total) }}% @else 0% @endif</span>
																	<div class="progress progress-sm">
																		<div class="progress-bar bg-info" style="width: @if($irec->total != 0){{ number_format($irec->plata*100/$irec->total) }}% @else 0% @endif">
																		</div>
																	</div>
																</div>
															</td>
															<td>
															  <div class="progress-group">
																	Cantidad en bronce
																	<span class="float-right"><b>{{ $irec->bronce }} | @if($irec->total != 0){{ number_format($irec->bronce*100/$irec->total) }}% @else 0% @endif</span>
																	<div class="progress progress-sm">
																		<div class="progress-bar bg-danger" style="width: @if($irec->total != 0){{ number_format($irec->bronce*100/$irec->total) }}% @else 0% @endif">
																		</div>
																	</div>
																</div>
															</td>
															<td>
															     <b>{{ $irec->total }} </b>
															</td>
														</tr>
														@endforeach
														
													</tbody>
												</table>
											</div>

										</div>
										<!-- /.card-body -->
									
									</div>
									<!---========= buscador =============-->
									<div class="row mb-2">
										<div class="col-lg-12 col-md-12 text-end">

										</div>
									</div>
									<!--====================================-->
									<div class="row letraform">

									</div>
									<!---=========================================-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->

<!--==========================================-->
<script>
	/* declarar variables de manera global */
	window.recmes = @JSON($recmes);
	window.totcat = @JSON($totcat);
	window.recdia = @JSON($recdia);
	window.label2 = "Cantidad de reconocimientos";

	document.getElementById('fecini').addEventListener('change', function() {
				var fecini = document.getElementById('fecini').value;
				document.getElementById('fecfin').min = fecini;
	});
	/*funcionalidad para datatables  */
	$('#tabla1').DataTable({
		"language": {
			"url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
			},
	});

	$('#tabla2').DataTable({
		"language": {
			"url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
			},
	});

	/*Cambiar el valor del input */
	function setReportType(type) {
        document.getElementById('reportetipo').value = type;
        document.getElementById('reportForm').submit();  // Enviar el formulario
    }

	/* cambiar valor para input 02 */
	function setReportType02(val){
        document.getElementById('reportetipo02').value = val;
        document.getElementById('reportForm02').submit();  // Enviar el formulario
	}
	
</script>

@endsection