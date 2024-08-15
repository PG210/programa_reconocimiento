@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert">
  <h3><b>RECONOCIMIENTOS ENVIADOS</b></h3>
</div>
<div class="row letraform">
 <div class="col-md-12 table-responsive">
  <table class="table">
  <thead class="tablaheader">
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nombres</th>
      <th scope="col"></th>
      <!--<th scope="col">Fecha</th>-->
      <th scope="col">Categoría</th>
     <!-- <th scope="col">Comportamiento</th>-->
      <th scope="col">Detalle</th>
      <th scope="col">Peñutes</th>
    </tr>
  </thead>
  <tbody>
      <!--=====================-->
      @if(count($agrupados) != 0)
      @foreach ($agrupados as $iduser => $registros) 
      <tr>
        <th scope="row">{{ $loop->iteration }}</th>
        <td colspan="6">{{ $registros->first()->name }} {{ $registros->first()->apellido }}</td>
      </tr>
      @foreach ($registros as $info)
        <tr>
          <td colspan="3"></td> 
          <!--<td>{{ date('Y-m-d', strtotime($info->fecha)) }}</td>-->
          <td>{{ $info->cate }}</td>
          <!--<td>{{ $info->comportamiento }}</td>-->
          <td>{{ $info->detalle }}</td>
          <td>{{ $info->puntaje }}</td>
        </tr>
      @endforeach
    @endforeach
    @endif
    <!--====================-->   
     </tbody>
    </table>  
 </div>
</div>
<!------###########################-->
@endsection
