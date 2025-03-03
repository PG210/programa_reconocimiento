@extends('usuario.principa_usul')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-8">
      <h1 class="m-0">Puntos obtenidos</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Puntos obtenidos</li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>

<div class="container">

<div class="row mb-2">
		<div class="col-md-12">
			<!---filtros de busqueda -->
			<!---filtros de busqueda -->
      <!---filtro -->
      <div class="">
            <!---filtros de busqueda -->
            <form action="{{route('filterPuntos')}}" method="POST">
                @csrf
                <div class="form-group row m-0" style="display: flex;align-items: center;">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha inicial y final</label>
                      <div class="col-sm-10 filtro-fecha">
                        <input type="date" aria-label="First name" class="form-control" name="fecini" id="fecini" max="{{ $fecha }}" value="{{ $fecini }}" required>
                        <input type="date" aria-label="Last name" class="form-control" name="fecfin" id="fecfin" max="{{ $fecha }}" value="{{ $fecfin }}"  required>
                        <button class="btn btn-primary" role="button" type="submit"> <i class="fas fa-search"></i></button>
                     </div>
                     </div>
            </form>
        </div>
        <!--end filter -->

			<!--end filtros-->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->


<div class="">
  <div class="row mb-2">
  
                    <div class="col-lg-3 col-12">
			<div class="row">
				<div class="col-12">
					<!-- small box -->
					<div class="small-box bg-warning">
						<div class="inner">
							<p class="m-0">En este periodo, </p>
							<h5>Manuel Apellido</h5>
							<p class="m-0">ha recibido más puntos que nadie.</p>
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
							<p class="m-0">Parece que </p>
							<h5>Manuel Apellido</h5>
							<p class="m-0">ha recibido pocos puntos. ¿Tal vez necesite más apoyo o visibilidad en su trabajo?</p>
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
      <!-- Acciones Rápidas del Administrador -->
      <div class="card p-4 mb-2">
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
												<form action="{{route('downloadGet')}}" method="POST">
													@csrf
													<input type="date" class="form-control" name="fecinifil" id="fecinifil" max="{{ $fecha }}" value="{{ $fecini }}" hidden>
													<input type="date" class="form-control" name="fecfinfil" id="fecfinfil" max="{{ $fecha }}" value="{{ $fecfin }}" hidden>
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
                            
 <!---========= buscador =============-->
 <div class="row mb-3">
    <div class="col-lg-12 col-md-12 text-end">
        <input type="text" class="form-control" id="searchTerm" onkeyup="doSearch()" placeholder="Buscar...">
    </div>
</div>
<!--====================================-->
                          <form action="{{route('downloadPuntos')}}" method="POST">
                              @csrf
                              <input type="date" aria-label="First name" class="form-control" name="fecinifil" id="fecinifil" max="{{ $fecha }}" value="{{ $fecini }}" hidden>
                              <input type="date" aria-label="Last name" class="form-control" name="fecfinfil" id="fecfinfil" max="{{ $fecha }}" value="{{ $fecfin }}" hidden>
                              
                          </form>
													</div>
												</div>
											</div>
										</div>
										<!-- /.card-header -->
<div class="card-body">
<div class="row letraform">
 <div class="col-md-12 table-responsive">
  <table class="table table-hover table-estadisticas" id="tablaDate">
  <thead class="tablaheader">
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nombre</th>
      <th scope="col">F/Inicial</th>
      <th scope="col">F/Final</th>
      <th scope="col">Puntos</th>
    </tr>
  </thead>
  <tbody>
    <!--=========================-->
     <?php
        $contador = 0;
      ?>
      @if(count($recibidos) > 0)
        @foreach ($recibidos as $conjuntoUsuarios)
        @if (!empty($conjuntoUsuarios))
            @foreach ($conjuntoUsuarios as $usuario)
            <tr>
                <th scope="row">{{ $contador+=1 }}</th>
                <td>{{ $usuario->nombre }} {{ $usuario->ape }}</td>
                <td>{{ $usuario->fecmin ?? '--' }} </td>
                <td>{{ $usuario->fecmax ?? '--' }} </td>
                <td>{{ $usuario->puntostot ?? 0 }} </td>
            </tr>
                @endforeach
            @endif
        @endforeach
        @endif
        <tr class='noSearch hide'>
            <td colspan="3"></td>
        </tr>
    <!--====================-->   
     </tbody>
    </table>  
 </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!------###########################-->
<script src="{{ asset('js/buscador.js')}}"></script>
<script>
   document.getElementById('fecini').addEventListener('change', function() {
              var fecini = document.getElementById('fecini').value;
              document.getElementById('fecfin').min = fecini;
   });
</script>
@endsection
