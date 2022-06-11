@extends('usuario.principa_usul')
@section('content')
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
    <div class="row">
        <div class="col-6">
            <h2 class="mb-0">
                <a href="/admin/hab/votacion" class="btn btn-block text-left" type="button"  aria-controls="collapseOne">
                <i class="fas fa-home" style="font-size:23px;"></i>
                </a>
            </h2>
        </div>
        <div class="col-6">
              <!-- Button trigger modal -->
              @if($es[0]->estado==2)
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#staticBackdrop">
                    Habilitar
                </button>
                 <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Habilitar Votaciones</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ¿Desea habilitar las votaciones?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            <a href="/admin/hab/votacion/{{$es[0]->ides}}/1" type="button" class="btn btn-primary">Si</a>
                        </div>
                        </div>
                    </div>
                    </div>
                <!--end modal-->
              @endif
              @if($es[0]->estado==1)
                <button type="button" class="btn float-right" data-toggle="modal" data-target="#staticBackdropvot1" style="background-color:#FFBD03 ;">
                    Deshabilitar 
                </button>
                 <!-- Modal -->
               <div class="modal fade" id="staticBackdropvot1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Deshabilitar Votaciones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Desea deshabilitar las votaciones?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                        <a href="/admin/hab/votacion/{{$es[0]->ides}}/2" type="button" class="btn btn-primary">Si</a>
                    </div>
                    </div>
                </div>
                </div>
                <!--end modal-->
              @endif            
        </div>
    </div>
    </div>
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <!---table-->
        <div class="table-responsive">
            <table class="table">
                    <thead style="background-color:#FFBD03;">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">imagen</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Area</th>
                        <th scope="col">Votos</th>
                        <th scope="col">Descripción</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                         $conta=1;
                        ?>
                       @foreach($votos as $v)
                        <tr>
                            <td>{{$conta++}}</td>
                            <td>
                                    @if($v->imagen==NULL)
                                    <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                                        <div class="image">
                                        <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >
                                        </div>
                                    </div>
                                    @endif
                                    @if($v->imagen!=NULL)
                                    <!--imagen-->
                                    <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                                            <div class="image">
                                            <img src="{{asset('dist/imgperfil/'.$v->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width">
                                            </div>
                                    </div>
                                    @endif
                            </td>
                            <td>{{$v->name}}</td>
                            <td>{{$v->apellido}}</td>
                            <td>{{$v->rol}}</td>
                            <td>{{$v->cargos}}</td>
                            <td>{{$v->areas}}</td>
                            <td>{{$v->total}}</td>
                            <td>
                            <!--modal -->
                            <!-- Button trigger modal -->
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop{{$v->idusu}}">
                                      <i class="fas fa-vote-yea"></i>
                                    </button>
                                </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop{{$v->idusu}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header"  style="background-color:#26F8FF;">
                                            <h5 class="modal-title" id="staticBackdropLabel">Detalle de Votos</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        <!---table-->
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Categoria</th>
                                                <th scope="col">Votos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                             <?php 
                                              $vot=1;
                                             ?>
                                              @foreach($cat as $c)
                                              @if($v->idusu == $c->id_postulado)
                                                <tr>
                                                <th scope="row">{{$vot++}}</th>
                                                <td>{{$c->categoria}}</td>
                                                <td>{{$c->total}}</td>
                                                </tr>
                                                @endif
                                              @endforeach
                                            </tbody>
                                            </table>
                                        <!--end table-->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn" data-dismiss="modal" style="background-color:#26F8FF;"><i class="fas fa-sign-out-alt"></i></button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                            <!--end modal-->
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        <!--end table-->
      </div>
    </div>
  </div>
</div>
@endsection