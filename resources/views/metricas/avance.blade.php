@extends('usuario.principa_usul')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-8">
				<h1 class="m-0">Impacto del Reconocimiento en Tu Equipo</h1> 
        Descubre cómo avanza la cultura de reconocimiento en tu equipo y toma acciones para fortalecerla.🚀
			</div>
			<!-- /.col -->
			<div class="col-sm-4">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item active">Rec. Obtenidos</li>
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
            <div class="small-box bg-warning">
              <div class="inner">
                 <p class="m-0">Este mes, </p>
                <h5>Manuel Apellido</h5>
                <p class="m-0">ha recibido más reconocimientos que nadie.</p>  
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">¡Felicítalo! <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <p class="m-0">Categoría con Más Reconocimientos: </p>
                <h5>Empatía y vocación de servicio. </h5>
                <p class="m-0">Tus colaboradores valoran esta actitud. ¿Cómo podemos impulsar otras competencias?</p>  
                
              </div>
              <div class="icon">
                <i class="fas fas fa-trophy"></i>
              </div>
              <a href="#" class="small-box-footer">Ver más información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <p class="m-0">Parece que </p>
                <h5>Manuel Apellido</h5>
                <p class="m-0">ha recibido pocos reconocimientos. ¿Tal vez necesite más apoyo o visibilidad en su trabajo?</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Envíar reconocimientos <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>+15%</h3>
                <p class="m-0">Este mes, el reconocimiento en la empresa ha crecido un +15% comparado con el anterior.”</p>  
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

		
    <div class="row mb-3">
                        <div class="col-md-12">
                        <!---filtros de busqueda -->
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
                        <!--end filtros-->
                        </div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
<!-- /.container-fluid -->


<div class="container">
		<div class="row">
			<div class="col-sm-12">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                  <li class="pt-2 px-3"><h3 class="card-title">Consulta tus:</h3></li>
                  <li class="nav-item">
                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                      Reconocimientos recibidos
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                      Insignias recibidas
                    </a>
                  </li>
                  <li class="pt-2 px-3">
                    
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <!---========= buscador =============-->
                    <div class="row mb-2">
                        
                         <div class="col-md-8 text-end">
                            <input type="text" class="form-control" id="searchTerm" onkeyup="doSearch()" placeholder="Buscar...">
                        </div>
                    
                        <div class="col-md-4 text-right">
                          <form action="{{route('downloadGet')}}" method="POST">
                              @csrf
                              <input type="date" class="form-control" name="fecinifil" id="fecinifil" max="{{ $fecha }}" value="{{ $fecini }}" hidden>
                              <input type="date"class="form-control" name="fecfinfil" id="fecfinfil" max="{{ $fecha }}" value="{{ $fecfin }}" hidden>
                              <button type="submit" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Generar reporte en Excel.">
                                <i class="fas fa-file-excel" style="color: white; font-size:22px;"></i> Descargar reporte
                              </button>
                          </form>
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
                            <th scope="col">F/Inicial</th>
                            <th scope="col">F/Final</th>
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
                                <td>{{ $usuario->nombre }} {{ $usuario->ape }}</td>
                                <td>{{ $usuario->fecmin ?? '--' }} </td>
                                <td>{{ $usuario->fecmax ?? '--' }} </td>
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
                  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
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
            </div>
          </div>
        </div>
</div>
<div class="container">
    <div class="row">
          <div class="col-lg-12">
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
            
        </div>
        <!--end filter -->
        
      </div>
    </div>

    <div id="collapseOne_reconocimientos" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        
        
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
         
        
      </div>
    </div>
  </div>
</div>
</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
<!-- /.container-fluid -->
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