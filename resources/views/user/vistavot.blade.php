@extends('usuario.principa_usul')
@section('content')
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
    <!---buscar-->
    <div class="container" >
       <h1 class="text-center">Votaciones Habilitadas Periodo: {{$vot->anio}} - {{$vot->periodo}}</h1><br>
    </div>
    <div class="container">
        <br>
        <form action="{{route('buscar_votante')}}" method="POST">
         @csrf
            <div class="row">
                <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Ingrese Nombre" id="dato" name="dato">
                </div>
                <div class="col-md-2">
                <button class="btn float-left" type="submit" style="background-color:#06E17A;"><i class="fas fa-search" style="font-size:20px;"></i></button>
                &nbsp;&nbsp;&nbsp;&nbsp;<a href="/vista/votacion" class="btn  float-center" type="button" style="background-color:#06E17A;"><i class="fas fa-undo-alt" style="font-size:20px;"></i></a>
                </div>
            </div>
            </form>
    </div>
    <br>
   <!--end buscar-->     
    </div>
    <div class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
    <!--table--> 
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
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
                <?php
                $conta=1;
                ?>
               
                @foreach($usu as $c)
                        <tr>
                        <th scope="row">{{$conta++}}</th>
                        <td>
                            @if($c->imagen==NULL)
                            <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                                <div class="image">
                                <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >
                                </div>
                            </div>
                            @endif
                            @if($c->imagen!=NULL)
                             <!--imagen-->
                            <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                                    <div class="image">
                                    <img src="{{asset('dist/imgperfil/'.$c->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px; width">
                                    </div>
                            </div>
                            @endif
                        </td>
                        <td>{{$c->name}}</td>
                        <td>{{$c->apellido}}</td>
                        <td>{{$c->rol}}</td>
                        <td>{{$c->cargos}}</td>
                        <td>{{$c->areas}}</td>
                        <td>
                          <!--modal-->
                          <!-- Button trigger modal -->
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalVot{{$c->idusu}}">
                            Votar
                          </button>

                          <!-- Modal -->
                          <form action="{{route('regvoto')}}" method="POST">
                            @csrf
                          <div class="modal fade" id="modalVot{{$c->idusu}}" tabindex="-1" aria-labelledby="modalVotLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header" style="background-color:#08FFD5;">
                                  <h5 class="modal-title" id="modalVotLabel">Votar por cada categoria</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                <!--table-->
                                @if(Session::has('error_voto'))
                                  <div class="alert  alert-dismissible fade show" role="alert" style="background-color:#FFBD03;">
                                  <strong>{{Session::get('error_voto')}}</strong> 
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                  </div>
                                  @endif
                                <!--mensaje-->
                                <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Estado</th>
                                      </tr>
                                    </thead>
                                    <tbody> 
                                      @if($b==0)
                                      @foreach($cat as $ca) 
                                      <tr>
                                        <th scope="row">{{$ca->idcat}}</th>
                                        <td>
                                            {{$ca->catdes}}
                                        </td>
                                        <th>
                                           <!--check buttons-->
                                    
                                              <div class="form-check text-center">
                                                <input class="form-check-input" type="checkbox" value="{{$ca->idcat}}" id="defaultCheck1{{$ca->idcat}}" name="datos[]">
                                              </div>
                                           <!--
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" disabled>
                                                <label class="form-check-label" for="defaultCheck2">
                                                  Disabled checkbox
                                                </label>
                                              </div>-->
                                           <!--end check-->
                                        </th>
                                      </tr>
                                      @endforeach
                                      @endif
                                      @if($b==1 && $cat!=0)
                                      <?php
                                         
                                          $con=1;
                                          for($i=0;$i<count($cat);$i++) {
                                              for($j=0;$j<count($cat[$i]);$j++) {
                                              echo '<tr>
                                                      <td>'.$con++.'</td>
                                                      <td>'.$cat[$i][$j]->descripcion.'</td>
                                                      <td><div class="form-check">
                                                          <input class="form-check-input" type="checkbox" value="' .$cat[$i][$j]->id. '" id="defaultCheck1' .$cat[$i][$j]->id. '" name="datos[]">
                                                          </div>
                                                      </td>
                                                  </tr>';
                                            }
                                          }
                                          ?>
                                      @endif
                                    </tbody>
                                  </table>
                                <!--end table-->
                                <input value="{{$vot->idvot}}" name="idvot" id="idvot" hidden>
                                <input value="{{$c->idusu}}" name="idpos" id="idpos" hidden>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn" data-dismiss="modal" style="background-color:#FFBD03;">Salir</button>
                                  @if($b!=2)
                                  <button type="submit" class="btn btn-primary">Guardar</button>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>
                          </form>
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