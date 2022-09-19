@extends('usuario.principa_usul')
@section('content')
<div class="accordion" id="accordionExample">
  <div class="card" >
    <div class="card-header" id="headingOne" style="background-color#1BF9CD;">
    <div class="row">
        <div class="col-8">
                <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filtrarcat">
                       <i class="fas fa-list-alt" style="font-size:23px;"></i>
                    </button>
                    <!--end buton-->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filtrarvotos">
                        <i class="fas fa-filter" style="font-size:22px;"></i> 
                    </button>

                 <form action="{{route('filtrarVotos')}}" method="POST">
                @csrf
                <!-- Modal -->
                <div class="modal fade" id="filtrarvotos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header titulo">
                        <h5 class="modal-title" id="exampleModalLabel">Seleccionar Año y Periodo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body letraform">
                      <!---inputs-->
                      <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Año</label>
                                <select class="form-control" id="aniofil" name="aniofil">
                                   @foreach($esfil as $fil)
                                        @if(isset($fil->anio))
                                            <option val="{{$fil->anio}}">{{$fil->anio}}</option>
                                        @endif
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
                        @if(isset($esfil[0]->anio))
                        <button type="submit" class="btn confirmar"><i class="fas fa-search" style="font-size:15px;"></i></button>
                        @endif
                        <button type="button" class="btn salir" data-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
                </div>
             </form>
            <!--end filtrar-->
            <!--filtrar por categoria-->
            <!-- Button trigger modal -->
                <!-- Modal -->
                <form action="{{route('listaVot')}}" method="POST">
                @csrf
                <div class="modal fade" id="filtrarcat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header titulo">
                        <h5 class="modal-title" id="exampleModalLabel">Filtrar Votos Por Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body letraform">
                        <!--mostrar categorias-->
                         <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="categoria">Categoria</label>
                                    <select class="form-control" id="categoria" name="categoria">
                                      @foreach($cat as $c)
                                        @if(isset($c->descripcion))
                                          <option value="{{$c->idcat}}">{{$c->descripcion}}</option>
                                        @endif
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Año</label>
                                    <select class="form-control" id="anio" name="anio">
                                    
                                    @foreach($esfil as $fil)
                                        @if(isset($fil->anio))
                                            <option val="{{$fil->anio}}">{{$fil->anio}}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Periodo</label>
                                    <select class="form-control" id="per" name="per">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    </select>
                                </div>
                            </div>
                         </div>
                        <!--end categorias-->
                    </div>
                    <div class="modal-footer">
                        @if(isset($esfil[0]->anio))
                        <button type="submit" class="btn confirmar"><i class="fas fa-search" style="font-size:15px;"></i></button>
                        @endif
                        <button type="button" class="btn salir" data-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
                </div>
              </form>
            <!--end filtrar por categoria-->
          </div>
          <div class="col-4 letraform">
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
                        <div class="modal-header" style="background-color:#1ED5F4;">
                            <h5 class="modal-title" id="staticBackdropLabel">Votaciones</h5>
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
                            <button type="submit" class="btn confirmar">Si</button>
                            <button type="button" class="btn salir" data-dismiss="modal">No</button>
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
                        <div class="modal-header titulo">
                            <h5 class="modal-title" id="staticBackdropLabel">Votaciones</h5>
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
                            <button type="submit" class="btn confirmar">Si</button>
                            <button type="button" class="btn salir" data-dismiss="modal">No</button>
                        </div>
                        </div>
                    </div>
                    </div>
                  </form>
                  @endif
                <!--end modal-->
                @if(isset($es[0]->estado)==1)
                        <button type="button" class="btn float-right d-none d-sm-none d-md-block" data-toggle="modal" data-target="#staticBackdropvot1" style="background-color:#3190EF; color:white; margin-left:20rem;">
                            Deshabilitar 
                        </button>
                        <button type="button" class="btn float-right d-block d-sm-block d-md-none" data-toggle="modal" data-target="#staticBackdropvot1" style="background-color:#3190EF; color:white;">
                            Deshabilitar 
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdropvot1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header titulo">
                                <h5 class="modal-title" id="staticBackdropLabel">Deshabilitar Votaciones</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ¿Desea deshabilitar las votaciones {{$es[0]->anio}} {{$es[0]->periodo}}?
                            </div>
                            <div class="modal-footer">
                                <a href="/deshab/votacion/{{$es[0]->ides}}/2" type="button" class="btn confirmar">Si</a>
                                <button type="button" class="btn salir" data-dismiss="modal">No</button>
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
       <br>
        <div class="alert  alert-dismissible fade show letraform" role="alert" style="background-color:#1ED5F4 ;">
        <strong>{{Session::get('errorhab')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
       @endif
       @if(Session::has('errorfitrar'))
       <br>
        <div class="alert  alert-dismissible fade show letraform" role="alert" style="background-color:#1ED5F4 ;">
        <strong>{{Session::get('errorfitrar')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
       @endif
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">

      </div>
    </div>
  </div>
</div>
@endsection