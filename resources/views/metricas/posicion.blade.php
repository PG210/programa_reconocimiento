@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert">
  <h3 ><b>TABLA DE POSICIÓN</b></h3>
</div>
<div class="row letraform">
 <div class="col-md-12 table-responsive">
  <table class="table">
  <thead class="tablaheader">
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
   @foreach($cercanos as $id_usuario => $valor)
        @foreach ($recibidos as $conjuntoUsuarios)
        @if (!empty($conjuntoUsuarios))
            @foreach ($conjuntoUsuarios as $usuario)
               @if ($id_usuario == $usuario->id_user_recibe)
                    <tr>
                        <th scope="row">{{ $contador+=1 }}</th>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->ape }}</td>
                        @foreach($categoria as $cate)
                            <td>{{ $usuario->{'c' . $cate->id} ?? 0 }} |  @if($usuario->tot != 0) {{round($usuario->{'c' . $cate->id}*100/$usuario->tot, 1)}}% @else 0%  @endif</td>
                        @endforeach
                        <td>{{ $usuario->tot ?? 0 }} | @if($usuario->tot != 0) 100% @else 0% @endif</td>
                    </tr>
                 @endif
                @endforeach
            @endif
        @endforeach
    @endforeach 
   </tbody>
    </table>  
    <!--====================-->
 </div>
</div>
<!------###########################-->
@endsection
