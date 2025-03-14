@extends('usuario.principa_usul')
@section('content')
@include('usuario.datatables')

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
                @if(!empty($posicion))
                <h3>#{{ $posicion + 1 }}</h3>
                @endif
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
                <p class="m-0">Comparado con el anterior periodo, 
                  @if($posactual > 0) 
                      subiste 
                  @elseif($posactual < 0)
                       bajaste
                  @elseif($posactual == 0)
                       permaneciste en la posición.
                  @endif
                </p>
                @if($posactual > 0) 
                <h3>
                  <i class="fas fa-arrow-up "></i> {{ $posactual }} lugares
                </h3>
                <p class="m-0">¡Sigue así!</p>
                @elseif($posactual < 0)
                 <h3><i class="fas fa-arrow-down "></i> {{ $posactual * -1 }} lugares</h3>  
                @endif
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
                @if(!empty($maxcat))
                  <p class="m-0">Tu categoría<br> más fuerte:</p>
                  <h5>{{ $maxcat->nombre_categoria }}</h5>
                  <p class="m-0">¡valora esa conexión!</p>  
                @else
                   <p class="m-0">Aún no tienes una categoría destacada.</p>
                   <br>
                   <p class="m-0">¡Sigue participando y pronto la descubrirás!</p>  
                 @endif
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
              @if($tacumulado > 0 && $tacumulado < 100)
              <p class="m-0"> Estás a solo un </p> 
              <h3>{{ $tacumulado }}%</h3>
              <p class="m-0"> de desbloquear tu próximo nivel.</p>  
                <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar bg-warning" style="width: {{ $tacumulado }}%"></div>
                </div>
              @elseif($tacumulado == 0)
                <p class="m-0"> Aún no has comenzado, pero pronto desbloquearás tu primer nivel.</p>
              @elseif($tacumulado == 100)
                <p class="m-0"> 🎉 ¡Felicidades! </p>
                <p class="mt-2 mb-2">Nivel desbloqueado</p>
                <p class="m-0"> ¡Sigue así y alcanza nuevas metas! 🚀</p>
              @endif
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
    @if(!empty($mincat))
    <div class="alert alert-warning mb-4 text-center">
      💡 <strong>Consejo:</strong> ¡Reconocimientos en "{{ $mincat->nombre_categoria }}" pueden ayudarte a subir en la tabla!
    </div>
    @endif
    <div class="card">

<!-- /.card-header -->
<div class="card-header mt-2">
  <div class="table-responsive">

  <table class="table table-hover table-estadisticas" id="tablaOne">
  <thead class="tablaheader" >
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
        @if (!empty($data))
        @foreach ($data as $usuario)
          <tr>
              <th scope="row">{{ $loop->iteration }}</th>
              <td>{{ $usuario->nombre }}</td>
              <td>{{ $usuario->ape }}</td>
              @foreach($categoria as $cate)
              <td><div class="progress-group">
                    Total por categoría
                    <span class="float-right"><b>
                      {{ $usuario->{'c' . $cate->id} ?? 0 }} |  
                        @if($usuario->tot != 0) 
                          {{round($usuario->{'c' . $cate->id}*100/$usuario->tot, 1)}}% 
                        @else 
                            0%  
                        @endif
                        </b>
                      </span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-success" style="width:@if($usuario->tot != 0) {{round($usuario->{'c' . $cate->id}*100/$usuario->tot, 1)}}% @else 0%  @endif"></div>
                    </div>
                  </div></td>
              @endforeach
              <td><b>{{ $usuario->tot ?? 0 }} </b><!--| @if($usuario->tot != 0) 100% @else 0% @endif--></td>
          </tr>
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
  $('#tablaOne').DataTable({
		"language": {
			"url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
			},
	});
</script>
@endsection
