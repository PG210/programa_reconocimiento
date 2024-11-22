@extends('usuario.principa_usul')
@section('content')
<!--======================================--->
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-12">
            <h2 class="mb-0">
              <button class="btn btn-block text-left  titulo" type="button" data-toggle="collapse" data-target="#collapseOne_reconocimientos" aria-expanded="true" aria-controls="collapseOne_reconocimientos">
                Reconocimientos obtenidos
               </button>
            </h2>
        </div>
        <!---filtro -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-10">
            <!---filtros de busqueda -->
            <form action="{{route('filterReconocimientoTotal')}}" method="POST">
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
            <form action="{{route('downloadGet')}}" method="POST">
                @csrf
                <input type="date" class="form-control" name="fecinifil" id="fecinifil" max="{{ $fecha }}" value="{{ $fecini }}" hidden>
                <input type="date"class="form-control" name="fecfinfil" id="fecfinfil" max="{{ $fecha }}" value="{{ $fecfin }}" hidden>
                <button type="submit" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Generar reporte en Excel.">
                   <i class="fas fa-file-excel" style="color: white; font-size:22px;"></i>
                </button>
            </form>
        </div>
      </div>
    </div>

    <div id="collapseOne_reconocimientos" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <!---========= buscador =============-->
        <div class="row mb-2">
            <div class="col-lg-12 col-md-12 text-end">
                <input type="text" class="form-control" id="searchTerm" onkeyup="doSearch()" placeholder="Buscar...">
            </div>
        </div>
        <!--====================================-->
        <div class="row letraform">
            <div class="col-md-12 table-responsive">
            <table class="table" id="tablaDate">
            <thead class="colortablas">
                <tr>
                <th scope="col">No</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
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
            @foreach ($recibidos as $conjuntoUsuarios)
            @if (!empty($conjuntoUsuarios))
                @foreach ($conjuntoUsuarios as $usuario)
                <tr>
                    <th scope="row">{{ $contador+=1 }}</th>
                    <td>{{ $usuario->nombre }}</td>
                    <td>{{ $usuario->ape }}</td>
                    @foreach($categoria as $cate)
                        <td>{{ $usuario->{'c' . $cate->id} ?? 0 }} |  @if($usuario->tot != 0) {{round($usuario->{'c' . $cate->id}*100/$usuario->tot, 1)}}% @else 0%  @endif</td>
                    @endforeach
                    <td>{{ $usuario->tot ?? 0 }} | @if($usuario->tot != 0) 100% @else 0% @endif</td>
                </tr>
                    @endforeach
                @endif
            @endforeach
            <tr class='noSearch hide'>
                <td colspan="3"></td>
            </tr>
            </tbody>
                </table>  
            </div>
            </div>
        <!--======================================-->
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-block text-left collapsed titulo" type="button" data-toggle="collapse" data-target="#collapseTwo_reconocimientos" aria-expanded="false" aria-controls="collapseTwo_reconocimientos">
          Tabla de insignias obtenidas
        </button>
      </h2>
    </div>
    <div id="collapseTwo_reconocimientos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
         <!---========= buscador =============-->
         <div class="row mb-2">
            <div class="col-lg-12 col-md-12 text-end">
                <input type="text" class="form-control" id="searchTerm2" onkeyup="doSearch2()" placeholder="Buscar...">
            </div>
        </div>
        <!--====================================-->
        <div class="row letraform">
            <div class="col-md-12 table-responsive">
            <table class="table" id="tablaDate2">
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
                    @foreach($users as $index => $usu)
                    <?php 
                        $oroCount = 0;
                        $plataCount = 0;
                        $bronceCount = 0;
                        $totalsum = 0;
                    ?>
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $usu->name }}</td>
                        <td>{{ $usu->apellido }}</td>
                        @if(!empty($insignias))
                        @foreach($insignias as $cant)
                            @if($usu->id == $cant->id_usuario)
                                @if($cant->des == "Oro")
                                    <?php $oroCount++; ?>
                                @elseif($cant->des == "Plata")
                                    <?php $plataCount++; ?>
                                @elseif($cant->des == "Bronce")
                                    <?php $bronceCount++; ?>
                                @endif
                                <?php $totalsum = $oroCount + $plataCount + $bronceCount;  ?>
                            @endif
                        @endforeach
                        @endif
                        <td>{{ $oroCount }} | @if($totalsum != 0){{ number_format($oroCount * 100 / $totalsum, 0) }}% @else 0% @endif</td>
                        <td>{{ $plataCount }} | @if($totalsum != 0){{  number_format($plataCount*100/$totalsum) }}% @else 0% @endif</td>
                        <td>{{ $bronceCount }} | @if($totalsum != 0){{  number_format($bronceCount*100/$totalsum) }}%  @else 0% @endif</td>
                        <td>{{ $totalsum }} |  @if($totalsum != 0) 100% @else 0% @endif</td>
                    </tr>
                    @endforeach
                    <tr class='noSearch2 hide'>
                       <td colspan="3"></td>
                    </tr>

                </tbody>
                </table>
            </div>
            </div>
        <!---=========================================-->
      </div>
    </div>
  </div>
</div>
<!--==========================================-->
<script src="{{ asset('js/buscador.js')}}"></script>
<script src="{{ asset('js/buscador_2.js')}}"></script>
<script>
   document.getElementById('fecini').addEventListener('change', function() {
              var fecini = document.getElementById('fecini').value;
              document.getElementById('fecfin').min = fecini;
   });
</script>
@endsection