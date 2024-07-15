@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert" style="background-image: url('{{ asset('dist/img/estrellasfondo.gif') }}');">
  <h3><b>RECONOCIMIENTOS RECIBIDOS</b></h3>
</div>
<br> 
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
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        <h5 class="letratarjeta3"><i class="fas fa-star" style="color:#5959D1;"></i>&nbsp;Tabla De Resultados</h5>
        </button>
      </h2>
    </div>
    
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body letraform">
       <!--############################################--->
        <table class="table table-responsive">
                  <thead>
                  <tr style="background-color:#ffbd03;">
                  @if($esta!=0)
                      <th scope="col"></th>
                        @foreach($categoria as $cat)
                        <th scope="col">{{$cat->descripcion}}</th>
                        @endforeach
                      <th scope="col"></th>
                  @endif
                  </tr>
                  </thead>
                  <tbody>
                    @if($esta != 0) 
                    <?php
                      $con = count($categoria);
                      ?>
                    @foreach($recibidos as $c)
                      <tr>
                        <th>{{$c->nombre}} {{$c->ape}}</th>
                        @for($i = 1; $i <= $con; $i++)
                           @if(isset($c) && isset($c->{'c'.$i}))
                          <td>{{$c->{'c'.$i} }}</td>
                           @endif
                        @endfor
                        <td>
                          <button type="button" class="btn confirmar" data-toggle="modal" data-target="#staticBackdrop">
                            Detalle
                          </button>
                        </td>
                      </tr>
                    @endforeach
                  @endif
                  </tbody>
                  </table>
       <!---##############################################-->
        <!--############-->
         <!-- Button trigger modal -->
                      <!-- Modal -->
                      <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="staticBackdropLabel">Detalle De Reconocimentos</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <!-------datos de usuarios quien envia-->
                              @if($esta!=0)
                                    <?php
                                         $contab=1;
                                    ?>
                                    @foreach($detalle as $d)
                                    <div class="accordion" id="accordionExampledet1{{$d->idcat}}">
                                        <div class="card"  style="background-color:#F5F5F5;">
                                          <div class="card-header" id="headingTwodet1{{$d->idcat}}">
                                            <h2 class="mb-0">
                                              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwodet1{{$d->idcat}}" aria-expanded="false" aria-controls="collapseTwodet1{{$d->idcat}}">
                                                 <i class="fas fa-sort" style="color:#2ED5F4; font-size:24px;"></i>
                                                 <span class="float-right" style="color:black; font-size:16px;" >{{date('Y-m-d', strtotime($d->fecha))}}</span>
                                              </button>
                                            </h2>
                                          </div>
                                          <div id="collapseTwodet1{{$d->idcat}}" class="collapse" aria-labelledby="headingTwodet1{{$d->idcat}}" data-parent="#accordionExampledet1{{$d->idcat}}">
                                            <div class="card-body">
                                              <!--card body-->
                                              <div class="row">
                                              <div class="col-8">
                                                <b> Enviado por: </b> {{$d->nomenvia}} {{$d->apenvia}}
                                               </div>
                                               <div class="col-4 text-right">
                                               <i class="fas fa-heart" style="color:#0070B8; font-size:20px;"></i>
                                                  <span class="badge badge-warning text-left" style="color:white; font-size: 0.875em;"> 
                                                    {{$d->puntos}} {{$nompuntos->descripcion}}
                                                  </span>
                                               </div>
                                              </div>
                                              <hr>
                                              <div class="row">
                                              <div class="col-12 text-justify">
                                                <b> Detalle: </b> {{$d->det}}
                                               </div>
                                              </div>
                                              <hr>
                                              <div class="row">
                                              <div class="col-6">
                                                <b>Categoria: </b> {{$d->descat}}
                                               </div>
                                               <div class="col-6 text-justify">
                                                <b>Comportamiento:</b> {{$d->comportamiento}}
                                               </div>
                                              </div>
                                             <!--end-card-body-->
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      @endforeach 
                                      @endif
                                                                    <!------datos de usuarios envian-->
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn salir" data-dismiss="modal">Salir</button>
                            </div>
                          </div>
                        </div>
                      </div>

        <!----##############--->
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        <h5 class="letratarjeta3"><i class="fas fa-dice" style="color:#5959D1 ;"></i>&nbsp;Tabla De {{$nompuntos->descripcion}}</h5>
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body letraform">
        <!--################-->
        <table class="table table-responsive">
                    <thead>
                    <tr style="background-color:#ffbd03;">
                    @if($esta!=0)
                        <th scope="col"></th>
                        @foreach($puntos as $n)
                        <th scope="col">{{$n->nom}}</th>
                        @endforeach
                    @endif
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                      @if($esta!=0)
                        <th>{{auth()->user()->name}} {{auth()->user()->apellido}}</th>
                        @foreach($puntos as $pun)
                        <th >{{$pun->p}}</th>
                        @endforeach
                      @endif
                       </tr>
                    </tbody>
          </table>
          <!---###############--->
      </div>
    </div>
  </div>
</div>
<!------###########################-->
@endsection
