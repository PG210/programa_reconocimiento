@extends('usuario.principa_usul')
@section('content')
<style>
  .carousel-item.active {
    background-color: transparent !important;
}

  .tooltip-inner {
    color: #ffffff; /* Cambia el color del texto del tooltip */
    background-color: #333333; /* Cambia el color de fondo del tooltip */
    border-radius: 5px; /* Opcional: redondea los bordes del tooltip */
    padding: 10px; /* Opcional: agrega espacio interno al tooltip */
  }
  .carousel-control-prev,
  .carousel-control-next {
        position: absolute;
        top: 0%;
        width: auto;
        height: auto;
        color: black;
    }

    .carousel-control-prev {
        left: -10px;
    }

    .carousel-control-next {
        right: -10px;
    }

    .dropright .dropdown-toggle::after {
      display:none;
    }
  /*Mostrar la carga del icono*/
  .lazy-load {
      filter: blur(5px);
      transition: filter 0.3s;
  }

  .lazy-load.loaded {
      filter: blur(0);
  }
</style>

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-9">
				<h1 class="m-0">Tu Huella en ReconoSER</h1>
        <span>Cada reconocimiento refleja tu impacto. Descubre cómo contribuyes al equipo y cómo puedes seguir creciendo.</span>
			</div>
			<!-- /.col -->
			<div class="col-sm-3">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item active">Mis reconocimientos</li>
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
                @if(isset($morecat['morecat']->nomcat))
                  <p class="m-0">Tu categoría más <br>reconocida es:</p>
                  <h5> {{ $morecat['morecat']->nomcat }}</h5>
                  <p class="m-0">¡Sigue brillando!</p>  
                @else
                  <p class="m-0">Aún no tienes una categoría destacada.</p>
                  <br>
                  <p class="m-0">¡Pronto lo lograrás! </p>  
                @endif
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
                @if(isset($morecat['percentil']))
                 @if($morecat['percentil'] > 50) 
                    <h3> {{ $morecat['percentil'] }} % </h3>
                    <p class="m-0">Este 
                    @if($fecini && $fecfin)
                      periodo
                    @else
                      mes,
                    @endif
                      recibiste más reconocimientos que el {{ $morecat['percentil'] }}% de tus compañeros.</p>
                 @else
                    <h3> 0% </h3>
                    <p class="m-0">Aún no has recibido reconocimientos este mes. ¡Anímate!</p>
                 @endif
                @endif
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Destaca tu tambien a los demás <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              @if(isset($morecat['userenvia']->nombre)) 
                <p class="m-0">Tu mayor reconocimiento proviene de</p>
                <h5>{{ $morecat['userenvia']->nombre }} {{ $morecat['userenvia']->apellido }} </h5>
                <p class="m-0">¡valora esa conexión!</p>  
              @else
                <p class="m-0">Aún no tienes un reconocimiento destacado</p>
                <br>
                <p class="m-0">¡Sigue esforzándote, tu trabajo será valorado!</p>  
              @endif
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">Reconocelo ahora <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              @if(isset($morecat['topx']))
                @if($morecat['topx'] > 50)
                  <h3>0 %</h3>
                  <p class="m-0">Aún no estás en el Top de colaboradores más reconocidos este trimestre.</p>  
                @else
                  <h3>{{ $morecat['topx'] }}%</h3>
                  <p class="m-0">Te encuentras en el Top {{ $morecat['topx'] }}% de colaboradores más reconocidos 
                    este
                    @if($fecini && $fecfin)
                      periodo
                    @else
                      trimestre.
                    @endif
                   </p>  
                @endif
              @endif
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
                        <form action="{{route('filtrarReconocimientos')}}" method="POST">
                          @csrf
                          <div class="form-group row m-0" style="display: flex;align-items: center;">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha inicial y final</label>
                            <div class="col-sm-10 filtro-fecha">
                              <input type="date" aria-label="First name" class="form-control" name="fecini" id="fecini" max="{{ $fecha }}" value="{{ $fecini }}" required>
                              <input type="date" aria-label="Last name" class="form-control" name="fecfin" id="fecfin" max="{{ $fecha }}" value="{{ $fecfin }}" required>
                              <button class="btn btn-primary" role="button" type="submit"> <i class="fas fa-search"></i></button>
                            </div>
                            
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
                      Reconocimientos
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                      Recompensas 
                    </a>
                  </li>
                  <li class="pt-2 px-3">
                    
                  </li>
                </ul>
              </div>
              <div class="card-body">
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <div class="">
                  <div class="row">
                    <div class="col-md-3">

                      <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-medal"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Tienes un total de </span>
                          <span class="info-box-number">@if(is_countable($detalle) && count($detalle) > 0) {{count($detalle)}} @else 0 @endif reconocimientos</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->

                      <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-star"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Por categorias:</span>

                          <!-- Dropdown menu links -->
                          <!--############################################--->
                          @if($esta != 0)
                            @php
                                $datosgraf = [];
                            @endphp
                            <ul class="m-0">
                                @foreach($recibidos as $c)
                                    @foreach($categoria as $index => $cat)
                                        @php
                                            $attr = 'c' . ($index + 1);
                                        @endphp
                                        @if(isset($c->$attr))
                                            @php
                                                $datosgraf[] = [
                                                        'descrip' => $cat->descripcion,
                                                        'valor' => $c->$attr
                                                    ];
                                            @endphp
                                            <li class="" style="display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #cdcdcd;">
                                                {{$cat->descripcion}}: <span class="info-box-number">{{$c->$attr}}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                @endforeach
                            </ul>
                    
                        @endif
                          <!---##############################################-->
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->

                      <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-star"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Reconocimientos de {{ \Carbon\Carbon::parse($mes)->locale('es')->translatedFormat('F') }}</span>
                          <span class="info-box-number">{{$rmes}}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->

                      <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-coins"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text"> @if(isset($nompuntos->descripcion)) {{ $nompuntos->descripcion }} @endif</span>
                          <span class="info-box-number">@if(isset($puntos->p)) {{ $puntos->p }} @endif</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->

                    </div>

                    <div class="col-md-9">
                      <!---====================spiner===========--->
                      <div class="text-center">
                        <div id="loader" class="spinner-border text-primary text-center mt-3 mb-3" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                      </div>
                      <!---====================================--->

                      <div class="row">
                        <div class="col-12">
                          <div class="card card-primary">
                            <div class="card-header " >
                              <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Comparativa de Categorías
                              </h3>
                              <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link  active" href="#dona-chart" data-toggle="tab">Gráfica</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="#linea-chart" data-toggle="tab">Línea tiempo</a>
                                  </li>
                                  
                                </ul>
                              </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                              <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane  active" id="dona-chart">
                                  <div class="row" style="align-items: center;">
                                    <div class="col-md-4">   
                                     <canvas id="donutChart" style="min-height: 200px; height: 200px; max-height: 200px; max-width: 100%;"></canvas>
                                    </div>
                                    <div class="col-md-8">  
                                      <!-- Tu Destacado y Tu Próximo Reto -->
                                      @php
                                          $datosrev = collect($datosgraf);
                                          //valor máximo y mínimo con description
                                          if ($datosrev->isNotEmpty()) {
                                              $max = $datosrev->sortByDesc('valor')->first(); // valor max
                                              $min = $datosrev->sortBy('valor')->first(); // valor min
                                          }
                                      @endphp
                                      <div class="row">
                                        @if($datosrev->isNotEmpty())
                                          <div class="col-md-12">
                                              <div class="callout callout-success">
                                                <strong>Tu Categoría Más Reconocida:</strong>
                                                <p class="mb-2">{{ $max['descrip'] }} con <strong>{{ $max['valor'] }}</strong> reconocimientos</p>
                                                <p>🔥 ¡Eres un referente en colaboración! Tu equipo valora tu compromiso.</p>
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <div class="callout callout-warning">
                                                <strong>Tu oportunidad de Brillar Más:</strong>
                                                <p class="mb-2"> {{ $min['descrip'] }} con <strong>{{ $min['valor'] }}</strong> reconocimientos</p>
                                                <p>🚀 Tu equipo reconoce tu colaboración, ¿por qué no sumarle más momentos de aprendizaje?</p>
                                              </div>
                                          </div>
                                        @endif

                                      </div> 
                                    </div>
                                  </div>  
                                </div>
                                <div class="chart tab-pane " id="linea-chart" style="">
                                  <div class="chart">
                                    <canvas id="timelineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                  </div>
                                </div>
                                
                              </div>
                            </div><!-- /.card-body -->
                          </div>
                        </div>
                      </div>
                      
                      <div class="row"> 
                        <div class="col-12"> 
                           <h4 class="mt-4" style="color: var(--dark);">Historial de Reconocimientos</h4>
                        </div>
                      </div>

                      <div class="row card-group"> 
                      @foreach($detalle as $det)
                        <div class="col-md-4">
                        <div class="card card-primary card-widget show" id="cards{{$det->idcat}}">
                          <div class="card-header py-2 px-3">	
                            <div class="w-100 text-center">
                              <div class="user-block w-100">
                                <!--foto de perfil -->
                                <img class="profile-user-img img-circle loaded" src="{{asset('dist/imgperfil/'.$det->fperfil)}}" alt="User Avatar">
                                <span class="h6" style="color: #fff;">¡Te reconocio {{$det->nomenvia}} {{$det->apenvia}}!</span>
                              </div>
                              <!--foto medalla -->
                              <!--<img class="medallas" src="/dist/img/medalla_1.png" alt="medallas">-->
                              <img data-src="{{asset('imgpremios/'.$det->img)}}" class="medallas-muro img-circle lazy-load" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">
                              
                            </div>
                            <!-- /.user-block -->
                          </div>
                          <div class="card-body">
                          
                              
                              <span class="nomcate letratarjeta1">🏆 En la categoría: </br><strong>{{$det->descat}}</strong></span></br> 
                              <span class="nomcate letratarjeta1">
                                  <!-- validar que solamente aparezcan 15 palabras -->
                                  @php
                                      $descripcion = $det->det;
                                      $palabras = explode(' ', $descripcion);
                                      $idcat = $det->idcat;
                                  @endphp
                                  @if(count($palabras) > 15)
                                      <h6 id="descripcion-corta{{$idcat}}">{{ implode(' ', array_slice($palabras, 0, 15)) }}...</h6>
                                      <h6 id="descripcion-completa{{$idcat}}" class="d-none">{{ $descripcion }}</h6>
                                    
                                      <a id="toggle-text{{ $idcat }}" onclick="toggleText({{ $idcat }})" class="btn btn-link p-0 text-sm">Ver más</a>
                                  @else
                                      <span>🌟 Comportamiento:{{ $descripcion }} </span></br> 
                                  @endif
                              </span>
                              📅 {{ \Carbon\Carbon::parse($det->fecha)->format('j/m/Y') }} </br> 
                              <i class="fas fa-star text-warning"></i><span> {{$nompuntos->descripcion}}: </span><span class="punto">{{$det->puntos}} </span>
                              <a type="button" class="btn btn-warning w-100">
                                    Reconoce a {{$det->nomenvia}} 
                              </a>
                          </div>
                            <div class="card-body pt-0">
                              <p class="compor letratarjeta1"></p>
                              <!---emoticones -->
                                @foreach($emoticones as $emti)
                                        @if($det->idcat == $emti->idrec)
                                          @if($emti->idemot == 1)
                                          <a type="button" class="position-relative mr-4" style="cursor: default;">
                                            <span>👍</span>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">{{$emti->count}}</span>
                                          </a>
                                          @elseif($emti->idemot == 2)
                                          <a type="button" class="position-relative mr-4" style="cursor: default;">
                                            <span>😍</span>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">{{$emti->count}}</span>
                                          </a>
                                          @elseif($emti->idemot == 3)
                                          <a type="button" class="position-relative mr-4" style="cursor: default;">
                                            <span>😲</span>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">{{$emti->count}}</span>
                                          </a>
                                          @elseif($emti->idemot == 4)
                                          <a type="button" class="position-relative mr-4" style="cursor: default;">
                                              <span>🤗</span>
                                              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">{{$emti->count}}</span>
                                          </a>
                                          @endif
                                        @endif
                                @endforeach
                                <!---personas que reaccionaron-->
                                <div class="btn-group dropright text-right">
                                  <a type="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                  </a>
                                  <div class="dropdown-menu">
                                    <!--info-->
                                    <ul class="list-group list-group-flush">
                                    @foreach($usureac as $usur)
                                        @if($det->idcat == $usur->idrec)
                                        <li class="list-group-item text-sm">{{$usur->emoticon}} {{$usur->name}} {{$usur->apellido}}</li>
                                        @endif
                                      @endforeach
                                      </ul>
                                    <!--end info-->
                                  </div>
                                </div>
                            
                                <!--end emoticones-->
                                <hr>
                                <!---carrucel --->
                                <div id="carousel{{$det->idcat}}" class="carousel slide" data-interval="false" >
                                  <div class="carousel-inner">
                                    @php
                                      $first = true;
                                      $commentsChunk = $comentarios->where('idrec', $det->idcat)->chunk(3);
                                    @endphp
                                    @foreach($commentsChunk as $chunk)
                                      <div class="carousel-item {{ $first ? 'active' : '' }}">
                                        <div class="row">
                                          @foreach($chunk as $comen)
                                            <div class="col-md-4 col-lg-4 col-sm-4 col-4 px-1">
                                              <div class="text-center">
                                              <div data-toggle="tooltip" data-html="true" title="<div><span class='font-italic'> {{ $comen->nombre }} {{ $comen->apellido }}: </span><strong> {{$comen->comentario}}</strong></div>">
                                                <span class="">{{ explode(' ', trim($comen->nombre))[0] }}</span><br>
                                                <img data-src="{{asset('dist/imgperfil/'.$comen->imagen)}}" class="lazy-load profile-user-img img-circle loaded w-100" alt="User Image" style="height: 70px;">
                                              </div>
                                              </div>
                                            </div>
                                          @endforeach
                                        </div>
                                      </div>
                                      @php
                                        $first = false;
                                      @endphp
                                    @endforeach
                                  </div>
                                  @if(count($commentsChunk)>0) <!--validar que aparezca el next-->
                                  <a class="carousel-control-prev" href="#carousel{{$det->idcat}}" role="button" data-slide="prev">
                                    <span class="fas fa-chevron-left" aria-hidden="true" style="color:black;"></span>
                                  </a>
                                  <a class="carousel-control-next" href="#carousel{{$det->idcat}}" role="button" data-slide="next">
                                    <span class="fas fa-chevron-right" aria-hidden="true" style="color:black;"></span>
                                  </a>
                                  @endif


                              </div>
                            </div>
                          </div>
                          
                        </div>
                        @endforeach 
                      </div>

                      <div class="row modal-footer justify-content-between px-0">
                        <button id="prev" class="btn btn-default" disabled>Atras</button>
                        <button id="next" class="btn btn-primary">Siguiente</button>
                      </div>

                    </div>
                  </div>
                </div>

                  
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                
                <div class="">
                  <div class="row">
                    <div class="col-md-3">

                      <!---modal--->
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning w-100 mb-2" data-toggle="modal" data-target="#modalInsignias">
                              Insignias a obtener
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="modalInsignias" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title" style="color: #333333"> Insignias y Recompensas</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <p>Cuantos más puntos acumules, más insignias podrás ganar. Cada insignia representa tu esfuerzo y está vinculada a una recompensa especial. 🚀</p>
                                  
                                    <div class="table-responsive">
                                    <table class="table table-hover table-estadisticas">
                                      <thead class="tablaheader">
                                        <tr>
                                          <th scope="col"></th>
                                          <th scope="col">Insignia</th>
                                          <th scope="col">Nivel</th>
                                          <th scope="col">Puntos</th>
                                          <th scope="col">Recompensa</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($insobtener as $ins)
                                        <tr>
                                          <td><img data-src="{{asset('imgpremios/'.$ins->imgin)}}" class="profile-user-img img-circle loaded lazy-load" alt="User Image"></td>
                                          <td>{{$ins->name}}</td>
                                          <td>{{$ins->descripcion}}</td>
                                          <td>{{$ins->puntos}}</td>
                                          <td>{{$ins->despre}}</td>
                                        </tr>
                                      @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                  </div>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              
                              </div>
                            </div>
                        <!---end modal -->
                        <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-medal"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Has desbloqueado </span>
                          <span class="info-box-number">{{count($reconocimientos)}}  insignias </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->

                      <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-star"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Recompensas de {{ \Carbon\Carbon::parse($mes)->locale('es')->translatedFormat('F') }}</span>
                          <span class="info-box-number">{{$inmes}}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->

                      <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-star"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text"> Has acumulado </span>
                          <span class="info-box-number">1200 puntos</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->

                     <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-coins"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">¡Estás a solo</span>
                          <span class="info-box-number">300</span>
                          <span class="info-box-text">puntos de tu próxima recompensa especial!</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->

                    </div>

                    <div class="col-md-9">
                      
                   
                      <div class="row">
                        <div class="col-md-12">
                      
                        </div>
                      </div> 
                     
                      <div class="row">
                        <div class="col-12">
                          <div class="card card-primary">
                            <div class="card-header " >
                              <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Tus insignias 
                              </h3>
                              <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                  <li class="nav-item">
                                    <a class="nav-link   active" href="#linea-chart1" data-toggle="tab">Línea tiempo</a>
                                  </li>
                                </ul>
                              </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                              <div class="tab-content p-0">
                                <div class="chart tab-pane   active" id="linea-chart1" style="">
                                  <div class="chart">
                                    <canvas id="timelineChart11" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                  </div>
                                </div>
                                
                              </div>
                            </div><!-- /.card-body -->
                          </div>
                        </div>
                      </div>
                      <!--------------------------end header--->
                      
                        <div class="row row-cols-1 row-cols-md-3 letratarjeta3">
                        @foreach($reconocimientos as $r)
                          <div class="col mb-4">
                            <div class="card card-primary card-widget h-100">
                            <!---header card -->
                            <div class="card-header py-2 px-3">	
                            <div class="w-100 text-center">
                              <div class="user-block w-100">
                                <!--foto de perfil -->
                                <img data-src="{{asset('imgpremios/'.$r->imginsig)}}" class="profile-user-img img-circle loaded" alt="User Image" >
                                
                                <span class="h6" style="color: #fff;">{{$r->catinsign}}</span>
                                <p>{{$r->nominsig}}</p>
                              </div>
                              
                            </div>
                            <!-- /.user-block -->
                          </div>

                            
                            <!--end header-->
                              <div class="card-body">
                              <!---card contenido -->
                                <div class="row">
                                    <div class="col-lg-12">
                                      <img data-src="{{asset('imgpremios/'.$r->imgpremio)}}" class=" elevation-1 lazy-load w-100" alt="User Image"> 
                                      <span class="badge badge-warning text-left" style="color:black;top: 15px;position: absolute;right: 15px;"> 
                                        Puntos: {{$r->puntosin}}</span>
                                    </div>
                                    <div class="col-lg-12">
                                      <h5>{{$r->nompremio}}</h5>
                                      @if($r->entregado == 1)
                                        <span class="badge badge-secondary py-2 w-100"> Sin entregar</span>
                                      @else
                                        <span class="badge badge-success py-2 w-100">Entregado</span>
                                      @endif
                                    </div>
                                </div>
                              <!--- end card contenido-->
                              </div>
                              <!---footer -->
                              <div class="card-footer">
                                  <small class="text-muted"> {{ \Carbon\Carbon::parse($r->fecha)->locale('es')->translatedFormat('j \\d\\e F \\d\\e Y, g:i a') }}</small>
                              </div>
                              <!---end footer-->
                            </div>
                          </div>
                        @endforeach
                        <!--------->
                        </div>
                      <!--------------------------------------------end reconocimientos--------------------------->

                    </div>
                  </div>
                </div>  
                  <!--------------------------------------------end reconocimientos--------------------------->
                   
                
                </div>
              </div>
              <!------------------------------------------end navegacion-------------------------------->
              </div>
              <!-- /.card -->
            </div>
      </div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->


<!---####################collapsed--->
  @if($esta==0)
    <div class="alert alert-info alert-dismissible fade show letraform" role="alert">
      <strong>No tienes Reconocimentos!</strong>&nbsp;Espera Pronto te reconoceran&nbsp;<i class="fas fa-smile" style="color:yellow;"></i>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
<!---#######################---> 
<!--- modificaciones -->
{{-- 
<div class="card">
       
  </div>--}}
<!------##############script para que funcione el html en toottips#############-->

<script> 
    let datos = @JSON($datosgraf);
    window.datos=datos;
    //reconocimientos en el tiempo
    let rectime = @JSON($rectime);
    window.rectime = rectime;
    
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });

  </script>
<script src="{{ asset('js/cards.js')}}"></script>
<script>
    window.onload = function() {
        setTimeout(function() {
            // Ocultar el loader
            document.getElementById('loader').style.display = 'none';
            document.getElementById('collapseTree').style.display = 'block';
            
        }, 1000); // Tiempo de espera en milisegundos (3 segundos)

    };
</script>

@endsection
