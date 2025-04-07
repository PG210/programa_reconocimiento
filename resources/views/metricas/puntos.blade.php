@extends('usuario.principa_usul')
@section('content')
@include('usuario.datatables')
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
              @if(isset($topuntos->name))
                <p class="m-0">En este periodo, </p>
                  <h5>{{ $topuntos->name }} {{ $topuntos->apellido }}</h5>
                <p class="m-0">ha recibido más puntos que nadie.</p>
              @else
                <p class="m-0">Aún no hay personas que hayan recibido puntos en este periodo.</p>
              @endif
						</div>
						<div class="icon">
							<i class="ion ion-person-add"></i>
						</div>
            @if( auth()->user()->id_rol != 1)
						 <a href="/reconocimientos/usuario" class="small-box-footer">¡Felicítalo! <i class="fas fa-arrow-circle-right"></i></a>
					  @endif
          </div>
				</div>
				<!-- ./col -->
				
				<div class="col-12">
					<!-- small box -->
					<div class="small-box bg-info">
						<div class="inner">
            <!--dropdown-->
            @if ($downpuntos->isNotEmpty())
							<p class="m-0">Parece que </p>
								<h5>{{ $downpuntos->first()->name }} {{ $downpuntos->first()->apellido }}</h5>
              <h6>
                <a class="" data-toggle="collapse" href="#collapseUsersDown" role="button" aria-expanded="false" aria-controls="collapseUsers">
                  Ver más <i class="fas fa-plus"></i>
                </a>
							</h6>
								<div class="collapse" id="collapseUsersDown">
									<div class="">
									<ul class="list-group list-group-flush">
                    @foreach ($downpuntos->skip(1) as $utot)
                    <li class="list-item"> <h5>{{ $utot->name }} {{ $utot->apellido }}</h5></li>
                      @endforeach
									</ul>
									</div>
								</div>
								<!--end dropdown-->
								<p class="m-0">ha recibido pocos puntos. ¿Tal vez necesite más apoyo o visibilidad en su trabajo?</p>
							@else
								<p class="m-0">No hay usuarios para mostrar en este periodo.</p>
							@endif
              
            	<div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              @if( auth()->user()->id_rol != 1)
						  <a href="/reconocimientos/usuario" class="small-box-footer">Envíar reconocimientos <i class="fas fa-arrow-circle-right"></i></a>
              @endif
              <!---end ver mas-->
            </div>
          </div>
				</div>
				<!-- ./col -->

				<div class="col-12">
					<!-- small box -->
					<div class="small-box bg-danger">
						<div class="inner">
              <!---start increment-->
              @if (isset($increment))
							<h3>{{ $increment }}%</h3>
							<p class="m-0">En este mes, el reconocimiento en la empresa ha
								 @if ($increment > 0)
								     crecido un {{ $increment }}%
								 @else
								     decrecido un {{ $increment }}%
								 @endif 
								 comparado con el anterior.
							</p>
							@endif
              <!---end increment-->
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
          <!---generar reportes-->
          <div class="col-md-4">
            <a class="btn btn-warning w-100 mb-2" data-toggle="collapse" href="#collapseReporteOne" role="button" aria-expanded="false" aria-controls="collapseExample" data-toggle="tooltip" data-placement="top" title="Generar reporte.">
              📁 Generar Reportes
            </a>
            <div class="collapse" id="collapseReporteOne">
              <div class="card card-body">
              
              <form id="reportForm" action="{{route('downloadPuntos')}}" method="POST">
                @csrf
                <input type="date" class="form-control" name="fecinifil" id="fecinifil" max="{{ $fecha }}" value="{{ $fecini }}" hidden>
                <input type="date" class="form-control" name="fecfinfil" id="fecfinfil" max="{{ $fecha }}" value="{{ $fecfin }}" hidden>

                <!-- Boton 1 para generar reporte en Excel -->
                <input type="hidden" name="reportetipo" id="reportetipo" value="">

                <button type="submit" class="btn btn-info w-100 btn-sm mb-2" data-toggle="tooltip" data-placement="top" title="Generar reporte en Excel." onclick="setReportType(1)">
                  <i class="fas fa-file-excel"></i> Generar reporte en Excel.
                </button>

                <!-- Boton 2 para generar reporte en PDF -->
                <button type="submit" class="btn btn-info btn-sm w-100" data-toggle="tooltip" data-placement="top" title="Generar reporte en PDF." onclick="setReportType(2)">
                  <i class="fas fa-file-pdf"></i> Generar reporte en PDF.
                </button>
              </form>

              </div>
            </div>
            <p class="small m-0">Descargar datos clave en Excel/PDF.</p>
          </div>
          <!---end reportes-->
        </div>
      </div>
<div class="card">
<!-- /.card-header -->
<div class="card-body">
<div class="row letraform">
 <div class="col-md-12 table-responsive">
  <table class="table table-hover table-estadisticas" id="tabla1">
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
    @php
    $conta = 1;
    @endphp
      @if(count($recibidos) > 0)
        @foreach ($recibidos as $conjuntoUsuarios)
        @if (!empty($conjuntoUsuarios))
        @foreach ($conjuntoUsuarios as $usuario)
          <tr>
              <th scope="row">{{ $conta++ }}</th>
              <td>{{ $usuario->nombre }} {{ $usuario->ape }}</td>
              <td> {{ $usuario->fecmin ? \Carbon\Carbon::parse($usuario->fecmin)->format('d/m/Y') : '--' }} </td>
              <td> {{ $usuario->fecmax ? \Carbon\Carbon::parse($usuario->fecmax)->format('d/m/Y') : '--' }}  </td>
              <td>{{ $usuario->puntostot ?? 0 }} </td>
          </tr>
            @endforeach
        @endif
       @endforeach
      @endif
      
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

   $('#tabla1').DataTable({
      "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
    });

  /*Cambiar el valor del input */
	function setReportType(type) {
        document.getElementById('reportetipo').value = type;
        document.getElementById('reportForm').submit();  // Enviar el formulario
    }
</script>
@endsection
