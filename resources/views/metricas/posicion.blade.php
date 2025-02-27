@extends('usuario.principa_usul')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-9">
				<h1 class="m-0">Mi Posición en el Ranking</h1>
			</div>
			<!-- /.col -->
			<div class="col-sm-3">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item active">Mi Posición en el Ranking</li>
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
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <p class="m-0">Tu Posición en<br> el grupo es:</p>
                <h3>#15 </h3>
                <p class="m-0">¡Sigue brillando!</p>
              </div>
              <div class="icon">
                <i class="fas fas fa-trophy"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <p class="m-0">Comparado con el anterior periodo, subiste </p>
                <h3>3 lugares</h3>
                <p class="m-0">¡Sigue así!</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                 <p class="m-0">Tu categoría<br> más fuerte:</p>
                <h5>Empatía y vocación de servicio</h5>
                <p class="m-0">¡valora esa conexión!</p>  
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
             
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <p class="m-0"> Estás a solo un </p> 
              <h3>70%</h3>
              <p class="m-0"> de desbloquear tu próximo nivel.</p>  
                <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar bg-warning" style="width: 90%"></div>
                        </div>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        </div>

<div class="container">
  <div class="row">
    <div class="col-12">
      <!-- Recomendaciones Personalizadas -->
 <div class="alert alert-warning mb-4 text-center">
            💡 <strong>Consejo:</strong> ¡Reconocimientos en "Aprender" pueden ayudarte a subir en la tabla!
        </div>
    <div class="card">

<div class="card-header">
  <div class="card-tools">
    <div class="" style="display: flex;justify-content: space-around;gap: 10px;">
      <div class="" style="width: 200px;">
        <input type="text" class="form-control" id="searchTerm" onkeyup="doSearch()" placeholder="Buscar...">
      </div>
    </div>
  </div>
</div>
<!-- /.card-header -->
<div class="">
  <div class="table-responsive">

  <table class="table table-hover table-estadisticas">
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
                        <td><div class="progress-group">
                              Total por categoría
                              <span class="float-right"><b>{{ $usuario->{'c' . $cate->id} ?? 0 }} |  @if($usuario->tot != 0) {{round($usuario->{'c' . $cate->id}*100/$usuario->tot, 1)}}% @else 0%  @endif</b></span>
                              <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width:@if($usuario->tot != 0) {{round($usuario->{'c' . $cate->id}*100/$usuario->tot, 1)}}% @else 0%  @endif"></div>
                              </div>
                           </div></td>
                        @endforeach
                        <td><b>{{ $usuario->tot ?? 0 }} </b><!--| @if($usuario->tot != 0) 100% @else 0% @endif--></td>
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
<!-- /.card-body -->
<div class="card-footer clearfix">
  <div class="row">
    <div class="col-sm-12 col-md-7">
      <div class="dataTables_info">Showing 1 to 10 of 57 entries</div>
    </div>
    <div class="col-sm-12 col-md-5">
      <div class="">
        <ul class="pagination m-0">
          <li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
          <li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
          <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
          <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
          <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
          <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0" class="page-link">5</a></li>
          <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li>
          <li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
</div>

 
    </div>
  </div>
</div>
<!------###########################-->
@endsection
