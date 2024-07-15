@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert">
  <h3><b>COLABORADORES QUE HAN ENVIADO RECONOCIMIENTOS</b></h3>
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
@endsection
