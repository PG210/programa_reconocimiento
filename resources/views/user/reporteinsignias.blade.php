@extends('usuario.principa_usul')
@section('content')
<style>
      .tooltip-inner {
        color: #ffffff; /* Cambia el color del texto del tooltip */
        background-color: #333333; /* Cambia el color de fondo del tooltip */
        border-radius: 5px; /* Opcional: redondea los bordes del tooltip */
        padding: 10px; /* Opcional: agrega espacio interno al tooltip */
      }
      .carousel-control-prev,
      .carousel-control-next {
            position: absolute;
            top: 80%;
            width: auto;
            height: auto;
            color: black;
        }

        .carousel-control-prev {
            left: 10px;
        }

        .carousel-control-next {
            right: 10px;
        }

        .dropright .dropdown-toggle::after {
          display:none;
        }
</style>
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
    <!------------------------------------------navegacion ------------------------------------>
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border-radius:10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3); background-color:#ECE9E9;">
        <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><h5 style="color:black;"><b>Reconocimientos  </b></h5></button>
        <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><h5 style="color:black;"><b>Recompensas  </b></h5></button>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
          <!----------------------------------------- reconocimientos --------------------------------------->
            <div class="card-header letratarjeta3" id="headingTree" style="background-image: url('{{ asset('dist/img/estrellasfondo.gif') }}');">
                <div class="row mt-3">
                <div class="col-lg-1 col-md-1 col-sm-12 text-center">
                  <div class="bg-warning py-2 text-white text-center" style="border-radius:10px;  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
                  <span> <i class="fas fa-medal"></i> {{count($detalle)}} </span>
                  </div>
                    <span class="badge badge-primary" style="white-space:normal;">Total</span>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 text-center">
                  <div class="bg-warning py-2 text-white text-center" style="border-radius:10px;  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
                    <span><i class="fas fa-star"></i> {{$rmes}}</span>
                  </div>
                  <span class="badge badge-primary" style="white-space:normal;">Mes {{ \Carbon\Carbon::parse($mes)->locale('es')->translatedFormat('F') }}</span><br>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <!---filtros de busqueda -->
                    <form action="{{route('filtrarReconocimientos')}}" method="POST">
                      @csrf
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Fecha inicial y final</span>
                        </div>
                        <input type="date" aria-label="First name" class="form-control" name="fecini" id="fecini" max="{{ $fecha }}" value="{{ $fecini }}" required>
                        <input type="date" aria-label="Last name" class="form-control" name="fecfin" id="fecfin" max="{{ $fecha }}" value="{{ $fecfin }}" required>
                        <button class="btn btn-primary" role="button" type="submit"> <i class="fas fa-search"></i></button>
                    </div>
                  </form>
                    <!--end filtros-->
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 text-lg-right">
                    <!---reporte por categorias -->
                    <div class="btn-group dropleft">
                      <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                      Total por categorias
                      </button>
                      <div class="dropdown-menu">
                        <!-- Dropdown menu links -->
                        <!--############################################--->
                          @if($esta != 0)
                          <ul class="list-group">
                            @foreach($recibidos as $c)
                                  @foreach($categoria as $index => $cat)
                                    @php
                                      $attr = 'c' . ($index + 1);
                                    @endphp
                                    @if(isset($c->$attr))
                                    <li class="list-group-item small"> <span> {{$cat->descripcion}}: {{$c->$attr}}</span></li>
                                    @endif
                                  @endforeach
                            @endforeach
                          </ul>
                          @endif
                          <!---##############################################-->

                      </div>
                    </div>
                    <!---end reporte de categorias -->
                </div>
                </div>
                <!--end puntos-->
            </div>
            <div id="collapseTree" class="collapse show" aria-labelledby="headingTree" data-parent="#accordionExample">
              <div class="card-body letraform">
                <!--################-->
                <div class="card-group">
                @foreach($detalle as $det)
                <div class="card show mr-2" style="border-radius:10px;" id="cards{{$det->idcat}}">
                  <div class="container" style="background-color:#131535; border-top-left-radius: 5px; order-top-right-radius: 5px; padding:1rem;">
                    <div class="row">
                      <div class="col-lg-8">
                        <span class="badge badge-info" style="white-space:normal;"><i class="nav-icon fas fa-award"></i>&nbsp;{{$det->descat}}</span><br>
                        <span class="badge badge-warning text-left" style="color:black;"> 
                          {{$det->puntos}} {{$nompuntos->descripcion}}
                        </span>
                      </div>
                      <div class="col-lg-4 text-right">
                        <img src="{{asset('imgpremios/'.$det->img)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="user-panel mt-3 pb-3 d-flex">
                          <div class="image">
                            <img src="{{asset('dist/imgperfil/'.$det->fperfil)}}" class="img-circle elevation-2" alt="User Image">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-9">
                        <h6>{{$det->det}}</h6>
                        <p class="text-muted small">Por: {{$det->nomenvia}} {{$det->apenvia}}</p>
                      </div>
                    </div>
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
                    <hr style="margin:0px;">
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
                                <div class="col-md-4 col-lg-4 col-sm-4 col-4">
                                  <div class="image-container py-3 text-black text-center">
                                  <div data-toggle="tooltip" data-html="true" title="<div><span class='font-italic'> {{ $comen->nombre }} {{ $comen->apellido }}: </span><strong> {{$comen->comentario}}</strong></div>">
                                    <span class="text-sm text-wrap">{{ explode(' ', trim($comen->nombre))[0] }}</span><br>
                                    <img src="{{asset('dist/imgperfil/'.$comen->imagen)}}" class="img-circle elevation-1 img-hover" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">
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
                    <!------------->
                  </div>
                  <div class="card-footer">
                    <small class="text-muted">{{ \Carbon\Carbon::parse($det->fecha)->locale('es')->translatedFormat('j \\d\\e F \\d\\e Y, g:i a') }}</small>
                  </div>
                </div>
              @endforeach
              </div>
                <!---botones -->
                <div class="mt-3">
                  <button id="prev" class="btn btn-primary btn-sm" disabled>Atras</button>
                  <button id="next" class="btn btn-primary btn-sm">Siguiente</button>
                </div>
                <!---###############--->
              </div>
            </div>
            <!--------------------------------------------end reconocimientos--------------------------->
      </div>
      <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <!--------------------------------------------end reconocimientos--------------------------->
           <div class="card-header letratarjeta3" id="headingTree02" style="background-image: url('{{ asset('dist/img/confeticom.gif') }}');">
              <div class="row mt-3">
                <div class="col-lg-1 col-md-1 col-sm-12 text-center">
                  <div class="bg-warning py-2 text-white text-center" style="border-radius:10px;  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
                  <span> <i class="fas fa-trophy"></i> {{count($reconocimientos)}} </span>
                  </div>
                    <span class="badge badge-primary" style="white-space:normal;">Total</span>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 text-center">
                  <div class="bg-warning py-2 text-white text-center" style="border-radius:10px;  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
                    <span><i class="fas fa-star"></i> {{$inmes}}</span>
                  </div>
                  <span class="badge badge-primary" style="white-space:normal;">Mes {{ \Carbon\Carbon::parse($mes)->locale('es')->translatedFormat('F') }}</span><br>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-10 text-right">
                  <!---modal--->
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalInsignias">
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
                                <td><img src="{{asset('imgpremios/'.$ins->imgin)}}" class="img-responsive" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;"></td>
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
                </div>
              </div>
            <!--end puntos-->
        </div>
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
                      <img src="{{asset('imgpremios/'.$r->imginsig)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;">
                    </div>
                  </div>
                </div>
               <!--end header-->
                <div class="card-body">
                 <!---card contenido -->
                   <div class="row">
                      <div class="col-lg-5">
                        <img src="{{asset('imgpremios/'.$r->imgpremio)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width:50px; height: 50px;"> 
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
<!------##############script para que funcione el html en toottips#############-->
<script> 
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
<!---script para cards--->
<script>
    $(document).ready(function() {
      const cards = $('.card-group .card');
      let currentIndex = 0;
      const cardsPerPage = getCardsPerPage();

      /*Tamanio de la pantalla*/
      function getCardsPerPage() {
            const width = $(window).width();
            if (width >= 992) { // Pantallas grandes (>= 992px)
                return 3;
            } else { // Pantallas medianas y pequeñas
                return 2;
            }
        }

      function updateCards() {
        cards.removeClass('show').hide();
        for (let i = currentIndex; i < currentIndex + cardsPerPage; i++) {
          if (i < cards.length) {
            $(cards[i]).addClass('show').fadeIn();
          }
        }
        $('#prev').prop('disabled', currentIndex <= 0);
        $('#next').prop('disabled', currentIndex + cardsPerPage >= cards.length);
      }

      $('#next').click(function() {
        if (currentIndex + cardsPerPage < cards.length) {
          currentIndex += cardsPerPage;
          updateCards();
        }
      });

      $('#prev').click(function() {
        if (currentIndex - cardsPerPage >= 0) {
          currentIndex -= cardsPerPage;
          updateCards();
        }
      });
      /*Detecta la pantalla cambia de tamanio */
      $(window).resize(function() {
            cardsPerPage = getCardsPerPage();
            currentIndex = 0; // Reiniciar a la primera página
            updateCards();
        });

      updateCards();
    });
  </script>
   <script>
        document.getElementById('fecini').addEventListener('change', function() {
            var fecini = document.getElementById('fecini').value;
            document.getElementById('fecfin').min = fecini;
        });
    </script>
@endsection
