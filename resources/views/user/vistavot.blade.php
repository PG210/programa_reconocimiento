@extends('usuario.principa_usul')
@section('content')
@include('usuario.datatables')
<!----stylos-->
<div class="container titulo mb-3">
    <h4 class="text-center"><b>VOTACIONES HABILITADAS PERIODO : {{$vot->anio}} - {{$vot->periodo}}</b></h4>
</div>
<!--mensaje-->
@if(Session::has('error_voto'))
<div class="alert alert-dismissible fade show letraform alert-info" role="alert">
<strong>{{Session::get('error_voto')}}</strong> 
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
@endif
<!--end mensaje -->
<div class="container">
<div class="table-responsive">
        <table class="table letraform" id="votacion">
            <thead class="tablaheader">
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">imagen</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Apellido</th>
                  <th scope="col">Cargo</th>
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
                            <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                              <div class="image">
                                  <!---======================= image ============-->
                                  @if($c->imagen!=null && $c->imagen != 'ruta')
                                    <img src="{{asset('dist/imgperfil/'.$c->imagen)}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;">
                                  @endif
                                  @if($c->imagen==null || $c->imagen == 'ruta')
                                    <img src="{{asset('dist/imgperfil/perfil_no_borrar.jpeg')}}" class="img-circle elevation-1" alt="User Image" style="padding-bottom:2px;" >
                                  @endif
                              </div>
                            </div>
                            <!--===========================================-->
                        </td>
                        <td>{{$c->name}}</td>
                        <td>{{$c->apellido}}</td>
                        <td>{{$c->cargos}}</td>
                        <td>
                          <!--modal-->
                          <!-- Button trigger modal -->
                          @if($b!=2)
                          <button type="button" class="btn confirmar" data-toggle="modal" data-target="#modalVot{{$c->idusu}}">
                            Votar
                          </button>
                          @else
                            <a type="button"  class="btn btn-info disabled">Completado</a>
                          @endif

                          <!-- Modal -->
                          <form action="{{route('regvoto')}}" method="POST">
                            @csrf
                          <div class="modal fade" id="modalVot{{$c->idusu}}" tabindex="-1" aria-labelledby="modalVotLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header" style="background-color:#ece9e9;">
                                  <h5 class="modal-title letraform" id="modalVotLabel">VOTAR POR CADA CATEGORÍA</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body letraform">
                                <!--table-->
                                <!--mensaje-->
                                <table class="table table-bordered letraform">
                                    <thead>
                                      <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Categoría</th>
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
                                  <button type="button" class="btn salir" data-dismiss="modal">Salir</button>
                                  @if($b!=2)
                                  <button type="submit" class="btn confirmar">Votar</button>
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
</div>
<script> 
  $('#votacion').DataTable({
      "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
  });
</script>
@endsection
