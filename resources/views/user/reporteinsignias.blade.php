@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center" role="alert" style="background-image: url('{{ asset('dist/img/estrellasfondo.gif') }}');">
  <h3><b>Reconocimientos Recibidos</b></h3>
</div>
<br> 
<!---####################collapsed--->
  @if($esta==0)
    <div class="alert alert-info alert-dismissible fade show" role="alert">
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
        <h5><i class="fas fa-star" style="color:#5959D1;"></i>&nbsp;Tabla De Resultados</h5>
        </button>
      </h2>
    </div>
    
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
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
                  @if($esta!=0)
                    @foreach($recibidos as $c)
                      <tr>
                      <th >{{$c->nombre}} {{$c->ape}}</th>
                      <td>{{$c->c1}}</td>
                      <td >{{$c->c2}}</td>
                      <td >{{$c->c3}}</td>
                      <td >{{$c->c4}}</td>
                      <td >{{$c->c5}}</td>
                      <td >
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                            Detalle
                          </button>
                      </td>
                      <!---comparar las categorias en un if(cat==1 document.get.elementid(#col2))-->
                      <!--para colocar los datos con inner en los ids-->
                      <!--tr debe de ir con un id del usuario-->
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
                              <table class="table">
                                      <thead>
                                        <tr style="background-color:#2ED5F4;" >
                                          <th scope="col">No</th>
                                          <th scope="col">Envia</th>
                                          <th scope="col">Categoria</th>
                                          <th scope="col">Comportamiento</th>
                                          <th scope="col">Detalle</th>
                                          <th scope="col">Puntos</th>
                                          <th scope="col">Fecha</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      @if($esta!=0)
                                        <?php
                                         $conta=1;
                                        ?>
                                        @foreach($detalle as $det)
                                        <tr>
                                          <th scope="row">{{$conta++}}</th>
                                          <td>{{$det->nomenvia}} {{$det->apenvia}}</td>
                                          <td>{{$det->descat}}</td>
                                          <td>{{$det->comportamiento}}</td>
                                          <td>{{$det->det}}</td>
                                          <td>{{$det->puntos}}</td>
                                          <td>{{$det->fecha}}</td>
                                        </tr>
                                        @endforeach 
                                      @endif
                                      </tbody>
                                    </table>
                                                                    <!------datos de usuarios envian-->
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
        <h5><i class="fas fa-dice" style="color:#5959D1 ;"></i>&nbsp;Tabla De Puntos</h5>
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
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
