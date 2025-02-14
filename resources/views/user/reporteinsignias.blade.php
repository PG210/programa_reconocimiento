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
			<div class="col-sm-8">
				<h1 class="m-0">Mis reconocimientos</h1>
			</div>
			<!-- /.col -->
			<div class="col-sm-4">
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
                          <span class="info-box-text">Total reconocimientos</span>
                          <span class="info-box-number">@if(is_countable($detalle) && count($detalle) > 0) {{count($detalle)}} @else 0 @endif </span>
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
                              <ul class="m-0">
                                @foreach($recibidos as $c)
                                @foreach($categoria as $index => $cat)
                                  @php
                                    $attr = 'c' . ($index + 1);
                                @endphp
                                  @if(isset($c->$attr))
                                  <li class="" style="display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #cdcdcd;">{{$cat->descripcion}}: <span class="info-box-number">{{$c->$attr}}</span></li>
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
                          <span class="info-box-text">Evos</span>
                          <span class="info-box-number">1,410</span>
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
                        <div class="col-md-12">
                        <!---filtros de busqueda -->
                        <form action="{{route('filtrarReconocimientos')}}" method="POST">
                          @csrf
                          <div class="form-group row">
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
                      </div> 

                      <div class="row card-group"> 
                      @foreach($detalle as $det)
                        <div class="col-md-4">
                        <div class="card card-primary card-widget show" id="cards{{$det->idcat}}">
                          <div class="card-header py-2 px-3">
                            <div class="w-100 text-right text-puntos">
                            <i class="fas fa-star text-warning"></i><span> {{$nompuntos->descripcion}}: </span><span class="punto">{{$det->puntos}} </span>
                            </div>	
                            <div class="w-100 text-center">
                              <!--foto medalla -->
                              <!--<img class="medallas" src="/dist/img/medalla_1.png" alt="medallas">-->
                              <img data-src="{{asset('imgpremios/'.$det->img)}}" class="img-circle elevation-1 lazy-load" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">
                              <span class="text-center"><h4 class="nomcate letratarjeta1">{{$det->descat}}<h4></span>
                            </div>
                            <!-- /.user-block -->
                          </div>
                          <div class="card-body">
                              <div class="user-block w-100">
                                <!--foto de perfil -->
                                <img class="profile-user-img img-circle loaded" src="{{asset('dist/imgperfil/'.$det->fperfil)}}" alt="User Avatar">
                                <span class="username h4 nomcate letratarjeta1">
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
                                      <h6> {{ $descripcion }} </h6>
                                  @endif
                                </span>
                                <span class="description">Por: {{$det->nomenvia}} {{$det->apenvia}} | {{ \Carbon\Carbon::parse($det->fecha)->locale('es')->translatedFormat('j \\d\\e F \\d\\e Y, g:i a') }} </span>
                              </div>

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
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body text-left text-md">
                                    <!---info ---->
                                    <h6 class="mb-3">
                                    Listado de insignias que puedes obtener: Cuantos más puntos acumules, más insignias podrás ganar. Cada insignia está vinculada a una recompensa especial.
                                    </h6>
                                    <div class="table-responsive">
                                    <table class="table">
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
                                          <td><img data-src="{{asset('imgpremios/'.$ins->imgin)}}" class="img-responsive lazy-load" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;"></td>
                                          <td>{{$ins->name}}</td>
                                          <td>{{$ins->descripcion}}</td>
                                          <td>{{$ins->puntos}}</td>
                                          <td>{{$ins->despre}}</td>
                                        </tr>
                                      @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                  <!-------------->
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <!---end modal -->
                        <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-medal"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Total recompensas</span>
                          <span class="info-box-number">{{count($reconocimientos)}} </span>
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

                    </div>

                    <div class="col-md-9">
                      

                      <div class="row">
                        <div class="col-md-12">
                        <!---filtros de busqueda -->
                        <form action="{{route('filtrarReconocimientos')}}" method="POST">
                          @csrf
                          <div class="form-group row">
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
                      </div> 

                      <div class="row card-group"> 
                      @foreach($reconocimientos as $r)
                      <div class="col-4 mb-4">
                        <div class="card h-100">
                        <!---header card -->
                        <div class="container" style="background-color:#131535; border-top-left-radius: 5px; order-top-right-radius: 5px; padding:1rem;">
                            <div class="row">
                              <div class="col-lg-8">
                                <span class="badge badge-info" style="white-space:normal;"><i class="nav-icon fas fa-award"></i>&nbsp;{{$r->catinsign}}</span><br>
                                <span class="badge badge-warning text-left" style="color:black;"> 
                                {{$r->nominsig}}
                                </span>
                              </div>
                              <div class="col-lg-4 text-right">
                                <img data-src="{{asset('imgpremios/'.$r->imginsig)}}" class="img-circle elevation-1 lazy-load" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">
                              </div>
                            </div>
                          </div>
                        <!--end header-->
                          <div class="card-body">
                          <!---card contenido -->
                            <div class="row">
                                <div class="col-lg-5">
                                  <img data-src="{{asset('imgpremios/'.$r->imgpremio)}}" class="img-circle elevation-1 lazy-load" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;"> 
                                  <span class="badge badge-warning text-left" style="color:black;"> 
                                    Puntos: {{$r->puntosin}}</span>
                                </div>
                                <div class="col-lg-7">
                                  <h6>{{$r->nompremio}}</h6>
                                  @if($r->entregado == 1)
                                    <span class="badge badge-secondary"> Sin entregar</span>
                                  @else
                                    <span class="badge badge-success">Entregado</span>
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

                      </div>

                      <div class="row modal-footer justify-content-between px-0">
                        <button id="prev" class="btn btn-default" disabled>Atras</button>
                        <button id="next" class="btn btn-primary">Siguiente</button>
                      </div>

                    </div>
                  </div>
                </div>  
                  <!--------------------------------------------end reconocimientos--------------------------->
                   
                  <!--------------------------end header--->
                  <div class="container p-3">
                    <div class="row row-cols-1 row-cols-md-3 letratarjeta3">
                    @foreach($reconocimientos as $r)
                      <div class="col mb-4">
                        <div class="card h-100">
                        <!---header card -->
                        <div class="container" style="background-color:#131535; border-top-left-radius: 5px; order-top-right-radius: 5px; padding:1rem;">
                            <div class="row">
                              <div class="col-lg-8">
                                <span class="badge badge-info" style="white-space:normal;"><i class="nav-icon fas fa-award"></i>&nbsp;{{$r->catinsign}}</span><br>
                                <span class="badge badge-warning text-left" style="color:black;"> 
                                {{$r->nominsig}}
                                </span>
                              </div>
                              <div class="col-lg-4 text-right">
                                <img data-src="{{asset('imgpremios/'.$r->imginsig)}}" class="img-circle elevation-1 lazy-load" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">
                              </div>
                            </div>
                          </div>
                        <!--end header-->
                          <div class="card-body">
                          <!---card contenido -->
                            <div class="row">
                                <div class="col-lg-5">
                                  <img data-src="{{asset('imgpremios/'.$r->imgpremio)}}" class="img-circle elevation-1 lazy-load" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;"> 
                                  <span class="badge badge-warning text-left" style="color:black;"> 
                                    Puntos: {{$r->puntosin}}</span>
                                </div>
                                <div class="col-lg-7">
                                  <h6>{{$r->nompremio}}</h6>
                                  @if($r->entregado == 1)
                                    <span class="badge badge-secondary"> Sin entregar</span>
                                  @else
                                    <span class="badge badge-success">Entregado</span>
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
<div class="card">
    
    
  </div>
<!------##############script para que funcione el html en toottips#############-->

<script> 
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
