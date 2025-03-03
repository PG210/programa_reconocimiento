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
         Votaciones Periodo: {{$es->anio}} - {{$es->periodo}}
      </h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item active">Periodo de votación</li>
      </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

        <div class="accordion" id="accordionExample">
        <div class="card">
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
               <!---table-->
                <div class="table-responsive mt-5">
                <table class="table letraform" id="votacion01">
                <thead class="tablaheader">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Votos</th>
                        @foreach($categorias as $categoria)
                            <th scope="col">{{ $categoria->descripcion}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <?php $conta = 1; ?>
                    @if(isset($votos[0]))
                        @foreach($votos as $v)
                            <tr>
                                <td>{{ $conta++ }}</td>
                                <td>{{ $v->name }} {{ $v->apellido }}</td>
                                <td>{{ $v->cargos }}</td>
                                <td>{{ $v->total }}</td>
                                @foreach($cat as $c)
                                    @if($v->idusu == $c->id_postulado )
                                    <td>
                                        {{ $c->total ?? 0 }}
                                    </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
       </div>
     <!--end table-->
     </div>
    </div>
  </div>
</div>

<!--
<script>
// Función para filtrar la tabla en base al input de búsqueda
    $('#search').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#votacion01 tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
</script>-->

<script> 
  $('#votacion01').DataTable({
      "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
  });
</script>
@endsection