@extends('usuario.principa_usul')
@section('content')
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
    <div class="row">
        <div class="col-8">
                <a href="/admin/votacion" class="btn text-left" type="button"  aria-controls="collapseOne">
                   <i class="fas fa-home" style="font-size:23px;"></i>
                </a>
                <!-- Button trigger modal -->
                 @if($total!=0)
                    <a href="{{route('listaVot')}}" type="button" class="btn">
                     <i class="fas fa-list-alt" style="font-size:23px;"></i>
                    </a>
                    <!--end buton-->
                    <button type="button" class="btn " data-toggle="modal" data-target="#filtrarvotos">
                        <i class="fas fa-filter" style="font-size:22px;"></i> 
                    </button>
                    <form action="{{route('filtrarVotos')}}" method="POST">
                @csrf
                <!-- Modal -->
                <div class="modal fade" id="filtrarvotos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Seleccionar Año y Periodo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <!---inputs-->
                      <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Año</label>
                                <select class="form-control" id="aniofil" name="aniofil">
                                @foreach($esfil as $fil)
                                <option val="{{$fil->anio}}">{{$fil->anio}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div> 
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Periodo</label>
                                <select class="form-control" id="peri" name="peri">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                </select>
                            </div>
                        </div> 
                      </div>
                      <!--end inputs-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-backward" style="font-size:15px;"></i></button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search" style="font-size:15px;"></i></button>
                    </div>
                    </div>
                </div>
                </div>
             </form>
             @endif
            <!--end button-->
            <!--filtrar por categoria-->
            <!-- Button trigger modal -->
            <!--end filtrar-->
          </div>
          <div class="col-4">
               <!--button-->
               @if(isset($es[0]))
               @if($es[0]->estado==2) 
               <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#staticBackdrop">
                        Habilitar
                </button>
            <!-- Button trigger modal -->
                 <!-- Modal -->
                <form action="{{route('hab_votaciones')}}" method="POST">
                 @csrf
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
                            <div class="container">¿Desea habilitar las votaciones? 
                            </div><br>
                            <div class="row">
                                <div class="col-6">
                                    <label>Año</label>
                                    <input id="anio" name="anio" class="form-control" value="{{$anio}}" readonly="readonly" style="background-color:white;">
                                </div>
                                <div class="col-6">
                                  <label>Periodo</label>
                                  <select class="custom-select" id="per" name="per">
                                    <option selected>Elegir...</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                </select>
                                  <input id="val" name="val" class="form-control" value="1" hidden>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-primary">Si</button>
                        </div>
                        </div>
                    </div>
                    </div>
                  </form>
                  @endif
                  @endif
                @if($total==0) 
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#staticBackdrop">
                            Habilitar
                    </button>
                <!-- Button trigger modal -->
                    <!-- Modal -->
                <form action="{{route('hab_votaciones')}}" method="POST">
                 @csrf
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
                            <div class="container">¿Desea habilitar las votaciones? 
                            </div><br>
                            <div class="row">
                                <div class="col-6">
                                    <label>Año</label>
                                    <input id="anio" name="anio" class="form-control" value="{{$anio}}" readonly="readonly" style="background-color:white;">
                                </div>
                                <div class="col-6">
                                  <label>Periodo</label>
                                  <select class="custom-select" id="per" name="per">
                                    <option selected>Elegir...</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                </select>
                                  <input id="val" name="val" class="form-control" value="1" hidden>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-primary">Si</button>
                        </div>
                        </div>
                    </div>
                    </div>
                  </form>
                  @endif
                <!--end modal-->
                @if(isset($es[0]->estado)==1)
                        <button type="button" class="btn float-right d-none d-sm-none d-md-block" data-toggle="modal" data-target="#staticBackdropvot1" style="background-color:#FFBD03; margin-left:20rem;">
                            Deshabilitar 
                        </button>
                        <button type="button" class="btn float-right d-block d-sm-block d-md-none" data-toggle="modal" data-target="#staticBackdropvot1" style="background-color:#FFBD03;">
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
                                ¿Desea deshabilitar las votaciones {{$es[0]->anio}} {{$es[0]->periodo}}?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                <a href="/deshab/votacion/{{$es[0]->ides}}/2" type="button" class="btn btn-primary">Si</a>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!--end modal-->
                    @endif  
                </div>
         </div>          
       </div>
       @if(Session::has('errorhab'))
        <div class="alert  alert-dismissible fade show" role="alert" style="background-color:#1ED5F4 ;">
        <strong>{{Session::get('errorhab')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
       @endif
       @if(Session::has('errorfitrar'))
        <div class="alert  alert-dismissible fade show" role="alert" style="background-color:#1ED5F4 ;">
        <strong>{{Session::get('errorfitrar')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
       @endif
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <!---table-->
        <div class="table-responsive">
            <table class="table">
                    <thead style="background-color:#FFBD03;">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Periodo</th>
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
                       @if(isset($votos[0]))
                       @foreach($votos as $v)
                        <tr>
                            <td>{{$conta++}}</td>
                            <td>{{$v->anio}}-{{$v->periodo}}</td>
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
                       @endif
                    </tbody>
                </table>
            </div>
        <!--end table-->
      </div>
    </div>
  </div>
</div>
@endsection