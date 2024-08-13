@extends('usuario.principa_usul')
@section('content')
        <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <div class="row">
                    <div class="col-lg-12">
                   
                    <h5 class="titulo">
                    <a href="/admin/votacion" class="btn text-left" type="button"  aria-controls="collapseOne">
                       <i class="fas fa-home" style="font-size:23px;"></i>
                    </a> Votaciones Periodo: {{$es->anio}} - {{$es->periodo}}</h5>
                </div>
              </div>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
               <!---table-->
               <div class="row mb-3">
                    <div class="col-lg-12">
                    <input class="form-control mr-sm-4" type="text" id="search" placeholder="Buscar por nombres...">
                    </div>
                </div>
                <div class="table-responsive">
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
<script>
// Función para filtrar la tabla en base al input de búsqueda
    $('#search').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#votacion01 tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
</script>
@endsection