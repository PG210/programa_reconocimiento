@extends('usuario.principa_usul')
@section('content')
<div class="alert text-center titulo" role="alert"  style="background-image: url('{{ asset('dist/img/confeticom.gif') }}');">
  <h3><b>INSIGNIAS OBTENIDAS</b></h3>
</div>
<br>
      @if($b==0)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>No tienes insignias!</strong> Espera, pronto obtendras una.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
    <!--aqui va la tabla de estrelllas--->   
        <div class="accordion" id="accordionExample">
        <div class="card">
          <div class="card-header" id="headingOne">
            <h2 class="mb-0">
              <div class="row">
               <div class="col-6">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <h5 class="letratarjeta3"><i class="fas fa-gift" style="color:#5959D1; font-size:22px;"></i>&nbsp;&nbsp;Insignias</h5>
                </button>
              </div>
              <div class="col-6">
                <a href="{{route('visinsignias')}}" type="button" class="btn float-right"><i class="fas fa-list-alt" style="color:#5959D1; font-size: 22px;"></i></a>
               </div>
             </div>
            </h2>
          </div>

          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
             <!-- aqui va la tabla de datos de insignias-->
             <div class="table-responsive letraform2">
                  <table class="table">
                    <thead class="letraform tablaheader">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Insignia</th>
                        <th scope="col">Nivel</th>
                        <th scope="col">Tipo recompensa</th>
                        <th scope="col">Recompensa</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Puntos</th>
                        <th scope="col"></th>
                      </tr>
                    </thead> 
                    <tbody>
                          <tr>
                              @if($b!=0)
                              <?php
                                $acum=1;
                              ?>
                                @foreach($rec as $r)
                                <td>{{$acum++}}</td>
                                <td>{{$r->nominsig}}</td>
                                <td>{{$r->catinsign}}</td>
                                <td>{{$r->despremio}}</td>
                                <td> {{$r->nompremio}}</td>
                                <td>{{date('Y-m-d', strtotime($r->fecha))}}</td>
                                <td>{{$r->puntos_acumulados}}</td>
                                <td>
                                  <!-- Button trigger modal -->
                                  <button type="button" class="btn confirmar" data-toggle="modal" data-target="#exampleModal{{$r->idinsig}}">
                                  <i class="icon-nav fas fa-eye"></i>
                                  </button>
                                  <!-- Modal -->
                                  <div class="modal fade" id="exampleModal{{$r->idinsig}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title titulo" id="exampleModalLabel">Detalles De La Insignia</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <!------------------------------------------------->
                                          <div class="table-responsive">
                                          <table class="table letraform">
                                            <thead style="background-color:#2ED5F4; color:white;">
                                              <tr>
                                                <th scope="col">Insignia</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Recompensa</th>
                                                <th scope="col">Detalle</th>
                                                <th scope="col"></th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                <td> <img src="{{asset('imgpremios/'.$r->imginsig)}}" class="img-fluid" alt="cargando imagen ..."  width= "50px" height="50px" ></td>
                                                <td ><br>{{$r->nominsig}} {{$r->catinsign}}</td>
                                                <td> <img src="{{asset('imgpremios/'.$r->imgpremio)}}" class="img-fluid" alt="cargando imagen ..."  width= "50px" height="50px" ></td>
                                                <td><br>{{$r->nompremio}} </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          </div>
                                          <!------------------------------------------------>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn salir" data-dismiss="modal">Salir</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                </td>
                              </tr>
                        @endforeach
                        @endif 
                    </tbody>
                  </table>
                  </div>  
             <!---end tabla datos de insignias-->
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="headingThree">
            <h2 class="mb-0">
              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              <h5 class="letratarjeta3"><i class="fas fa-medal" style="color:#5959D1; font-size:22px;"></i>&nbsp;&nbsp;Tabla De Insignias</h5>
              </button>
            </h2>
          </div>
          <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
            
            <!----table-->
            @if($b!=0)
            <table class="table table-responsive letraform">
                        <thead style="background-color:#08FFD5;">
                        <tr>
                        
                            <th scope="col"></th>
                            @foreach($insign as $n)
                            <th scope="col">{{$n->nom}} {{$n->des}}</th>
                            @endforeach
                        
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                         
                            <th>{{auth()->user()->name}} {{auth()->user()->apellido}}</th>
                            @foreach($insign as $cant)
                               
                              @if($cant->des =="Oro")
                              <th>
                                <!--<i class="fas fa-medal fa-2x" style="color:#ffbd03;"></i>-->
                                <img src="{{asset('imgpremios/'.$cant->rutaimagen)}}" class="img-fluid" alt="cargando imagen ..."  width= "50px" height="50px">
                              </th>
                              @endif
                              @if($cant->des =="Plata")
                              <th>
                                <!--<i class="fas fa-medal fa-2x" style="color:#C0C0C0;"></i>-->
                                <img src="{{asset('imgpremios/'.$cant->rutaimagen)}}" class="img-fluid" alt="cargando imagen ..."  width= "50px" height="50px">
                              </th>
                              @endif
                              @if($cant->des =="Bronce")
                              <th>
                                <!--<i class="fas fa-medal fa-2x" style="color:#CD7F32;"></i>-->
                                <img src="{{asset('imgpremios/'.$cant->rutaimagen)}}" class="img-fluid" alt="cargando imagen ..."  width= "50px" height="50px">
                              </th>
                              @endif
                            @endforeach
                         
                          </tr>
                        </tbody>
              </table>
             @endif
            <!--end table-->

            </div>
          </div>
        </div>
      </div>
    <!--end tabla estrellas-->  
@endsection
