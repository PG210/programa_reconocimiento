@extends('usuario.principa_usul')
@section('content')

@include('usuario.datatables')

 

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
          <strong>🌟 Has enviado
            @if(isset($totmes->total))
              {{ $totmes->total ?? 0 }}
            @endif
            reconocimientos este mes </strong>
          </p>

          <div class="chart-container" style="height: 180px; width:100%;">
          <canvas id="timelineChart"></canvas>
          </div>
          <!-- /.chart-responsive -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <p class="text-center">
          <strong>Categorias</strong>
          </p>

          @if(isset($puntoscat))
              @php
                  // Array de clases de colores para la progress bar
                  $colores = ['bg-warning', 'bg-info', 'bg-danger', 'bg-success', 'bg-secondary'];
                  $index = 0; // Para iterar sobre los colores
              @endphp

              @foreach ($puntoscat as $pc)
                <div class="progress-group">
                  {{ $pc->nomcat }}
                  <span class="float-right"><b>{{ $pc->puntos }}</b>/1000</span>
                  <div class="progress progress-sm">
                    <div class="progress-bar {{ $colores[$index] }}" style="width: {{ ($pc->puntos * 100) / 1000 }}%">
                    </div>
                  </div>
                </div>
                @php
                // Incrementamos el índice y lo reiniciamos si llega al final del array
                $index = ($index + 1) % count($colores);
                @endphp
              @endforeach
           @endif
          <!-- /.progress-group -->

        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>

      </div>
      <div class="card">
      <!-- /.card-header -->
      <div class="card-header mt-2">
        <div class="table-responsive">
        <table class="table table-hover table-estadisticas" id="tabla2">
          <thead class="tablaheader">
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nombres</th>
            <th scope="col">Categoría</th>
            <th scope="col">Detalle</th>
            <th scope="col">Peñutes</th>
          </tr>
          </thead>
          <tbody>
          @php
           $conta = 1;
          @endphp
          @if(count($agrupados) != 0)
                @foreach ($agrupados as $iduser => $registros)
                {{-- Primera fila con el nombre --}}   
                {{-- Filas con datos asociados (si existen) --}}
                @foreach ($registros as $info)
                  <tr>
                    <td>{{ $conta++ }} </td>
                    <td>{{ $registros->first()->name }} {{ $registros->first()->apellido }}</td>
                    <td>{{ $info->cate }}</td>
                    <td>{{ $info->detalle }}</td>
                    <td>{{ $info->puntaje }}</td>
                  </tr>
                @endforeach
              @endforeach
          @endif
      </tbody>
  </table>
<!--====================-->
  </div>
  </div>
      <!-- /.card-body -->
  </div>

  </div>
  </div>
</div>
<!------###########################-->

<script>
    window.rectime = @json($recenvia);

    $('#tabla2').DataTable({
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
    },
    });
  </script>
@endsection