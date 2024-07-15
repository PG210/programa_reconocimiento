@extends('usuario.principa_usul')
@section('content')
<div class="text-center titulo">
 <h3>MÉTRICAS DEL GRUPO: {{$grupo->descripcion}} </h3>
</div>
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
    <br>
    <div class="row table-responsive letraform">
    <table class="table">
    <thead>
        <tr>
            <th scope="col">Colaborador</th>
            <th scope="col">Categoría</th>
            <th scope="col">Total de puntos</th>
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
                    <td>{{ $totalPuntos }}</td>
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
  
<!--end tabla-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



@endsection