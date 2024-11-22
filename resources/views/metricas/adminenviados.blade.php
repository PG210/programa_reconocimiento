@extends('usuario.principa_usul')
@section('content')
<div class="card-header" id="headingOne">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-12">
            <h2 class="mb-0">
              <button class="btn btn-block text-left  titulo" type="button" data-toggle="collapse" data-target="#collapseOne_reconocimientos" aria-expanded="true" aria-controls="collapseOne_reconocimientos">
                  Colaboradores que han enviado reconocimientos
               </button>
            </h2>
        </div>
          <!---filtro -->
          <div class="col-lg-6 col-md-6 col-sm-6 col-10">
            <!---filtros de busqueda -->
            <form action="{{route('filterReconocimientoEnviadoTotal')}}" method="POST">
                @csrf
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Fecha inicial y final</span>
                    </div>
                    <input type="date" aria-label="First name" class="form-control" name="fecini" id="fecini" max="{{ $fecha }}" value="{{ $fecini }}" required>
                    <input type="date" aria-label="Last name" class="form-control" name="fecfin" id="fecfin" max="{{ $fecha }}" value="{{ $fecfin }}"  required>
                    <button class="btn btn-primary" role="button" type="submit"> <i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <!--end filter -->
        <div class="col-lg-2 col-md-2 col-sm-2 col-2 text-right">
            <form action="{{route('downloadgive')}}" method="POST">
                @csrf
                <input type="date" aria-label="First name" class="form-control" name="fecinifil" id="fecinifil" max="{{ $fecha }}" value="{{ $fecini }}" hidden>
                <input type="date" aria-label="Last name" class="form-control" name="fecfinfil" id="fecfinfil" max="{{ $fecha }}" value="{{ $fecfin }}" hidden>
                <button type="submit" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Generar reporte en Excel.">
                  <i class="fas fa-file-excel" style="color: white; font-size:22px;"></i>
                </button>
            </form>
        </div>
      </div>
 </div>
 <!---========= buscador =============-->
 <div class="row mb-3">
    <div class="col-lg-12 col-md-12 text-end">
        <input type="text" class="form-control" id="searchTerm" onkeyup="doSearch()" placeholder="Buscar...">
    </div>
</div>
<!--====================================-->
<div class="row letraform">
 <div class="col-md-12 table-responsive">
  <table class="table" id="tablaDate">
  <thead class="tablaheader">
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nombre</th>
      <th scope="col">Cantidad</th>
      @foreach($categoria as $cat)
       <th scope="col">{{$cat->descripcion}}</th>
      @endforeach
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
                <td>{{ $usuario->tot ?? 0 }} | @if($usuario->tot != 0) 100% @else 0% @endif</td>
                @foreach($categoria as $cate)
                    <td>{{ $usuario->{'c' . $cate->id} ?? 0 }} |  @if($usuario->tot != 0) {{round($usuario->{'c' . $cate->id}*100/$usuario->tot, 1)}}% @else 0%  @endif</td>
                @endforeach
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
<!------###########################-->
<script src="{{ asset('js/buscador.js')}}"></script>
<script>
   document.getElementById('fecini').addEventListener('change', function() {
              var fecini = document.getElementById('fecini').value;
              document.getElementById('fecfin').min = fecini;
   });
</script>
@endsection
